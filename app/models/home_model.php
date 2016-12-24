<?php
namespace Stores;

// Compute the completion status for all locales
$status = [];

$get_status = function ($lang_file, $store_locales) {
    foreach ($store_locales as $lang) {
        $obj = new Translate($lang, $lang_file);
        $status[$lang] = $obj->isFileTranslated() ? 'translated' : '';
    }

    return $status;
};

$status['google']['release'] = $get_status(
    $project->getListingFiles('google', 'release'),
    $project->getGoogleMozillaCommonLocales('release')
);

foreach ($status['google']['release'] as $lang => $state) {
    if ($state == 'translated') {
        $obj = new Translate($lang, $project->getWhatsnewFiles('google', 'release'));
        $status['google']['release'][$lang] = $obj->isFileTranslated() ? 'translated' : '';
    }
}

$status['google']['beta'] = $get_status(
    $project->getListingFiles('google', 'beta'),
    $project->getGoogleMozillaCommonLocales('beta')
);

foreach ($status['google']['beta'] as $lang => $state) {
    if ($state == 'translated') {
        $obj = new Translate($lang, $project->getWhatsnewFiles('google', 'beta'));
        $status['google']['beta'][$lang] = $obj->isFileTranslated() ? 'translated' : '';
    }
}

$status['apple']['release'] = $get_status(
    $project->getListingFiles('apple', 'release'),
    $project->getAppleMozillaCommonLocales('release')
);

foreach ($status['apple']['release'] as $lang => $state) {
    if ($state == 'translated') {
        $obj = new Translate($lang, $project->getWhatsnewFiles('apple', 'release'));
        $status['apple']['release'][$lang] = $obj->isFileTranslated() ? 'translated' : '';
    }
}

$html_table = function ($table_id, $table_title, $store, $channel) use ($status, $project) {
    ob_start(); ?>
        <table id="<?=$table_id?>" class="table table-bordered table-condensed table-striped">
        <tr>
            <th class="text-center" colspan="5"><?=$table_title?></th>
        </tr>
        <tr>
            <th class="text-center">Locale</th>
            <th class="text-center">Completion</th>
            <th class="text-center">General View</th>
            <th class="text-center">Description Raw HTML</th>
            <th class="text-center">Description Json</th>
        </tr>
        <?php foreach ($project->getStoreMozillaCommonLocales($store, $channel) as $lang): ?>
        <tr class="text-center">
            <th><?=$lang?></th>
            <?php
            if ($status[$store][$channel][$lang] == 'translated') {
                $color = ' success';
            } else {
                $color = '';
            } ?>
            <td class='<?=$color?>'></td>
            <td><a href="./locale/<?=$lang?>/<?=$store?>/<?=$channel?>/">Show</a></td>
            <td><a href="./locale/<?=$lang?>/<?=$store?>/<?=$channel?>/html">HTML</a></td>
            <td><a href="./api/<?=$store?>/translation/<?=$channel?>/<?=$lang?>/">Json</a></td>
        </tr>
        <?php endforeach; ?>
        </table>
    <?php

    $table = ob_get_contents();
    ob_end_clean();

    return $table;
};

$stores = [];

$stores['play']['release'] = $html_table(
    'play_release_table',
    'Google Play <span class="text-danger">Release</span> Channel',
    'google',
    'release'
);

$stores['play']['beta'] = $html_table(
    'play_beta_table',
    'Google Play <span class="text-danger">Beta</span> Channel',
    'google',
    'beta'
);

$stores['appstore']['release'] = $html_table(
    'app_store_release_table',
    'Apple AppStore <span class="text-danger">Release</span> Channel',
    'apple',
    'release'
);
