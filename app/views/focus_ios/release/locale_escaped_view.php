<h1>Focus for iOS Listing Copy (<?= $request['locale'] ?>)</h1>
<h3>Title</h3>
<pre contenteditable="true"><?= htmlspecialchars($app_title($translations)) ?></pre>

<h3>Description</h3>
<pre contenteditable="true"><?= strip_tags($description($translations)) ?></pre>

<h3>What’s new</h3>
<pre contenteditable="true"><?= $whatsnew($translations) ?></pre>

<h3>Screenshots text</h3>
<pre contenteditable="true" class="text-center"><?= br2nl($screenshots($translations)) ?></pre>

<h3>Keywords &mdash; <?= $keywords_warning ?></h3>
<pre contenteditable="true"><?= htmlspecialchars($keywords($translations)) ?></pre>
