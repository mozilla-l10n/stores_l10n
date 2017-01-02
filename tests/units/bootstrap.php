<?php

// Constants for the project
define('INSTALL',     realpath(__DIR__ . '/../../') . '/');
define('APP',         INSTALL . 'app/');
define('WEB',         INSTALL . 'web/');
define('INC',         APP . 'inc/');
define('VIEWS',       APP . 'views/');
define('CONFIG',      APP . 'config/');
define('TEMPLATES',   APP . 'templates/');
define('MODELS',      APP . 'models/');
define('CONTROLLERS', APP . 'controllers/');
define('TEST_FILES',  realpath(__DIR__ . '/../testfiles/') . '/');
define('LOCALES_PATH', TEST_FILES . 'langfiles/');

// Load local settings
$webroot_folder = '/';
const DEBUG = false;

// Make sure we have a timezone set
date_default_timezone_set('Europe/Paris');

// We always work with UTF8 encoding (needed for PHP < 5.6)
mb_internal_encoding('UTF-8');

require __DIR__ . '/../../vendor/autoload.php';
