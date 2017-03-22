<h1>Focus for iOS Listing Copy (<?= $request['locale'] ?>)</h1>

<h3>Title</h3>
<pre <?= $direction ?> contenteditable="true"><?= htmlspecialchars($app_title($translations)) ?></pre>

<h3>Description</h3>
<pre <?= $direction ?> contenteditable="true"><?= strip_tags($description($translations)) ?></pre>

<h3>What’s new</h3>
<pre <?= $direction ?> contenteditable="true"><?= $whatsnew($translations) ?></pre>

<?php
    /*
        Check if the file used for screenshots exists, display this section
        only in that case.
    */
    $screenshot_lang = $project->getLangFiles($request['locale'], $request['product'], $request['channel'], 'screenshots');
    if ($screenshot_lang) {
        $locale_file = LOCALES_PATH . $request['locale'] . '/' . array_shift($screenshot_lang);
        if (file_exists($locale_file)) {
            ?>
            <h3>Screenshots</h3>
            <pre <?= $direction ?> contenteditable="true" class="text-center"><?= br2nl($screenshots($translations)) ?></pre>
<?php

        }
    }
?>

<h3>Keywords</h3>
<pre <?= $direction ?> contenteditable="true"><?= htmlspecialchars($keywords($translations)) ?></pre>
