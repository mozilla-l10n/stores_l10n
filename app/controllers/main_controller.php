<?php
namespace Play;

if (isset($_GET['locale']) && in_array($_GET['locale'], $android_locales)) {
    $case = 'locale';
} else {
    $case = 'home';
}

switch($case) {
    case 'home':
        $model = 'home';
        $view  = 'home';
        $locale = false;
        break;
    case 'locale':
        $model = 'locale';
        $view = 'locale';
        // Another output for the view?
        if (isset($_GET['output'])) {
            switch($_GET['output']) {
                case 'json':
                    $view = 'locale_json';
                    break;
                case 'html':
                    $view = 'locale_escaped';
                    break;
                default:
                    $view = 'locale';
                    break;
            }
        }
        $locale = $_GET['locale'];
        break;
    default:
        $model = 'home';
        $locale = false;
        break;
}

include APP_ROOT .'models/' . $model . '_model.php';
include APP_ROOT .'views/' . $view . '_view.php';
