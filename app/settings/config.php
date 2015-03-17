<?php

define('APP_ROOT', realpath(__DIR__ . '/../') . '/');
define('WEB_ROOT', realpath(__DIR__ . '/../../web/') . '/');
define('LOCALES', realpath(__DIR__ . '/../../locales') . '/');

// Source : http://hg.mozilla.org/releases/mozilla-release/raw-file/tip/mobile/android/locales/maemo-locales
// Source : http://hg.mozilla.org/releases/mozilla-beta/raw-file/tip/mobile/android/locales/maemo-locales
// Source : http://hg.mozilla.org/releases/mozilla-aurora/raw-file/tip/mobile/android/locales/maemo-locales
$android_locales_release = [
    'an', 'as', 'be', 'bn-IN', 'ca', 'cs', 'cy', 'da', 'de',
    'es-AR', 'es-ES', 'es-MX', 'et', 'eu', 'fi', 'ff', 'fr',
    'fy-NL', 'ga-IE', 'gd', 'gl' ,'gu-IN', 'hi-IN', 'hu',
    'hy-AM', 'id', 'is', 'it', 'ja', 'kk', 'kn', 'ko', 'lt',
    'lv', 'ml', 'mr', 'ms', 'nb-NO', 'nl', 'or', 'pa-IN',
    'pl', 'pt-BR', 'pt-PT', 'ro', 'ru', 'sq', 'sk', 'sl',
    'sv-SE', 'ta', 'te', 'th', 'tr', 'uk', 'zh-CN', 'zh-TW',
];

// As of 2015-01-06, the 3 channels above have exactly the same locales list
$android_locales_aurora = $android_locales_beta = $android_locales_release;

$current_template = [
    'November 2014' => 'release/listing_nov_2014.php',
];

$locale_mapping = [
    'af'     => 'af',
    'ar'     => 'ar',
    'am'     => false,
    'be'     => 'be',
    'bg'     => 'bg',
    'cs-CZ'  => 'cs',
    'ca'     => 'ca',
    'da-DK'  => 'da',
    'de-DE'  => 'de',
    'el-GR'  => 'el',
    'en-GB'  => 'en-GB',
    'es-419' => 'es-MX', // Spanish, South America
    'es-ES'  => 'es-ES',
    'es-US'  => 'es-MX', // Spanish, South America
    'et'     => 'et',
    'fa'     => 'fa',
    'fi-FI'  => 'fi',
    'fil'    => false, // Filipino
    'fr-CA'  => 'fr',
    'fr-FR'  => 'fr',
    'hi-IN'  => 'hi-IN',
    'hu-HU'  => 'hu',
    'hr'     => 'hr',
    'id'     => 'id',
    'it-IT'  => 'it',
    'iw-IL'  => 'he',
    'ja-JP'  => 'ja',
    'ko-KR'  => 'ko',
    'lt'     => 'lt',
    'lv'     => 'lv',
    'ms'     => 'ms',
    'nl-NL'  => 'nl',
    'no-NO'  => 'nb-NO',
    'pl-PL'  => 'pl',
    'pt-BR'  => 'pt-BR',
    'pt-PT'  => 'pt-PT',
    'rm'     => 'rm',
    'ro'     => 'ro',
    'ru-RU'  => 'ru',
    'sk'     => 'sk',
    'sl'     => 'sl',
    'sr'     => 'sr',
    'sv-SE'  => 'sv-SE',
    'sw'     => 'sw',
    'th'     => 'th',
    'tr-TR'  => 'tr',
    'uk'     => 'uk',
    'vi'     => 'vi',
    'zh-CN'  => 'zh-CN',
    'zh-TW'  => 'zh-TW',
    'zu'     => 'zu',
];

$play_locales = array_keys($locale_mapping);

$google_mozilla_supported = array_intersect($android_locales_release, array_values(array_filter($locale_mapping)));
