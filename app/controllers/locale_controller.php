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
        'product' => isset($components[1]) ? $project->getUpdatedProductCode($components[1]) : null,
        'channel' => isset($components[2]) ? $components[2] : null,
        'output'  => 'show',
    ];
} elseif ($url_parts == 4) {
    $last_part = isset($components[3]) ? $components[3] : null;
    if (in_array($last_part, $output_options)) {
        // Url type: /locale/apple/release/html
        $request = [
            'locale'  => null,
            'product' => isset($components[1]) ? $project->getUpdatedProductCode($components[1]) : null,
            'channel' => isset($components[2]) ? $components[2] : null,
            'output'  => isset($components[3]) ? $components[3] : 'show',
        ];
    } else {
        // Url type: /locale/it/apple/release/
        $request = [
            'locale'  => isset($components[1]) ? $components[1] : null,
            'product' => isset($components[2]) ? $project->getUpdatedProductCode($components[2]) : null,
            'channel' => isset($components[3]) ? $components[3] : null,
            'output'  => 'show',
        ];
    }
} else {
    // Url type: /locale/it/apple/release/html
    $request = [
        'locale'  => isset($components[1]) ? $components[1] : null,
        'product' => isset($components[2]) ? $project->getUpdatedProductCode($components[2]) : null,
        'channel' => isset($components[3]) ? $components[3] : null,
        'output'  => isset($components[4]) ? $components[4] : 'show',
    ];
}

$supported_locales = $project->getStoreMozillaCommonLocales($request['product'], $request['channel']);

// Include en-US in this view
if ($supported_locales && ! in_array('en-US', $supported_locales)) {
    $supported_locales[] = 'en-US';
    sort($supported_locales);
}

/*
    If not provided, try to get a better locale match with Accept-Language
    and redirect user to the URL with explicit locale
*/
if (! $request['locale']) {
    /*
        Locale needs to be inserted in 2nd position, between locale and store.
        E.g. from /locale/apple/release/ to /locale/it/apple/release/
    */
    array_splice($components, 1, 0, Utils::detectLocale($supported_locales));
    $redirected_url = BASE_HTML_URL . implode('/', $components);
    header("Location: {$redirected_url}");
    exit();
}

if (! in_array($request['product'], $project->getSupportedProducts())) {
    die('Unknown product or output format.');
}

if (! in_array($request['channel'], ['beta', 'release'])) {
    die('This channel is not supported.');
}

if (! in_array($request['locale'], $supported_locales)) {
    die('Not a locale code supported by this product.');
}

$title = ucfirst($project->getProductName($request['product'])) . " Store Description, {$request['channel']} channel, for: {$request['locale']}";

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
include VIEWS . $request['product'] . '/' . $request['channel'] . '/' . $view . '_view.php';
