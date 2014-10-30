<?php
namespace Play;

if (isset($_GET['locale']) && in_array($_GET['locale'], $android_locales)) {
    $case = 'locale';
} else {
    $case = 'home';
}

switch($case) {
    case 'home':
        $title = 'Google Play Description';
        $model = 'home';
        $view  = 'home';
        $locale = false;
        break;
    case 'locale':
        $locale = $_GET['locale'];
        $title = "Google Play Description for: {$locale}";
        $model = 'locale';
        $view = 'locale';
        // Another output for the view?
        if (isset($_GET['output'])) {
            switch($_GET['output']) {
                case 'json':
                    $view = 'locale_json';
                    $raw_output = true;
                    break;
                case 'html':
                    $view = 'locale_escaped';
                    break;
                default:
                    $view = 'locale';
                    break;
            }
        }
        break;
    default:
        $title = 'Google Play Description';
        $model = 'home';
        $locale = false;
        break;
}

include APP_ROOT .'models/' . $model . '_model.php';
ob_start();
include include APP_ROOT .'views/' . $view . '_view.php';
$content = ob_get_contents();
ob_end_clean();

// Output final page, in a template if necessary
if ($raw_output) {
    die($content);
} else {
    include APP_ROOT .'templates/template.php';
}
