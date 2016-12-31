<?php
namespace Stores;

// Make sure we have a timezone set
date_default_timezone_set('Europe/Paris');

// We always work with UTF8 encoding (needed for PHP < 5.6)
mb_internal_encoding('UTF-8');

// Load all constants for the application
require_once __DIR__ . '/constants.php';

// Autoloading of classes (both /vendor and /classes)
require_once INSTALL . 'vendor/autoload.php';

// Initalize a Project object that contains key information
$project = new Project;

// Cache class
define('CACHE_ENABLED', true);
define('CACHE_PATH', INSTALL . 'cache/');
define('CACHE_TIME', 900);
