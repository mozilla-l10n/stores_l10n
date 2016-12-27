<?php
$base = '<em class="dim">' . BASE_HTML_URL . 'api/</em>';
?>
<div class="page-header">
    <h1>JSON API description</h1>
</div>

<h2 class="bg-primary">&nbsp;Variables used in the API</h2>
<ul>
    <li><code>{store}</code>: store providers. Supported values: <var>google</var>, <var>apple</var>.</li>
    <li><code>{product}</code>: product IDs. Supported values: <var>fx_android</var> (<del>google</del>), <var>fx_ios</var> (<del>apple</del>). Between parenthesis are legacy deprecated values.</li>
    <li><code>{channel}</code>:
        <ul>
            <li>Google: <var>beta</var>, <var>release</var>.</li>
            <li>Apple: <var>release</var>.</li>
        </ul>
    </li>
    <li><code>{locale}</code>: a Mozilla locale code, e.g.: fr, es-MX, de.
</ul>

<h2 class="bg-primary">&nbsp;API Calls</h2>
<h3 class="text-primary">{store}/storelocales/</h3>
<h4>Description:</h4>
<p>This call will list all the locales that the store supports.</p>
<h4>Examples:</h4>
<ul>
    <li>List of Google Play locale codes: <?=$base?><a href="api/google/storelocales/">google/storelocales/</a></li>
    <li>List of App Store locale codes: <?=$base?><a href="api/apple/storelocales/">apple/storelocales/</a></li>
</ul>


<h3 class="text-primary">{store}/localesmapping/</h3>
<h4>Description:</h4>
<p>Lists the mapping of locale codes between the store and Mozilla locale codes.</p>
<h4>Examples:</h4>
<ul>
    <li>Locale mapping for Google Play: <?=$base?><a href="api/google/localesmapping/">google/localesmapping/</a></li>
    <li>Locale mapping for App Store: <?=$base?><a href="api/apple/localesmapping/">apple/localesmapping/</a></li>
</ul>
<h4>Notes:</h4>
<ul>
    <li><code>False</code>: not a locale supported by Mozilla.</li>
    <li>There is an optional <var>reverse</var> parameter that can be appended as a query string, e.g.: <?=$base?><a href="api/google/localesmapping/?reverse">google/localesmapping/?reverse</a>. <br>This will output a mapping based on Mozilla codes and not the store codes, which means that locales Mozilla doesn't support but are supported by the store are not listed.</li>
</ul>

<h3 class="text-primary">{product}/productlocales/{channel}/</h3>
<h4>Description:</h4>
<p>List all locale codes supported by product for a release and a platform.</p>
<h4>Example:</h4>
<p>All Firefox for Android locales on the release Channel: <?=$base?><a href="api/fx_android/productlocales/release/">fx_android/productlocales/release/</a></p>

<h3 class="text-primary">{product}/listing/{channel}/</h3>
<h4>Description:</h4>
<p>List all the locales for which the store description page is fully translated for a channel. A locale is listed as done if the translation is complete and there are no strings longer than the store limits.</p>
<h4>Example:</h4>
<ul>
    <li>All Firefox for Android description listings ready for the beta channel: <?=$base?><a href="api/fx_android/listing/beta/">fx_android/listing/beta/</a></li>
    <li>All Firefox for iOS description listings ready for the release channel: <?=$base?><a href="api/fx_ios/listing/release/">fx_ios/listing/release/</a></li>
</ul>

<h3 class="text-primary">{product}/whatsnew/{channel}/</h3>
<h4>Description:</h4>
<p>List all the locales for which the what's new section is fully translated for a channel. A locale is listed as done if the translation is complete and there are no strings longer than the section limit.</p>
<h4>Example:</h4>
<ul>
    <li>All Firefox for Android locales that fully translated what's new section for the release channel: <?=$base?><a href="api/fx_ios/whatsnew/release/">fx_ios/whatsnew/release/</a></li>
</ul>

<h3 class="text-primary">{product}/done/{channel}/</h3>
<h4>Description:</h4>
<p>List all the locales for which all files needed are fully translated for a channel. A locale is listed as done if the translation is complete and there are no strings exceeding the store limits. In the case of Google, for the release channel this API returns the locales that have translated both the listing page on Google Play and the Whatsnew page.</p>
<h4>Example:</h4>
<ul>
    <li>All Firefox for Android description listings ready for the release channel: <?=$base?><a href="api/fx_android/done/release/">fx_android/done/release/</a></li>
    <li>All Firefox for iOS description listings ready for the release channel: <?=$base?><a href="api/fx_ios/done/release/">fx_ios/done/release/</a></li>
</ul>

<h3 class="text-primary">{product}/translation/{channel}/{locale}/</h3>
<h4>Description:</h4>
<p>Return the translation for a page listing for the store and channel selected.</p>
<h4>Examples:</h4>
<p>Translation of the Google Play listing for Japanese, release channel: <?=$base?><a href="api/fx_android/translation/release/ja/">fx_android/translation/release/ja/</a></p>
<h4>Output for Google Play:</h4>
<p>
<pre><code class="json">{
    "title": "Blabla",
    "short_desc": "Blabla",
    "long_desc": "Blabla",
    "whatsnew": "Blabla"
}</code></pre>
</p>

<p>Translation of Firefox for iOS listing for French: <?=$base?><a href="api/fx_ios/translation/release/fr/">fx_ios/translation/release/fr/</a></p>
<h4>Output for Apple AppsStore:</h4>
<p>
<pre><code class="json">{
    "title": "Blabla",
    "description": "Blabla",
    "keywords": "Blabla",
    "screenshots": [
        {
            "title": "Title for screenshot 1",
            "text": "Text for \nscreenshot 1,\n note the line breaks"

        },
        {
            "title": "Title for screenshot 2",
            "text": "Text for \nscreenshot 2,\n note the line breaks"
        }
    ]
}</code></pre>
</p>
<h2 class="bg-primary">&nbsp;NOTES</h2>
<ol>
    <li>Invalid API calls return a 400 HTTP error and a json file explaining the problem with this format:
<pre><code class="json">{
    "error": "Explanation of the error"
}</code></pre>
    </li>
    <li>If you find a bug or would like an improvement to the API, please <a href="https://github.com/mozilla-l10n/stores_l10n/issues">file an issue on Github</a>.</li>
</ol>
