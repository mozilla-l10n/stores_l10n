<?php
namespace Play;

$translate = new Translate($locale, 'description_page.lang');

// Include the current template
require_once APP_ROOT . '/templates/' . array_values($current_template)[0];

$get_length = function ($string) {
    return mb_strlen(trim(strip_tags($string)));
};

$set_limit = function ($limit, $length) {
    if ($length < $limit) {
        return $length . ' characters';
    }

    return '<strong style="color:red">' . $length . " characters, too long. Limit is {$limit}.</strong>";
};

$listing_warning    = $set_limit(4000, $get_length($description($translate)));
$title_warning      = $set_limit(30, $get_length($app_title($translate)));
$short_desc_warning = $set_limit(80, $get_length($short_desc($translate)));
