
<h2><?= $app_title($translations) ?> &mdash; <?= $title_warning ?></h2>

<h2><em><?= $short_desc($translations) ?> &mdash; <?= $short_desc_warning ?></em></h2>

<h3>What’s new &mdash; <?= $whatsnew_warning ?></h3>
<pre contenteditable="true"><?= $whatsnew($translations) ?></pre>

<h3>Google Play Beta Listing Copy &mdash; <?= $listing_warning ?></h3>
<pre contenteditable="true"><?= htmlspecialchars($description($translations)) ?></pre>
