<?php

// Constants for the project
define('INSTALL',       realpath(__DIR__ . '/../../') . '/');
define('APP',           INSTALL . 'app/');
define('WEB',           INSTALL . 'web/');
define('INC',           APP . 'inc/');
define('VIEWS',         APP . 'views/');
define('MODELS',        APP . 'models/');
define('CONTROLLERS',   APP . 'controllers/');
define('SETTINGS',      APP . 'settings/');
define('TEMPLATES',     APP . 'templates/');
define('DEBUG',         true);

if ($_SERVER['SERVER_NAME'] == 'l10n.mozilla-community.org') {
    define('BASE_HTML_URL', 'https://l10n.mozilla-community.org/~pascalc/google_play_description/');
} elseif ($_SERVER['SERVER_NAME'] == 'demos.mozfr.org') {
    define('BASE_HTML_URL', 'http://' . $_SERVER['HTTP_HOST'] .'/google_play_copy/web/');
} else {
    define('BASE_HTML_URL', 'http://' . $_SERVER['HTTP_HOST'] .'/');
}
