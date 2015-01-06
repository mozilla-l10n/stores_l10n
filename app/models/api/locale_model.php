<?php
namespace Play;

if (isset($_GET['locale']) && in_array($_GET['locale'], $android_locales_release)) {
    $locale = $_GET['locale'];
} else {
    http_response_code(400);
    return $json = ['error' => 'No valid locale code provided.'];
}

include MODELS . 'locale_model.php';

return $json = [
    'title' => $app_title($translate),
    'short_desc' => $short_desc($translate),
    'long_desc'  => str_replace(["\r", "\n"], '', $description($translate)),
];
