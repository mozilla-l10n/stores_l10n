<h1>Firefox for Android (<?= $request['locale'] ?>)</h1>
<h3>Title 1 &mdash; <?= $title_warning ?></h3>
<pre <?=$direction?>><?= $app_title($translations) ?></pre>

<h3>What’s new &mdash; <?= $whatsnew_warning ?></h3>
<pre contenteditable="true" <?=$direction?>><?= $whatsnew($translations) ?></pre>

<h3>Short Description &mdash; <?= $short_desc_warning ?></h3>
<pre contenteditable="true" <?=$direction?>><em><?= $short_desc($translations) ?></em></pre>

<h3>Description &mdash; <?= $listing_warning ?></h3>
<pre contenteditable="true" <?=$direction?>><?= htmlspecialchars($description($translations)) ?></pre>

<h3>Google Play Screenshots Copy</h3>
<pre style="text-align: center;" contenteditable="true" <?=$direction?>><?= htmlspecialchars(strip_tags($screenshots($translations))) ?></pre>
