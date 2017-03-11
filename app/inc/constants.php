<?php

// Constants for the project
define('INSTALL', realpath(__DIR__ . '/../../') . '/');
define('APP', INSTALL . 'app/');
define('WEB', INSTALL . 'web/');
define('LOCALES_PATH', INSTALL . 'locales/');
define('INC', APP . 'inc/');
define('VIEWS', APP . 'views/');
define('CONFIG', APP . 'config/');
define('TEMPLATES', APP . 'templates/');
define('MODELS', APP . 'models/');
define('CONTROLLERS', APP . 'controllers/');

// Length limits for stores
$store_limits = [
    'apple_keywords'           => 100,
    'google_description'       => 4000,
    'google_short_description' => 80,
    'google_title'             => 30,
    'google_whatsnew'          => 500,
];

// Load local settings
$settings_file = CONFIG . 'config.inc.php';
if (! file_exists($settings_file)) {
    die('File app/config/config.inc.php is missing. Please check your configuration.');
} else {
    require $settings_file;
}

$protocol = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443
            ? 'https'
            : 'http';

define('BASE_HTML_URL', $protocol . '://' . $_SERVER['HTTP_HOST'] . $webroot_folder);
