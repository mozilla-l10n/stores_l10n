<h1>Firefox for iOS Listing Copy (<?= $request['locale'] ?>)</h1>
<h3>Title</h3>
<pre><?= $app_title($translations) ?></pre>

<h3>Description</h3>
<pre><?= $description($translations) ?></pre>

<h3>What’s new</h3>
<pre><?= $whatsnew($translations) ?></pre>

<h3>Screenshots text</h3>
<pre class="text-center"><?= $screenshots($translations) ?></pre>

<h3>Keywords&mdash; <?= $keywords_warning ?></h3>
<pre><?= $keywords($translations) ?></pre>

<h3>Other</h3>
<pre><?= $other($translations) ?></pre>
