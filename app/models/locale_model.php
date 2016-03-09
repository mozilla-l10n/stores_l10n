<?php
namespace Stores;

$listing_files  = $project->getListingFiles($request['store'], $request['channel']);
$whatsnew_files = $project->getWhatsnewFiles($request['store'], $request['channel']);

if (is_string($listing_files)) {
    $listing_files = [$listing_files];
}

if ($whatsnew_files === false) {
    $whatsnew_files = [];
}

if (is_string($whatsnew_files)) {
    $whatsnew_files = [$whatsnew_files];
}

$translations = new Translate($request['locale'], array_merge($listing_files, $whatsnew_files));

// Include the current template
require TEMPLATES . $project->getTemplate($request['store'], $request['channel']);

$get_length = function ($string) {
    return mb_strlen(trim(strip_tags($string)));
};

$set_limit = function ($limit, $length) {
    if ($length <= $limit) {
        return $length . ' characters';
    }

    return '<strong style="color:red">' . $length . " characters, too long. Limit is {$limit}.</strong>";
};

// Google Play has lengths constraints, here we detect translations that are too long and insert a warning message
if ($request['store'] == 'google') {
    $short_desc_warning = $set_limit(80, $get_length($short_desc($translations)));
    $listing_warning    = $set_limit(4000, $get_length($description($translations)));
    $title_warning      = $set_limit(30, $get_length($app_title($translations)));

    /*
        Historically we have two titles on the Release channel for Google:
        Firefox Web Browser
        Firefox for Android

        The Beta channel only has one title:
        Firefox for Android Beta

        Let's alias one to the other for non-release channels.
    */
    $title_warning2 = isset($app_title2)
        ? $set_limit(30, $get_length($app_title2($translations)))
        : $title_warning;

    if (in_array($request['channel'], ['beta', 'release'])) {
        $whatsnew_warning = $set_limit(500, $get_length($whatsnew($translations)));
    }
}

// Apple Appstore also has lengths constraints
if ($request['store'] == 'apple') {
    $keywords_warning = $set_limit(100, $get_length($keywords($translations)));
}
