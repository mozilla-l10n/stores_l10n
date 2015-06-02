<?php

// Initialize the application
require_once __DIR__ . '/init.php';

// This is a hack to be able to install the app in a subfolder
$base_url = parse_url(BASE_HTML_URL)['path'];
$base_url = rtrim($base_url, '/');

if (substr($_SERVER['REQUEST_URI'], 0, strlen($base_url)) == $base_url) {
    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base_url));
}
unset($base_url);

$url  = parse_url($_SERVER['REQUEST_URI']);
$file = pathinfo($url['path']);

// Real files and folders don't get pre-processed
if (file_exists($_SERVER['DOCUMENT_ROOT'] . $url['path'])
    && $url['path'] != '/') {
    return false;
}

// Don't process non-PHP files, even if they don't exist on the server
if (isset($file['extension']) && $file['extension'] != 'php') {
    return false;
}

if ($url['path'] != '/') {
    // Normalize path before comparing the string to list of valid paths
    $url['path'] = explode('/', $url['path']);
    $url['path'] = array_filter($url['path']); // Remove empty items
    $url['path'] = array_values($url['path']); // Reorder keys
    $url['path'] = implode('/', $url['path']);
}

// Include all valid urls here
require_once INC . 'urls.php';

// We start pessimistic, the url asked is not valid
$match = false;

// Perfect match between requested url and a static page we provide
if (in_array($url['path'], array_keys($urls))) {
    $match = true;
}

// The first part of the url matches a service, we will call its controller
if (in_array(explode('/', $url['path'])[0], $urls)) {
    $match = true;
}

if (! $match) {
    header('HTTP/1.1 404 Not Found');
    die('resource not found');
}

// Always redirect to an url ending with slashes
$temp_url = parse_url($_SERVER['REQUEST_URI']);

if (substr($temp_url['path'], -1) != '/') {
    unset($temp_url);
    header(
        'Location:'
        . BASE_HTML_URL
        . $url['path']
        . '/'
        . (isset($url['query']) ? '?' . $url['query'] : '')
    );
    exit;
}

// Dispatch urls, the dispatcher will call the right controller
require_once INC . 'dispatcher.php';
