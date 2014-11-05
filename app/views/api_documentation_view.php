<?php
$base = '<em class="dim">' . BASE_HTML_URL .'</em>';
?>

<h2>API calls available</h2>

<dl>
    <dt>List all Firefox Android locale codes:</dt>
        <dd><?=$base?><a href="api/?firefox_locales">api/?firefox_locales</a></dd>
    <dt>List all Google Play locale codes:</dt>
        <dd><?=$base?><a href="api/?play_locales">api/?play_locales</a></dd>
    <dt>Google Play => Mozilla locale mapping:</dt>
        <dd><?=$base?><a href="api/?locale_mapping">api/?locale_mapping</a>. <br>Note: <var>False</var> = not a locale supported by Mozilla.</dd>
    <dt>Mozilla => Google Play locale mapping:</dt>
        <dd><?=$base?><a href="api/?locale_mapping&amp;reverse">api/?locale_mapping&amp;reverse</a>.</dd>
    <dt>List locales with translation done:</dt>
        <dd><?=$base?><a href="api/?done">api/?done</a></dd>
    <dt>Translation for a locale:</dt>
        <dd><?=$base?><a href="api/?locale=fr">api/?locale=fr</a>
        <br>Format:
        <pre><code class="json">{
    "title": "Blabla",
    "short_desc": "Blabla",
    "long_desc": "blabla"
}</code></pre>
        </dd>
</dl>
