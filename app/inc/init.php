<?php
namespace Play;

// We always work with UTF8 encoding (needed for PHP < 5.6)
mb_internal_encoding('UTF-8');

// Make sure we have a timezone set
date_default_timezone_set('Europe/Paris');

// Load all constants for the application
require_once __DIR__ . '/../settings/constants.php';

// Autoloading of classes (both /vendor and /classes)
require_once INSTALL . 'vendor/autoload.php';

// Load all global variables for the application
require_once APP . 'settings/config.php';

// Dispatch urls
require_once INC . 'dispatcher.php';
