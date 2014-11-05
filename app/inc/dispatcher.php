<?php
namespace Play;

$template = true;

switch ($url['path']) {
    case '/':
        $controller = 'main_controller';
        $show_title = false;
        break;

    case Strings::StartsWith($url['path'], 'api'):
        $controller = 'api';
        $template = false;
        break;

    case Strings::StartsWith($url['path'], 'locale'):
        $controller = 'locale';
        break;

    default:
        $controller = 'main_controller';
        break;
}

include CONTROLLERS . $controller . '.php';
