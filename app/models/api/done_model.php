<?php
namespace Play;

$done = [];

foreach($android_locales as $lang) {
    $obj = new Translate($lang, 'description_page.lang');
    if($obj->isFileTranslated()) {
        $done[] = $lang;
    }
}

$play_supported = array_unique(array_values($locale_mapping));

return array_values(array_intersect($done, $play_supported));
