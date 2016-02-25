<?php
namespace Stores;

use Langchecker\Utils;

$template = true;
$view = '';

switch ($url['path']) {
    case '/':
        $controller = 'home';
        break;

    case 'api/documentation':
        $controller = 'api_doc';
        break;

    case Utils::StartsWith($url['path'], 'api'):
        $controller = 'api';
        $template = false;
        break;

    case Utils::StartsWith($url['path'], 'locale'):
        $controller = 'locale';
        break;

    default:
        $controller = 'home';
        break;
}

if ($template) {
    ob_start();
    include CONTROLLERS . $controller . '_controller.php';
    $content = ob_get_contents();
    ob_end_clean();

    // display the page
    require_once TEMPLATES . 'html.php';
} else {
    include CONTROLLERS . $controller . '_controller.php';
}

// Log script performance in PHP integrated developement server console
// Utils::logScriptPerformances();

