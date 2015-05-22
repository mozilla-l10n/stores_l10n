<?php
namespace Stores;

// format of an URL: http://localhost:8082/locale/de/google/beta/output/

$formats = ['html', 'show', 'status'];
$components = explode('/', $url['path']);

$request = [
    'locale'  => isset($components[1]) ? $components[1] : null,
    'store'   => isset($components[2]) ? $components[2] : null,
    'channel' => isset($components[3]) ? $components[3] : null,
    'output'  => isset($components[4]) ? $components[4] : null,
];

if (! in_array($request['store'], ['google', 'apple'])) {
    die('Unknown marketplace provider.');
}

if (! in_array($request['channel'], ['beta', 'release'])) {
    die('This Firefox channel is not supported.');
}

if ($request['store'] == 'google') {
    switch ($request['channel']) {
        case 'beta':
            $locales = $project->getGoogleMozillaCommonLocales('beta');
            break;
        case 'release':
        default:
            $locales = $project->getGoogleMozillaCommonLocales('release');
            break;
    }
}

if ($request['store'] == 'apple') {
    switch ($request['channel']) {
        case 'release':
        default:
            $locales = $project->getAppleMozillaCommonLocales('release');
            break;
    }
}

if (! in_array($request['locale'], $locales)) {
    die('Not a locale code supported by Firefox');
}

$title = "Store Description for: {$request['locale']}";

if (! isset($request['output'])) {
    $request['output'] = 'show';
}

switch ($request['output']) {
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
include VIEWS . $view . '_view.php';
