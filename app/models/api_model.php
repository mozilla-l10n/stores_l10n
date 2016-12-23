<?php
namespace Stores;

// Shortcut variables to make the code easier to read
$json = $done = [];
$channel           = isset($request->query['channel']) ? $request->query['channel'] : '';
$locale            = isset($request->query['locale']) ? $request->query['locale'] : '';
$store             = isset($request->query['store']) ? $request->query['store'] : '';
$firefox_locales   = $project->getFirefoxLocales($store, $channel);
$supported_locales = array_unique(array_values($project->getLocalesMapping($store)));
$valid_locales = function ($done) use ($supported_locales) {
    return array_values(array_intersect($done, $supported_locales));
};

/*
    The Done API returns the status of a locale which can have mutiple files
    to translate. Specifically, for Google channels, localizers should
    translate the listing page on Google Play but also periodically a file that
    contains strings for the What's New pane.

    For this reason, we start by computing both the state of the listing and
    whatsnew APIs before the switch so as to be able to just add a 'done' case
    in the switch that is the intersection of both the listing and whatsnew
    lists.
*/
foreach ($firefox_locales as $lang) {
    /*
        IOSHACK:
        Here we have a hack to change the list of lang files supported for
        iOS because screenshots for Firefox iOS v3 will be created only for
        a subset of locales. It would break if we add multiple lang files
        for Google but this is the best we can do for now.
     */
     $original_lang_files = $project->templates['apple']['release']['langfile'];
    if ($store == 'apple') {
        $needs_v3_screenshots = in_array($lang, $project->ios_v3_screenshots);
        if (! $needs_v3_screenshots && is_array($project->templates['apple']['release']['langfile'])) {
            $project->templates['apple']['release']['langfile'] = array_diff(
                $project->templates['apple']['release']['langfile'],
                ['apple_screenshots_v3.lang']
            );
        }
    }

    $translations = new Translate($lang, $project->getListingFiles($store, $channel));
    $project->templates['apple']['release']['langfile'] = $original_lang_files; //IOSHACK
    $translations::$log_errors = false;

    if ($translations->isFileTranslated()) {
        require TEMPLATES . $project->getTemplate($store, $channel);
        // The Google Store has string lengths constraints
        if ($store == 'google') {
            $desc       = $set_limit(4000, $description($translations));
            $title      = $set_limit(30, $app_title($translations));
            $short_desc = $set_limit(80, $short_desc($translations));

            if (($desc + $title + $short_desc) == 3) {
                $done[] = $lang;
            }
        }

        // The Apple AppStore has keywords lengths constraints
        if ($store == 'apple') {
            if ($set_limit(100, $keywords($translations))) {
                $done[] = $lang;
            }
        }
    }
}
$listing_json = $valid_locales($done);

/*
    By default, we consider whatsnew identical to listing, this way we ignore it
    in the Done API when we intersect the arrays.
*/
$whatsnew_json = $listing_json;

$done = [];
foreach ($firefox_locales as $lang) {
    $translations = new Translate($lang, $project->getWhatsnewFiles($store, $channel));
    $translations::$log_errors = false;

    if ($translations->isFileTranslated()) {
        // Include the current template
        require TEMPLATES . $project->getTemplate($store, $channel);

        switch ($store) {
            case 'google':
                /*
                    Only Google has a 500 characters limit for the What's
                    New section.
                */
                if ($set_limit(500, $whatsnew($translations))) {
                    $done[] = $lang;
                }
                break;
            case 'apple':
                $done[] = $lang;
                break;
            default:
                break;
        }
    }
}
$whatsnew_json = $valid_locales($done);

switch ($request->getService()) {
    case 'storelocales':
        $json = $project->getStoreLocales($store);
        break;
    case 'firefoxlocales':
        $json = $firefox_locales;
        break;
    case 'localesmapping':
        $json = $project->getLocalesMapping($store, isset($_GET['reverse']));
        break;
    case 'translation':
        $request = [
            'locale'  => $locale,
            'store'   => $store,
            'channel' => $channel,
        ];

        require MODELS . 'locale_model.php';

        if ($store == 'google') {
            $json = [
                'title'      => $app_title($translations),
                'short_desc' => $short_desc($translations),
                'long_desc'  => str_replace(["\r", "\n"], "\n", $description($translations)),
            ];
        }

        if ($store == 'apple') {
            $json = [
                'title'       => $app_title($translations),
                'description' => strip_tags(br2nl($description($translations))),
                'keywords'    => $keywords($translations),
                'screenshots' => $screenshots_api,
            ];
        }

        // Do we have a Whatsnew file for this release ?
        if (isset($whatsnew)) {
            $json['whatsnew'] = $whatsnew($translations);
        }
        break;
    case 'whatsnew':
        $json = $whatsnew_json;
        break;
    case 'listing':
        $json = $listing_json;
        break;
    case 'done':
        $json = array_values(array_intersect($listing_json, $whatsnew_json));
        break;
    default:
        $request->error = 'Not a valid API call.';
        $json = $request->invalidAPICall();
        break;
}

$json = $response->outputContent($json);
