<?php
namespace Stores;

$translate = new Translate($request['locale'], $project->getLangFile($request['store'], $request['channel']));

// Include the current template
require_once TEMPLATES . $project->getTemplate($request['store'], $request['channel']);

$get_length = function ($string) {
    return mb_strlen(trim(strip_tags($string)));
};

$set_limit = function ($limit, $length) {
    if ($length <= $limit) {
        return $length . ' characters';
    }

    return '<strong style="color:red">' . $length . " characters, too long. Limit is {$limit}.</strong>";
};

$listing_warning    = $set_limit(4000, $get_length($description($translate)));
$title_warning      = $set_limit(30, $get_length($app_title($translate)));
$short_desc_warning = $set_limit(80, $get_length($short_desc($translate)));
