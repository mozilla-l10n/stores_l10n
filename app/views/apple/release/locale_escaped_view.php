<h1>Apple Store Listing Copy</h1>
<h2 contenteditable="true"><?= htmlspecialchars($app_title($translate)) ?></h2>
<h3>Description</h3>
<pre contenteditable="true"><?= strip_tags($description($translate)) ?></pre>

<h3>Screenshots text</h3>
<pre  contenteditable="true" style="text-align: center;"><?= br2nl($screenshots($translate)) ?></pre>

<h3>Keywords &mdash; <?= $keywords_warning ?></h3>
<pre contenteditable="true"><?= htmlspecialchars($keywords($translate)) ?></pre>

<h3>Other</h3>
<pre contenteditable="true"><?= htmlspecialchars($other($translate)) ?></pre>

