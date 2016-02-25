<?php
namespace Stores;

// Shortcut variables to make the code easier to read
$channel           = isset($request->query['channel']) ? $request->query['channel'] : '';
$locale            = isset($request->query['locale']) ? $request->query['locale'] : '';
$store             = isset($request->query['store']) ? $request->query['store'] : '';
$firefox_locales   = $project->getFirefoxLocales($store, $channel);
$supported_locales = array_unique(array_values($project->getLocalesMapping($store)));
$valid_locales = function ($done) use ($supported_locales) {
    return array_values(array_intersect($done, $supported_locales));
};

$json = $done = [];

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

        include MODELS . 'locale_model.php';

        if ($store == 'google') {
            $json = [
                'title'      => $app_title($translations),
                'short_desc' => $short_desc($translations),
                'long_desc'  => str_replace(["\r", "\n"], "\n", $description($translations)),
            ];

            // Do we have a Whatsnew file for this release ?
            if (isset($whatsnew)) {
                $json['whatsnew'] = $whatsnew($translations);
            }
        }

        if ($store == 'apple') {
            $json = [
                'title'       => $app_title($translations),
                'description' => strip_tags(br2nl($description($translations))),
                'keywords'    => $keywords($translations),
                'screenshots' => $screenshots_api,
            ];
        }
        break;
    case 'whatsnew':
        foreach ($firefox_locales as $lang) {
            $translations = new Translate(
                $lang,
                $project->getWhatsnewFiles($store, $channel)
            );

            $translations::$log_errors = false;

            if ($translations->isFileTranslated()) {
                // Include the current template
                require TEMPLATES . $project->getTemplate($store, $channel);

                // Google has a 500 characters limit for the What's New section
                if ($store == 'google' && $set_limit(500, $whatsnew($translations))) {
                    $done[] = $lang;
                }
            }
        }

        $json = $valid_locales($done);
        break;
    case 'listing':
        foreach ($firefox_locales as $lang) {
            $translations = new Translate($lang, $project->getListingFiles($store, $channel));
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

        $json = $valid_locales($done);
        break;
    default:
        $request->error = 'Not a valid API call.';
        $json = $request->invalidAPICall();
        break;
}

$json = $response->output($json);
