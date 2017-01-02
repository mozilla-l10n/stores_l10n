     <!-- Main jumbotron for a primary marketing message or call to action -->
<div class="page-header">
    <h1>Dashboard and API for Google and Apple stores translations</h1>
</div>

<?php
$navigation = "<ul id=\"filters\" class=\"nav nav-pills\">\n";
$main_content = '';
foreach ($project->getSupportedProducts() as $product_id) {
    foreach ($project->getProductChannels($product_id) as $channel_id) {
        $full_id = "{$product_id}_{$channel_id}";
        $product_name = $project->getProductName($product_id);
        if ($channel_id != 'release') {
            $product_name .= ' ' . ucfirst($channel_id);
        }
        $navigation .= "  <li class=\"filter\"><a href=\"#{$full_id}\" id=\"{$full_id}\">{$product_name}</a></li>\n";
        $main_content .= $stores_data[$product_id][$channel_id];
    }
}
$navigation .= "</ul>\n";

echo $navigation;
echo $main_content;
?>

<script src="media/assets/jquery/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('table').hide();

    $('#fx_android_release_table').show();

    $('#filters a').click(function(e) {
        e.preventDefault();
        $('#filters li').removeClass('active');
        $('table').hide();
        $('#' + e.target.id + '_table').show();
        $('#' + e.target.id).parent().addClass('active');
    });

    // We want URL anchors to also work as filters
    var anchor = location.hash.substring(1);
    if (anchor !== '') {
        $('#' + anchor).click();
    } else {
        $('#filters li').removeClass('active');
        $('#fx_android_release').parent().addClass('active');
    }
});
</script>
