<?php
namespace Stores;

// Shortcut variables to make the code easier to read
$json = $done = [];
$channel = isset($request->query['channel']) ? $request->query['channel'] : '';
$locale = isset($request->query['locale']) ? $request->query['locale'] : '';
$store = $request->query['store'];
$product = $request->query['product'];
$product_locales = $project->getProductLocales($product, $channel);
$supported_locales = array_unique(array_values($project->getLocalesMapping($store)));
$valid_locales = function ($done) use ($supported_locales) {
    return array_values(array_intersect($done, $supported_locales));
};

if ($request->query_type == 'product') {
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
    foreach ($product_locales as $lang) {
        $translations = new Translate($lang, $project->getListingFiles($product, $channel));

        if ($translations->isFileTranslated()) {
            require TEMPLATES . $project->getTemplate($product, $channel);
            // The Google Store has string lengths constraints
            if ($store == 'google') {
                $desc = $set_limit('google_description', $description($translations));
                $title = $set_limit('google_title', $app_title($translations));
                $short_desc = $set_limit('google_short_description', $short_desc($translations));

                if (($desc + $title + $short_desc) == 3) {
                    $done[] = $lang;
                }
            }

            // The Apple App Store has keywords lengths constraints
            if ($store == 'apple') {
                if ($set_limit('apple_keywords', $keywords($translations))) {
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
    foreach ($product_locales as $lang) {
        $translations = new Translate($lang, $project->getWhatsnewFiles($product, $channel));

        if ($translations->isFileTranslated()) {
            // Include the current template
            require TEMPLATES . $project->getTemplate($product, $channel);

            switch ($store) {
                case 'google':
                    /*
                        Only Google has a 500 characters limit for the What's
                        New section.
                    */
                    if ($set_limit('google_whatsnew', $whatsnew($translations))) {
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
}

switch ($request->getService()) {
    case 'storelocales':
        $json = $project->getStoreLocales($store);
        break;
    case 'firefoxlocales': // Legacy
    case 'productlocales':
        $json = $product_locales;
        break;
    case 'localesmapping':
        $json = $project->getLocalesMapping($store, isset($_GET['reverse']));
        break;
    case 'translation':
        $request = [
            'locale'  => $locale,
            'product' => $product,
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
