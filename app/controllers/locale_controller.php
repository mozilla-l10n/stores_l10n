<?php
namespace Stores;

// URL format: /locale/de/google/beta/html/
$components = explode('/', $url['path']);
$output_options = ['html', 'show'];

/*
    There are 4 possible combinations of URLs:
    * /locale/apple/release/
    * /locale/apple/release/html
    * /locale/it/apple/release/
    * /locale/it/apple/release/html

    If an explicit locale is not requested, set it temporarily to null
    and find a better match later.
*/
$url_parts = count($components);
if ($url_parts == 3) {
    // Url type: /locale/apple/release/
    $request = [
        'locale'  => null,
        'store'   => isset($components[1]) ? $components[1] : null,
        'channel' => isset($components[2]) ? $components[2] : null,
        'output'  => 'show',
    ];
} elseif ($url_parts == 4) {
    $last_part = isset($components[3]) ? $components[3] : null;
    if (in_array($last_part, $output_options)) {
        // Url type: /locale/apple/release/html
        $request = [
            'locale'  => null,
            'store'   => isset($components[1]) ? $components[1] : null,
            'channel' => isset($components[2]) ? $components[2] : null,
            'output'  => isset($components[3]) ? $components[3] : 'show',
        ];
    } else {
        // Url type: /locale/it/apple/release/
        $request = [
            'locale'  => isset($components[1]) ? $components[1] : null,
            'store'   => isset($components[2]) ? $components[2] : null,
            'channel' => isset($components[3]) ? $components[3] : null,
            'output'  => 'show',
        ];
    }
} else {
    // Url type: /locale/it/apple/release/html
    $request = [
        'locale'  => isset($components[1]) ? $components[1] : null,
        'store'   => isset($components[2]) ? $components[2] : null,
        'channel' => isset($components[3]) ? $components[3] : null,
        'output'  => isset($components[4]) ? $components[4] : 'show',
    ];
}

if (! in_array($request['store'], ['google', 'apple'])) {
    die('Unknown marketplace provider or output format.');
}

if (! in_array($request['channel'], ['beta', 'release'])) {
    die('This Firefox channel is not supported.');
}

if ($request['store'] == 'google') {
    $supported_locales = $project->getGoogleMozillaCommonLocales($request['channel']);
}

if ($request['store'] == 'apple') {
    $supported_locales = $project->getAppleMozillaCommonLocales($request['channel']);
}

// Include en-US in this view
if (! in_array('en-US', $supported_locales)) {
    $supported_locales[] = 'en-US';
    sort($supported_locales);
}

// If not provided, try to get a better locale match with Accept-Language
if (! $request['locale']) {
    $request['locale'] = Utils::detectLocale($supported_locales);
}

if (! in_array($request['locale'], $supported_locales)) {
    die('Not a locale code supported by Firefox');
}

$title = ucfirst($request['store']) . " Store Description, {$request['channel']} channel, for: {$request['locale']}";

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
        $view  = 'locale';
        break;
}
include MODELS . 'locale_model.php';
include VIEWS . $request['store'] . '/' . $request['channel'] . '/' . $view . '_view.php';
