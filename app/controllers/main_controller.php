<?php
namespace Play;

if (! isset($model)) {
    $model = '404';
}

// By default, we want to output our data in a template
$raw_output = false;

switch($model) {
    case 'home':
        $title = 'Google Play l10n - Overview';
        $model = 'home';
        $view  = 'home';
        break;
    case 'locale':
        if (isset($_GET['code']) && in_array($_GET['code'], $android_locales_release)) {
            $locale = $_GET['code'];
        } else {
            die('No valid locale code provided.');
        }

        $title = "Google Play Description for: {$locale}";
        $view = 'locale';

        // Another output for the view?
        if (isset($_GET['output'])) {
            switch($_GET['output']) {
                case 'html':
                    $view = 'locale_escaped';
                    break;
                default:
                    $view = 'locale';
                    break;
            }
        }
        break;
    case 'api':
        $raw_output = true;
        $view = 'json';
        break;
    default:
        $title = 'Google Play Description';
        $locale = false;
        break;
}

if ($model) {
    include APP_ROOT .'models/' . $model . '_model.php';
}

ob_start();
include APP_ROOT . 'views/' . $view . '_view.php';
$content = ob_get_contents();
ob_end_clean();

// Output final page, in a template if necessary
if ($raw_output) {
    die($content);
} else {
    include APP_ROOT .'templates/html.php';
}
