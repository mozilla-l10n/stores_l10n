<?php
namespace Stores;

$direction = $project->isRTL($request['locale']) ? 'dir="rtl"' : 'dir="ltr"';

$listing_files  = $project->getLangFiles($request['product'], $request['channel'], 'listing');
$whatsnew_files = $project->getLangFiles($request['product'], $request['channel'], 'whatsnew');

if (is_string($listing_files)) {
    $listing_files = [$listing_files];
}

if ($whatsnew_files === false) {
    $whatsnew_files = [];
}

if (is_string($whatsnew_files)) {
    $whatsnew_files = [$whatsnew_files];
}

$translations = new Translate($request['locale'], array_merge($listing_files, $whatsnew_files), LOCALES_PATH);

// Include the current template
require TEMPLATES . $project->getTemplate($request['product'], $request['channel']);

$get_length = function ($string) {
    return mb_strlen(trim(strip_tags($string)));
};

$set_limit = function ($type, $length) use ($store_limits) {
    $limit = $store_limits[$type];
    if ($length <= $limit) {
        return $length . ' characters';
    }

    return '<strong style="color:red">' . $length . " characters, too long. Limit is {$limit}.</strong>";
};

// Google Play has lengths constraints, here we detect translations that are too long and insert a warning message
$store = $project->getProductStore($request['product']);
if ($store == 'google') {
    $short_desc_warning = $set_limit('google_short_description', $get_length($short_desc($translations)));
    $listing_warning    = $set_limit('google_description', $get_length($description($translations)));
    $title_warning      = $set_limit('google_title', $get_length($app_title($translations)));

    if (in_array($request['channel'], ['beta', 'release'])) {
        $whatsnew_warning = $set_limit('google_whatsnew', $get_length($whatsnew($translations)));
    }
}

// Apple App Store also has lengths constraints
if ($store == 'apple') {
    $keywords_warning = $set_limit('apple_keywords', $get_length($keywords($translations)));
}
