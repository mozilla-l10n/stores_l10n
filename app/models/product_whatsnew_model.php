<?php
namespace Stores;

$product = $request['product'];
$channel = $request['channel'];
$template_locales = $project->getStoreMozillaCommonLocales($product, $channel);
$locales_mapping = $project->getLocalesMapping($project->getProductStore($product), true);

// Check the list of locales with fully localized listing
$listing_translated = [];
foreach ($template_locales as $template_locale) {
    // Consider en-US complete and move to next locale
    if ($template_locale == 'en-US') {
        $listing_translated[] = $template_locale;
        continue;
    }
    $translations = new Translate(
        $template_locale,
        $project->getLangFiles($template_locale, $product, $channel, 'listing'),
        LOCALES_PATH);
    if ($translations->isFileTranslated()) {
        // Include the current template
        require TEMPLATES . $project->getTemplate($template_locale, $product, $channel);

        // Check Play Store limits
        $app_desc = $set_limit('google_description', $description($translations));
        $app_title = $set_limit('google_title', $app_title($translations));
        $short_desc = $set_limit('google_short_description', $short_desc($translations));

        if (($app_desc + $app_title + $short_desc) == 3) {
            $listing_translated[] = $template_locale;
        }
    }
}

$whatsnew_content = '';
foreach ($template_locales as $template_locale) {
    $translations = new Translate(
        $template_locale,
        $project->getLangFiles($template_locale, $product, $channel, 'whatsnew'),
        LOCALES_PATH);
    // Include en-US and all translated locales
    $whatsnew_translated = ($template_locale == 'en-US') || $translations->isFileTranslated();

    if ($whatsnew_translated && in_array($template_locale, $listing_translated)) {
        // Include the current template
        require TEMPLATES . $project->getTemplate($template_locale, $product, $channel);

        if ($set_limit('google_whatsnew', $whatsnew($translations))) {
            $whatsnew_content .= "<{$locales_mapping[$template_locale]}>\n"
            . $whatsnew($translations)
            . "\n</{$locales_mapping[$template_locale]}>\n\n";
        }
    }
}
