<?php

// Constants for the project
define('INSTALL',       realpath(__DIR__ . '/../../') . '/');
define('APP',           INSTALL . 'app/');
define('WEB',           INSTALL . 'web/');
define('LOCALES',       INSTALL . 'locales/');
define('INC',           APP . 'inc/');
define('VIEWS',         APP . 'views/');
define('SETTINGS',      APP . 'settings/');
define('TEMPLATES',     APP . 'templates/');
define('MODELS',        APP . 'models/');
define('CONTROLLERS',   APP . 'controllers/');

// Hosting specific settings are in a INI file
if (file_exists(SETTINGS . 'config.ini')) {
    $config = parse_ini_file(SETTINGS . 'config.ini');
}

$protocol = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443
            ? 'https'
            : 'http';

if (isset($config['url'])) {
    define('BASE_HTML_URL', $config['url']);
} else {
    define('BASE_HTML_URL', $protocol . '://' . $_SERVER['HTTP_HOST'] . '/');
}

if (isset($config['debug'])) {
    define('DEBUG', (boolean) $config['debug']);
} else {
    define('DEBUG', false);
}
