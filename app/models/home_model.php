<?php
namespace Stores;

// Compute the completion status for all locales across products and channels
$status = [];
foreach ($project->getSupportedProducts() as $product_id) {
    foreach ($project->getProductChannels($product_id) as $channel_id) {
        // Get supported locales
        $store_locales = $project->getStoreMozillaCommonLocales($product_id, $channel_id);

        // Examine both listing and whatsnew
        $lang_files = [
            $project->getLangFiles($product_id, $channel_id, 'listing'),
            $project->getLangFiles($product_id, $channel_id, 'whatsnew'),
        ];
        foreach ($store_locales as $store_locale) {
            $obj = new Translate($store_locale, $lang_files, LOCALES_PATH);
            $status[$product_id][$channel_id][$store_locale] = $obj->isFileTranslated() ? 'translated' : '';
        }
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
        <?php foreach ($status[$product][$channel] as $locale => $status_locale): ?>
        <tr class="text-center">
            <th><?=$locale?></th>
            <?php
            $color = $status_locale == 'translated'
                ? 'success'
                : ''; ?>
            <td class='<?=$color?>'></td>
            <td><a href="./locale/<?=$locale?>/<?=$product?>/<?=$channel?>/">Show</a></td>
            <td><a href="./locale/<?=$locale?>/<?=$product?>/<?=$channel?>/html">HTML</a></td>
            <td><a href="./api/<?=$product?>/translation/<?=$channel?>/<?=$locale?>/">Json</a></td>
        </tr>
        <?php endforeach; ?>
        </table>
    <?php

    $table = ob_get_contents();
    ob_end_clean();

    return $table;
};

$stores_data = [];
foreach ($project->getSupportedProducts() as $product_id) {
    foreach ($project->getProductChannels($product_id) as $channel_id) {
        $stores_data[$product_id][$channel_id] = $html_table(
            "{$product_id}_{$channel_id}_table",
            $project->getProductName($product_id) . ' <span class="text-danger">' . ucfirst($channel_id) . '</span> Channel',
            $product_id,
            $channel_id
        );
    }
}
