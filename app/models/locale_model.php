<?php
namespace Play;

$translate = new Translate($locale, 'description_page.lang');

// Closure to use in the template
$_ = function($string, $replacements = false) use($translate, $view) {

    $return_string = $translate->get($string);
    $warning = '';

    if (is_array($replacements)) {
        $return_string = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $translate->get($string)
        );
    }

    if ($view == 'locale') {
        $warning = $translate->isStringTranslated($string)
                   ? 'title="' . $string . '"'
                   : 'style="color: darkorange"';
        return '<span ' . $warning . '>' . $return_string . '</span>';
    }

    return $return_string;
};

// Include the current template
require_once APP_ROOT . '/templates/' . array_values($current_template)[0];

$description_length = mb_strlen(trim(strip_tags($description($translate))));

if ($description_length < 4000) {
    $warning = $description_length . ' characters';
} else {
    $warning = '<strong style="color:red">' . $description_length . ' characters, too long. Limit is 4000.</strong>';
}

error_log($translate->isFileTranslated());
