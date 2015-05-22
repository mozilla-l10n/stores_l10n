<?php
$base = '<em class="dim">' . BASE_HTML_URL . 'api/</em>';
?>
<div class="page-header">
    <h1>JSON API description</h1>
</div>

<h2 class="bg-primary">&nbsp;Variables used in the API</h2>
<ul>
    <li><code>{store}</code>: <var>google</var>, <var>apple</var></li>
    <li><code>{channel}</code>: <var>aurora</var>, <var>beta</var>, <var>release</var></li>
    <li><code>{locale}</code>: a Mozilla locale code, ex: fr, es-MX, de.</li>
</ul>

<h2 class="bg-primary">&nbsp;API Calls</h2>
<h3 class="text-primary">{store}/storelocales/</h3>
<h4>Description:</h4>
<p>This call will list all the locales that the store supports.</p>
<h4>Example:</h4>
<p>List of Google Play locale codes: <?=$base?><a href="api/google/storelocales/">google/storelocales/</a></p>


<h3 class="text-primary">{store}/localesmapping/</h3>
<h4>Description:</h4>
<p>Lists the mapping of locale codes between the store and Mozilla locale codes</p>
<h4>Example:</h4>
<p>Locale mapping for Google Play: <?=$base?><a href="api/google/localesmapping/">google/localesmapping/</a></p>
<h4>Notes:</h4>
<ul>
    <li><code>False</code>: not a locale supported by Mozilla.</li>
    <li>There is an optional <var>reverse</var> parameter that can be appended as a query string, ex: <?=$base?><a href="api/google/localesmapping/?reverse">google/localesmapping/?reverse</a>. <br>This will output a mapping based on Mozilla codes and not the store codes, which means that locales Mozilla doesn't support but are supported by the store are not listed.</li>
</ul>

<h3 class="text-primary">{store}/firefoxlocales/{channel}/</h3>
<h4>Description:</h4>
<p>List all Firefox locale codes supported for a release and a platform</p>
<h4>Example:</h4>
<p>All Firefox for Android locales on the release Channel: <?=$base?><a href="api/google/firefoxlocales/release/">google/firefoxlocales/release/</a></p>

<h3 class="text-primary">{store}/done/{channel}/</h3>
<h4>Description:</h4>
<p>List all the locales for which the store description page is fully translated for a channel</p>
<h4>Example:</h4>
<p>All Firefox for Android description listings ready for the release channel: <?=$base?><a href="api/google/done/release/">google/done/release/</a></p>

<h3 class="text-primary">{store}/translation/{channel}/{locale}/</h3>
<h4>Description:</h4>
<p>Return the translation for a page listing for the store and channel selected.</p>
<h4>Example:</h4>
<p>Translation of the Google Play listing for Japanese, release channel: <?=$base?><a href="api/google/translation/release/ja/">/google/translation/release/ja/</a></p>
<h4>Output:</h4>
<p>
<pre><code class="json">{
    "title": "Blabla",
    "short_desc": "Blabla",
    "long_desc": "blabla"
}</code></pre>
</p>
<h2 class="bg-primary">&nbsp;NOTES</h2>
<ol>
    <li>Invalid API calls return a 400 HTTP error and a json file explaining the problem with this format:
<pre><code class="json">{
    "error": "Explanation of the error"
}</code></pre>
    </li>
    <li>Altough the app technically does support Apple AppStore, this is not enabled yet since we haven't yet shipped for this platform and we don't know yet this Store technical constraints.</li>
    <li>If you find a bug or would like an improvement to the API, please <a href="https://github.com/mozilla-l10n/stores_l10n/issues">file an issue on Github</a>.</li>
</ol>
