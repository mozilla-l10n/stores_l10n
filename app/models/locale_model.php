<?php
namespace Play;

$translate = new Translate($locale, 'description_page.lang');

// Include the current template
require_once APP_ROOT . '/templates/' . array_values($current_template)[0];

$description_length = mb_strlen(trim(strip_tags($description($translate))));

if ($description_length < 4000) {
    $warning = $description_length . ' characters';
} else {
    $warning = '<strong style="color:red">' . $description_length . ' characters, too long. Limit is 4000.</strong>';
}
