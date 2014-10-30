<?php

define('APP_ROOT', realpath(__DIR__ . '/../') . '/');
define('WEB_ROOT', realpath(__DIR__ . '/../../web/') . '/');
define('LOCALES', realpath(__DIR__ .'/../../locales') . '/');

$android_locales = [
    'an', 'as', 'be', 'bn-IN', 'ca', 'cs', 'cy', 'da', 'de',
    'es-AR', 'es-ES', 'es-MX', 'et', 'eu', 'fi', 'ff', 'fr',
    'fy-NL', 'ga-IE', 'gd', 'gl' ,'gu-IN', 'hi-IN', 'hu',
    'hy-AM', 'id', 'is', 'it', 'ja', 'kk', 'kn', 'ko', 'lt',
    'lv', 'ml', 'mr', 'ms', 'nb-NO', 'nl', 'or', 'pa-IN',
    'pl', 'pt-BR', 'pt-PT', 'ro', 'ru', 'sq', 'sk', 'sl',
    'sv-SE', 'ta', 'te', 'th', 'tr', 'uk', 'zh-CN', 'zh-TW'
];

$current_template = 'listing_nov_2014.php';
