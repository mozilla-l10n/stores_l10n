<?php

// Constants for the project
define('INSTALL',     realpath(__DIR__ . '/../../') . '/');
define('APP',         INSTALL . 'app/');
define('WEB',         INSTALL . 'web/');
define('INC',         APP . 'inc/');
define('VIEWS',       APP . 'views/');
define('SETTINGS',    APP . 'settings/');
define('TEMPLATES',   APP . 'templates/');
define('MODELS',      APP . 'models/');
define('CONTROLLERS', APP . 'controllers/');
define('TEST_FILES',  realpath(__DIR__ . '/../testfiles/') . '/');
define('LOCALES_PATH', TEST_FILES . 'langfiles/');

// Hosting specific settings are in a INI file
if (file_exists(SETTINGS . 'config.ini')) {
    $config = parse_ini_file(SETTINGS . 'config.ini');
}

if (isset($config['url'])) {
    define('BASE_HTML_URL', $config['url']);
} else {
    define('BASE_HTML_URL', 'http://localhost/');
}

if (isset($config['debug'])) {
    define('DEBUG', (boolean) $config['debug']);
} else {
    define('DEBUG', false);
}

// Make sure we have a timezone set
date_default_timezone_set('Europe/Paris');

// We always work with UTF8 encoding (needed for PHP < 5.6)
mb_internal_encoding('UTF-8');

require __DIR__ . '/../../vendor/autoload.php';
