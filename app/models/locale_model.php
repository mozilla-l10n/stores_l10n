<?php
namespace Play;

$translate = new Translate($locale, 'description_page.lang');

// Closure to use in the template
$_ = function($string, $replacements = false) use($translate) {
    $string = $translate->get($string);
    if (is_array($replacements)) {
        $string = str_replace(array_keys($replacements), array_values($replacements), $string);
    }

    return $string;
};

// Include the current template
require_once APP_ROOT . '/templates/' . $current_template;
