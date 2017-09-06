<h1>Firefox for iOS Listing Copy (<?= $request['locale'] ?>)</h1>

<h3>Title <?= $title_warning ?></h3>
<pre <?= $direction ?> contenteditable="true"><?= htmlspecialchars($app_title($translations)) ?></pre>

<h3>Subtitle <?= $subtitle_warning ?></h3>
<pre <?= $direction ?> contenteditable="true"><?= htmlspecialchars($app_subtitle($translations)) ?></pre>

<h3>Description</h3>
<pre <?= $direction ?> contenteditable="true"><?= strip_tags($description($translations)) ?></pre>

<h3>What’s new</h3>
<pre <?= $direction ?> contenteditable="true"><?= $whatsnew($translations) ?></pre>

<h3>Screenshots text</h3>
<pre <?= $direction ?> contenteditable="true" class="text-center"><?= br2nl($screenshots($translations)) ?></pre>

<h3>Keywords &mdash; <?= $keywords_warning ?></h3>
<pre <?= $direction ?> contenteditable="true"><?= htmlspecialchars($keywords($translations)) ?></pre>

<h3>Other</h3>
<pre <?= $direction ?> contenteditable="true"><?= htmlspecialchars($other($translations)) ?></pre>
