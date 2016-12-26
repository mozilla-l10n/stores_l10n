     <!-- Main jumbotron for a primary marketing message or call to action -->
<div class="page-header">
    <h1>Dashboard and API for Google Play / Apple Appstore listings translation</h1>
</div>
<ul id="filters" class="nav nav-pills">
    <li class="filter"><a href="#fx_android_beta" id="fx_android_beta">Firefox for Android Beta</a></li>
    <li class="filter active"><a href="#fx_android_release" id="fx_android_release">Firefox for Android Release</a></li>
    <li class="filter"><a href="#fx_ios_release" id="fx_ios_release">Firefox for iOS Release</a></li>
</ul>

<?=$stores['fx_android']['beta']?>
<?=$stores['fx_android']['release']?>
<?=$stores['fx_ios']['release']?>

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
