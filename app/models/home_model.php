<?php
namespace Play;

// Compute the completion status for all locales

foreach($google_mozilla_supported as $lang) {

    $obj = new Translate($lang, 'description_page.lang');
    $status[$lang] = $obj->isFileTranslated() ? 'translated' : '';
}
