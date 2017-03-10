<h1>Focus for Android Listing Copy (<?= $request['locale'] ?>)</h1>
<h3>Title</h3>
<pre><?= $app_title($translations) ?></pre>

<h3>Description</h3>
<pre><?= $description($translations) ?></pre>

<h2><em><?= $short_desc($translations) ?>&mdash;<?= $short_desc_warning ?></em></h2>

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

        }
    }
?>

<h3>Keywords</h3>
<pre><?= $keywords($translations) ?></pre>
