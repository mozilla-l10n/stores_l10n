<?php
namespace Play;

// API

$actions = ['play_locales', 'firefox_locales', 'locale_mapping', 'done', 'locale'];

$action = 'documentation';

foreach($actions as $get) {
    if (isset($_GET[$get])) {
        $action = $get;
        break;
    }
}

switch($action) {
    case 'play_locales':
        $view = 'play_json';
        break;
    case 'firefox_locales':
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
        break;
}
