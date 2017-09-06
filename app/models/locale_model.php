<?php
namespace Stores;

$direction = $project->isRTL($request['locale']) ? 'dir="rtl"' : 'dir="ltr"';

$lang_files = $project->getLangFiles($request['locale'], $request['product'], $request['channel'], 'all');
$translations = new Translate($request['locale'], $lang_files, LOCALES_PATH);

// Include the current template
require TEMPLATES . $project->getTemplate($request['locale'], $request['product'], $request['channel']);

$show_length = function ($type, $string) use ($store_limits) {
    /*
        In locale view a lot of markup is added: the string is injected in a
        <span> with a style if untranslated, or with the original string as a
        title if translated. Need to get rid of this markup to calculate the
        length of the section, and can't strip tags since markup adds to the
        maximum length.
    */
    $pattern = '/<span[^<]*?>([^<]*)<\/span>/im';
    $length = mb_strlen(trim(preg_replace($pattern, '$1', $string)));

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
        ? $show_length('google_short_description', $short_desc($translations))
        : '';

    $listing_warning = $show_length('google_description', $description($translations));
    $title_warning = $show_length('google_title', $app_title($translations));

    if (in_array($request['channel'], $project->getProductChannels($request['product']))) {
        $whatsnew_warning = isset($whatsnew)
            ? $show_length('google_whatsnew', $whatsnew($translations))
            : '';
    }
}

// Apple App Store also has lengths constraints
if ($store == 'apple') {
    $keywords_warning = $show_length('apple_keywords', $keywords($translations));
    $title_warning = $show_length('apple_title', $app_title($translations));
    $subtitle_warning = $show_length('apple_subtitle', $app_subtitle($translations));
}
