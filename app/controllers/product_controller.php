<?php
namespace Stores;

/*
    Possible URL formats:
    * /product/{PRODUCT_CODE}/release/whatsnew
    * /product/{PRODUCT_CODE}/release/whatsnew/raw/
*/
$components = explode('/', $url['path']);
$request = [
    'product' => isset($components[1]) ? $components[1] : null,
    'channel' => isset($components[2]) ? $components[2] : null,
    'content' => isset($components[3]) ? $components[3] : null,
    'output'  => isset($components[4]) ? $components[4] : 'html',
];

// Only whatsnew is supported at the moment for this view
if ($request['content'] != 'whatsnew') {
    die('Unknown content requested.');
}

if (! in_array($request['output'], ['html', 'raw'])) {
    die('Unknown output format.');
}

$supported_locales = $project->getStoreMozillaCommonLocales($request['product'], $request['channel']);
// Include en-US in this view
if ($supported_locales && ! in_array('en-US', $supported_locales)) {
    $supported_locales[] = 'en-US';
    sort($supported_locales);
}

if (! in_array($request['product'], $project->getSupportedProducts())) {
    die('Unknown product.');
}

if ($project->getProductStore($request['product']) != 'google') {
    die('This view is supported only for Play Store products.');
}

if (! in_array($request['channel'], $project->getProductChannels($request['product']))) {
    die('This channel is not supported.');
}

$title = ucfirst($project->getProductName($request['product'])) . " – What’s New Content for {$request['channel']} channel";

switch ($request['output']) {
    case 'html':
        $view = 'product_whatsnew';
        $template = 'html.php';
        break;
    case 'raw':
        $view = 'product_whatsnew_raw';
        $template = '';
        break;
}

include MODELS . 'product_whatsnew_model.php';
include VIEWS . $view . '.php';

if ($template != '') {
    include TEMPLATES . $template;
}
