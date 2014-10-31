<?php
namespace Play;

// Compute the completion status for all locales

foreach($android_locales as $lang) {

    $obj = new Translate($lang, 'description_page.lang');
    $status[$lang] = $obj->isFileTranslated() ? 'translated' : '';
}
