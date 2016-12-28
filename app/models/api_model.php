<?php
namespace Stores;

// Shortcut variables to make the code easier to read
$json = $done = [];
$channel = isset($request->query['channel']) ? $request->query['channel'] : '';
$locale = isset($request->query['locale']) ? $request->query['locale'] : '';
$store = $request->query['store'];
$product = $request->query['product'];
$product_locales = $project->getProductLocales($product, $channel);

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
    $template_locales = $project->getStoreMozillaCommonLocales($product, $channel);
    foreach ($template_locales as $template_locale) {
        $translations = new Translate($template_locale, $project->getListingFiles($product, $channel), LOCALES_PATH);
        if ($translations->isFileTranslated()) {
            // Include the current template
            require TEMPLATES . $project->getTemplate($product, $channel);

            switch ($store) {
                case 'google':
                    $desc = $set_limit('google_description', $description($translations));
                    $title = $set_limit('google_title', $app_title($translations));
                    $short_desc = $set_limit('google_short_description', $short_desc($translations));

                    if (($desc + $title + $short_desc) == 3) {
                        $done[] = $template_locale;
                    }
                    break;
                case 'apple':
                    if ($set_limit('apple_keywords', $keywords($translations))) {
                        $done[] = $template_locale;
                    }
                    break;
                default:
                    break;
            }
        }
    }
    $listing_json = $done;

    /*
        By default, we consider whatsnew identical to listing, this way we ignore it
        in the Done API when we intersect the arrays.
    */
    $whatsnew_json = $listing_json;

    $done = [];
    foreach ($template_locales as $template_locale) {
        $translations = new Translate($template_locale, $project->getWhatsnewFiles($product, $channel), LOCALES_PATH);

        if ($translations->isFileTranslated()) {
            // Include the current template
            require TEMPLATES . $project->getTemplate($product, $channel);

            switch ($store) {
                case 'google':
                    if ($set_limit('google_whatsnew', $whatsnew($translations))) {
                        $done[] = $template_locale;
                    }
                    break;
                case 'apple':
                    $done[] = $template_locale;
                    break;
                default:
                    break;
            }
        }
    }
    $whatsnew_json = $done;
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
