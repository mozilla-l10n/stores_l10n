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

$status['fx_android']['release'] = $get_status(
    $project->getListingFiles('fx_android', 'release'),
    $project->getStoreMozillaCommonLocales('fx_android', 'release')
);

foreach ($status['fx_android']['release'] as $lang => $state) {
    if ($state == 'translated') {
        $obj = new Translate($lang, $project->getWhatsnewFiles('fx_android', 'release'));
        $status['fx_android']['release'][$lang] = $obj->isFileTranslated() ? 'translated' : '';
    }
}

$status['fx_android']['beta'] = $get_status(
    $project->getListingFiles('fx_android', 'beta'),
    $project->getStoreMozillaCommonLocales('fx_android', 'beta')
);

foreach ($status['fx_android']['beta'] as $lang => $state) {
    if ($state == 'translated') {
        $obj = new Translate($lang, $project->getWhatsnewFiles('fx_android', 'beta'));
        $status['fx_android']['beta'][$lang] = $obj->isFileTranslated() ? 'translated' : '';
    }
}

$status['fx_ios']['release'] = $get_status(
    $project->getListingFiles('fx_ios', 'release'),
    $project->getStoreMozillaCommonLocales('fx_ios', 'release')
);

foreach ($status['fx_ios']['release'] as $lang => $state) {
    if ($state == 'translated') {
        $obj = new Translate($lang, $project->getWhatsnewFiles('fx_ios', 'release'));
        $status['fx_ios']['release'][$lang] = $obj->isFileTranslated() ? 'translated' : '';
    }
}

$html_table = function ($table_id, $table_title, $product, $channel) use ($status, $project) {
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
        <?php foreach ($project->getStoreMozillaCommonLocales($product, $channel) as $lang): ?>
        <tr class="text-center">
            <th><?=$lang?></th>
            <?php
            if ($status[$product][$channel][$lang] == 'translated') {
                $color = ' success';
            } else {
                $color = '';
            } ?>
            <td class='<?=$color?>'></td>
            <td><a href="./locale/<?=$lang?>/<?=$product?>/<?=$channel?>/">Show</a></td>
            <td><a href="./locale/<?=$lang?>/<?=$product?>/<?=$channel?>/html">HTML</a></td>
            <td><a href="./api/<?=$product?>/translation/<?=$channel?>/<?=$lang?>/">Json</a></td>
        </tr>
        <?php endforeach; ?>
        </table>
    <?php

    $table = ob_get_contents();
    ob_end_clean();

    return $table;
};

$stores = [];

$stores['fx_android']['release'] = $html_table(
    'fx_android_release_table',
    'Firefox for Android <span class="text-danger">Release</span> Channel',
    'fx_android',
    'release'
);

$stores['fx_android']['beta'] = $html_table(
    'fx_android_beta_table',
    'Firefox for Android <span class="text-danger">Beta</span> Channel',
    'fx_android',
    'beta'
);

$stores['fx_ios']['release'] = $html_table(
    'fx_ios_release_table',
    'Firefox for iOS <span class="text-danger">Release</span> Channel',
    'fx_ios',
    'release'
);
