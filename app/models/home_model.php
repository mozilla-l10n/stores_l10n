<?php
namespace Stores;

// Compute the completion status for all locales across products and channels
$status = [];
foreach ($project->getSupportedProducts() as $product_id) {
    foreach ($project->getProductChannels($product_id) as $channel_id) {
        // Get supported locales
        $store_locales = $project->getStoreMozillaCommonLocales($product_id, $channel_id);
        $store = $project->getProductStore($product_id);
        foreach ($store_locales as $store_locale) {
            if ($store_locale == 'en-US') {
                // Always consider en-US done
                $status[$product_id][$channel_id][$store_locale] = 'translated';
            } else {
                // Examine both listing and whatsnew
                $lang_files = $project->getLangFiles($store_locale, $product_id, $channel_id, 'all');
                $translations = new Translate($store_locale, $lang_files, LOCALES_PATH);

                $done = false;
                // Check for limit errors
                if ($translations->isFileTranslated()) {
                    // Include the current template
                    require TEMPLATES . $project->getTemplate($store_locale, $product_id, $channel_id);

                    switch ($store) {
                        case 'google':
                            $desc_status = $set_limit('google_description', $description($translations));
                            $title_status = $set_limit('google_title', $app_title($translations));
                            $short_desc_status = $set_limit('google_short_description', $short_desc($translations));
                            $overall_status = $desc_status + $title_status + $short_desc_status;
                            if ($overall_status == 3) {
                                $done = true;
                            }
                            break;
                        case 'apple':
                            $keywords_status = $set_limit('apple_keywords', $keywords($translations));
                            $title_status = $set_limit('apple_title', $app_title($translations));
                            $subtitle_status = $set_limit('apple_subtitle', $app_subtitle($translations));
                            $overall_status = $keywords_status + $title_status + $subtitle_status;
                            if ($overall_status == 3) {
                                $done = true;
                            }
                            break;
                        default:
                            break;
                    }
                }

                $status[$product_id][$channel_id][$store_locale] = $done ? 'translated' : '';
            }
        }
    }
}

$request = new API();
$api_version = $request->getCurrentAPIVersion();

$html_table = function ($table_id, $table_title, $product, $channel) use ($status, $project, $api_version) {
    ob_start(); ?>
        <table id="<?=$table_id?>" class="table table-bordered table-condensed table-striped">
        <tr>
            <th class="text-center" colspan="5"><?=$table_title?></th>
        </tr>
    <?php
        if ($project->getProductStore($product) == 'google' &&
            $project->hasWhatsnew($product, $channel)) {
            $display_link = BASE_HTML_URL . "product/{$product}/{$channel}/whatsnew/";
            $raw_link = "{$display_link}raw";
    ?>
            <tr>
                <td colspan="5">
                    <strong>What's New content for Play store:</strong> <a href="<?=$display_link?>" class="btn btn-info btn-sm">Show</a> <a href="<?=$raw_link?>" class="btn btn-info btn-sm">TXT</a>
                </td>
            </tr>
    <?php
        }
    ?>
        <tr>
            <th class="text-center">Locale</th>
            <th class="text-center">Completion</th>
            <th class="text-center">General View</th>
            <th class="text-center">Description raw HTML</th>
            <th class="text-center">Description JSON</th>
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
            <td><a href="./api/<?=$api_version?>/<?=$product?>/translation/<?=$channel?>/<?=$locale?>/">JSON</a></td>
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
