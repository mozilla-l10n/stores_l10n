<?php
namespace Stores;

// Shortcut variables to make the code easier to read
$json = $done = [];
$channel = isset($request->query['channel']) ? $request->query['channel'] : '';
$locale = isset($request->query['locale']) ? $request->query['locale'] : '';
$product_version = isset($request->query['version']) ? $request->query['version'] : '';
$store = $request->query['store'];
$product = $request->query['product'];
$service = $request->getService();

if ($request->isTranslationRequired()) {
    /*
        The Done API returns the status of a locale which can have multiple files
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
        // Consider en-US complete and move to next locale
        if ($template_locale == 'en-US') {
            $done[] = $template_locale;
            continue;
        }
        $translations = new Translate(
            $template_locale,
            $project->getLangFiles($template_locale, $product, $channel, 'listing'),
            LOCALES_PATH);
        if ($translations->isFileTranslated()) {
            // Include the current template
            require TEMPLATES . $project->getTemplate($template_locale, $product, $channel);

            switch ($store) {
                case 'google':
                    $desc_status = $set_limit('google_description', $description($translations));
                    $title_status = $set_limit('google_title', $app_title($translations));
                    $short_desc_status = $set_limit('google_short_description', $short_desc($translations));
                    $overall_status = $desc_status + $title_status + $short_desc_status;
                    if ($overall_status == 3) {
                        $done[] = $template_locale;
                    }
                    break;
                case 'apple':
                    $keywords_status = $set_limit('apple_keywords', $keywords($translations));
                    $title_status = $set_limit('apple_title', $app_title($translations));
                    $subtitle_status = $set_limit('apple_subtitle', $app_subtitle($translations));
                    $overall_status = $keywords_status + $title_status + $subtitle_status;
                    if ($overall_status == 3) {
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
        // Consider en-US complete and move to next locale
        if ($template_locale == 'en-US') {
            $done[] = $template_locale;
            continue;
        }

        $translations = new Translate(
            $template_locale,
            $project->getLangFiles($template_locale, $product, $channel, 'whatsnew'),
            LOCALES_PATH);
        if ($translations->isFileTranslated()) {
            // Include the current template
            require TEMPLATES . $project->getTemplate($template_locale, $product, $channel);

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
    if ($done != ['en-US']) {
        $whatsnew_json = $done;
    }
}

switch ($service) {
    case 'storelocales':
        $json = $project->getStoreLocales($store);
        break;
    case 'supportedlocales':
        $json = $project->getProductLocales($product, $channel);
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

        if ($product_version == '') {
            // There is no numeric version specified, so it's a standard
            // translation API request, i.e. {product}/translation/{channel}/{locale}
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
                    'subtitle'    => $app_subtitle($translations),
                    'description' => strip_tags(br2nl($description($translations))),
                    'keywords'    => $keywords($translations),
                ];
            }
        }

        /*
            Always expose a "whatsnew" key in the JSON file, leave it empty in
            case there's no content for this version.

            For requests like {product}/translation/{version_number}/{locale}
            it's going to be the only content returned.
        */
        $json['whatsnew'] = isset($whatsnew)
            ? $whatsnew($translations)
            : '';
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
