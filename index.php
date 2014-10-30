<?php
namespace Play;
require_once __DIR__ . '/vendor/autoload.php';

$android_locales = ['an', 'as', 'be', 'bn-IN', 'ca', 'cs', 'cy', 'da', 'de',
                    'es-AR', 'es-ES', 'es-MX', 'et', 'eu', 'fi', 'ff', 'fr',
                    'fy-NL', 'ga-IE', 'gd', 'gl' ,'gu-IN', 'hi-IN', 'hu',
                    'hy-AM', 'id', 'is', 'it', 'ja', 'kk', 'kn', 'ko', 'lt',
                    'lv', 'ml', 'mr', 'ms', 'nb-NO', 'nl', 'or', 'pa-IN',
                    'pl', 'pt-BR', 'pt-PT', 'ro', 'ru', 'sq', 'sk', 'sl',
                    'sv-SE', 'ta', 'te', 'th', 'tr', 'uk', 'zh-CN', 'zh-TW'];

if (isset($_GET['locale']) && in_array($_GET['locale'], $android_locales)) {
    $locale = $_GET['locale'];
} else {
    $locale = false;
}

if (! $locale) {
    foreach($android_locales as $locale_code) {
        print "<a href='./?locale={$locale_code}'>{$locale_code}</a>, ";
    }
    die;
}


$file      = 'description_page.lang';
$translate = new Translate($locale, $file);

$_ = function($string, $replacements = false) use($translate) {
    $string = $translate->get($string);
    if (is_array($replacements)) {
        $string = str_replace(array_keys($replacements), array_values($replacements), $string);
    }

    return $string;
};

// Include the current template
require_once __DIR__ . '/templates/listing_nov_2014.php';

if (! isset($_GET['json'])) {
    print $output($translate);
} else {
    print \Transvision\Json::output([$output($translate)], false, true);
}
