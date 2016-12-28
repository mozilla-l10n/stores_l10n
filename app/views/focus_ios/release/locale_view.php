<h1>Focus for iOS Listing Copy (<?= $request['locale'] ?>)</h1>
<h3>Title</h3>
<pre><?= $app_title($translations) ?></pre>

<h3>Description</h3>
<pre><?= $description($translations) ?></pre>

<h3>What’s new</h3>
<pre><?= $whatsnew($translations) ?></pre>

<<<<<<< HEAD
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
            <pre class="text-center"><?= $screenshots($translations) ?></pre>
<?php

        };
    }
?>
=======
<h3>Screenshots text</h3>
<pre class="text-center"><?= $screenshots($translations) ?></pre>
>>>>>>> Support Focus for iOS

<h3>Keywords&mdash; <?= $keywords_warning ?></h3>
<pre><?= $keywords($translations) ?></pre>
