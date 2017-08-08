<?php
namespace Stores;

$product = $request['product'];
$channel = $request['channel'];
$template_locales = $project->getStoreMozillaCommonLocales($product, $channel);
$locales_mapping = $project->getLocalesMapping($project->getProductStore($product), true);

$whatsnew_content = '';
foreach ($template_locales as $template_locale) {
    $translations = new Translate(
        $template_locale,
        $project->getLangFiles($template_locale, $product, $channel, 'whatsnew'),
        LOCALES_PATH);
    // Include en-US and all translated locales
    if ($translations->isFileTranslated() or $template_locale == 'en-US') {
        // Include the current template
        require TEMPLATES . $project->getTemplate($template_locale, $product, $channel);

        if ($set_limit('google_whatsnew', $whatsnew($translations))) {
            $whatsnew_content .= "<{$locales_mapping[$template_locale]}>\n"
            . $whatsnew($translations)
            . "\n</{$locales_mapping[$template_locale]}>\n\n";
        }
    }
}
