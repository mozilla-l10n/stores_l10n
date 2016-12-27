<?php
namespace Stores;

// Closure to use in the template
$_ = function ($string, $replacements = false) use ($translations, $view) {
    $return_string = $translations->get($string);
    $warning = '';

    if (is_array($replacements)) {
        $return_string = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $translations->get($string)
        );
    }

    if ($view == 'locale') {
        $warning = $translations->isStringTranslated($string)
                   ? 'title="' . $string . '"'
                   : 'style="color: darkorange"';

        return '<span ' . $warning . '>' . $return_string . '</span>';
    }

    return $return_string;
};

// Closure used in the API model
$set_limit = function ($type, $string) {
    return mb_strlen(trim(strip_tags($string))) <= $store_limits[$type];
};
