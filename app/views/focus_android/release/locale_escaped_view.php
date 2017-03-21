<h1>Focus for Android Listing Copy (<?= $request['locale'] ?>)</h1>

<h3>Title &mdash; <?= $title_warning ?></h3>
<pre contenteditable="true"><?= htmlspecialchars($app_title($translations)) ?></pre>

<h3>Short Description &mdash; <?= $short_desc_warning ?></h3>
<pre contenteditable="true"><?= $short_desc($translations) ?></pre>

<h3>Description &mdash; <?= $listing_warning ?></h3>
<pre contenteditable="true"><?= strip_tags($description($translations)) ?></pre>

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
            <pre contenteditable="true" class="text-center"><?= br2nl($screenshots($translations)) ?></pre>
<?php

        }
    }
