<?php
namespace Play;

// API

$actions = ['play_locales', 'firefox_locales', 'locale_mapping', 'done', 'locale'];

$action = false;

foreach($actions as $get) {
    if (isset($_GET[$get])) {
        $action = $get;
        break;
    }
}

// No Get parameter, let's display the documentation to the API
if (empty($_GET)) {
    $action = 'documentation';
}

switch($action) {
    case 'play_locales':
        $view = 'play_json';
        break;
    case 'firefox_locales':
        $locales = include MODELS . 'api/locales_per_channel_model.php';
        $view = 'locale_list_json';
        break;
    case 'locale_mapping':
        if (isset($_GET['reverse'])) {
            $mapping = array_flip(array_filter($locale_mapping));
        } else {
            $mapping = $locale_mapping;
        }
        $view = 'locale_mapping_json';
        break;
    case 'done':
        $done = include MODELS . 'api/done_model.php';
        $view ='locales_done_json';
        break;
    case 'documentation':
        $raw_output = false;
        $title = 'Google Play l10n - JSON API description';
        $view = 'api_documentation';
        break;
    case 'locale':
        $json = include MODELS . 'api/locale_model.php';
        $view = 'locale_json';
        break;
    default:
        http_response_code(400);
        die(\Transvision\Json::output(['error' => 'Not a valid API call.'], false, true));
        break;
}
