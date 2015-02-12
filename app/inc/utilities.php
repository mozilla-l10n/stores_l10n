<?php
namespace Play;

// Closure to use in the template
$_ = function ($string, $replacements = false) use ($translate, $view) {

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
