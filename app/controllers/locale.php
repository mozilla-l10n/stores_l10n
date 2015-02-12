<?php
namespace Play;

$actions = ['html', 'show', 'status'];
$components = explode('/', $url['path']);
// We no longer need the locale/ part of the url
array_shift($components);

if (! in_array($components[0], $android_locales_release)) {
    die("Not a locale code supported by Firefox");
} else {
    $locale = $components[0];
}

if (isset($components[1]) && ! in_array($components[1], $actions)) {
    die("This is not a view that can yied results");
}

$title = "Google Play Description for: {$locale}";

if (! isset($components[1])) {
    $components[1] = 'show';
}

switch ($components[1]) {
    case 'show':
        $view  = 'locale';
        $template = 'html.php';
        break;
    case 'html':
        $view  = 'locale_escaped';
        $template = 'html.php';
        break;
    default:
        $view = 'locale';
        break;
}

include MODELS . 'locale_model.php';

ob_start();
include APP . 'views/' . $view . '_view.php';
$content = ob_get_contents();
ob_end_clean();

include TEMPLATES . $template;
