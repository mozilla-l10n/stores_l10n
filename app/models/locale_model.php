<?php
namespace Stores;

$direction = $project->isRTL($request['locale']) ? 'dir="rtl"' : 'dir="ltr"';

$lang_files = $project->getLangFiles($request['locale'], $request['product'], $request['channel'], 'all');
$translations = new Translate($request['locale'], $lang_files, LOCALES_PATH);

// Include the current template
require TEMPLATES . $project->getTemplate($request['locale'], $request['product'], $request['channel']);

$get_length = function ($string) {
    /*
        In locale view a lot of markup is added: the string is injected in a
        <span> with a style if untranslated, or with the original string as a
        title if translated. Need to get rid of this markup to calculate the
        length of the section, and can't strip tags since markup adds to the
        maximum length.
    */
    $pattern = '/<span[^<]*?>([^<]*)<\/span>/im';
    return mb_strlen(trim(preg_replace($pattern, '$1', $string)));
};

$set_limit = function ($type, $length) use ($store_limits) {
    $limit = $store_limits[$type];
    if ($length <= $limit) {
        return "{$length} characters";
    }

    return "<strong style=\"color: red\">{$length} characters, too long. Limit is {$limit}.</strong>";
};

// Google Play has lengths constraints, here we detect translations that are too long and insert a warning message
$store = $project->getProductStore($request['product']);
if ($store == 'google') {
    $short_desc_warning = isset($short_desc)
        ? $set_limit('google_short_description', $get_length($short_desc($translations)))
        : '';

    $listing_warning = $set_limit('google_description', $get_length($description($translations)));
    $title_warning = $set_limit('google_title', $get_length($app_title($translations)));

    if (in_array($request['channel'], $project->getProductChannels($request['product']))) {
        $whatsnew_warning = isset($whatsnew)
            ? $set_limit('google_whatsnew', $get_length($whatsnew($translations)))
            : '';
    }
}

// Apple App Store also has lengths constraints
if ($store == 'apple') {
    $keywords_warning = $set_limit('apple_keywords', $get_length($keywords($translations)));
}
