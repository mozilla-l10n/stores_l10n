<?php
$base = '<em class="dim">' . BASE_HTML_URL . '</em>';
?>

<h2>API calls available</h2>
<p>Optional <var>channel</var> parameter:</p>
<ul>
    <li>Aurora: <var>org.mozilla.fennec_aurora</var></li>
    <li>Beta: <var>org.mozilla.firefox_beta</var></li>
    <li>Release: <var>org.mozilla.firefox</var></li>
</ul>
<p>If the <var>channel</var> parameter is not provided, it will default to the Release channel</p>
<dl>
    <dt>List all Firefox Android locale codes:</dt>
    <dd>
        <strong>AURORA:</strong>
        <?=$base?><a href="api/?firefox_locales&amp;channel=org.mozilla.fennec_aurora">api/?firefox_locales&amp;channel=org.mozilla.fennec_aurora</a><br>
        <strong>BETA:</strong>
        <?=$base?><a href="api/?firefox_locales&amp;channel=org.mozilla.firefox_beta">api/?firefox_locales&amp;channel=org.mozilla.firefox_beta</a><br>
        <strong>RELEASE:</strong>
        <?=$base?><a href="api/?firefox_locales&amp;channel=org.mozilla.firefox">api/?firefox_locales&amp;channel=org.mozilla.firefox</a>
    </dd>

    <dt>List all Google Play locale codes:</dt>
        <dd><?=$base?><a href="api/?play_locales">api/?play_locales</a></dd>
    <dt>Google Play => Mozilla locale mapping:</dt>
        <dd><?=$base?><a href="api/?locale_mapping">api/?locale_mapping</a> <br>Note: <var>False</var> = not a locale supported by Mozilla.</dd>
    <dt>Mozilla => Google Play locale mapping:</dt>
        <dd><?=$base?><a href="api/?locale_mapping&amp;reverse">api/?locale_mapping&amp;reverse</a></dd>
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

<h2>Future API calls (not yet implemented)</h2>
<dl>
    <dt>List locales with translation done:</dt>
    <dd>
        <strong>AURORA:</strong>
            <?=$base?><a href="api/?done&amp;channel=org.mozilla.fennec_aurora">api/?done&amp;channel=org.mozilla.fennec_aurora</a><br>
        <strong>BETA:</strong>
            <?=$base?><a href="api/?done&amp;channel=org.mozilla.firefox_beta">api/?done&amp;channel=org.mozilla.firefox_beta</a><br>
        <strong>RELEASE:</strong>
            <?=$base?><a href="api/?done&amp;channel=org.mozilla.firefox">api/?done&amp;channel=org.mozilla.firefox</a><br>
    </dd>
    <dt>Translation for a locale:</dt>
    <dd>
        <strong>AURORA:</strong>
            <?=$base?><a href="api/?locale=fr&amp;channel=org.mozilla.fennec_aurora">api/?locale=fr&amp;channel=org.mozilla.fennec_aurora</a><br>
        <strong>BETA:</strong>
            <?=$base?><a href="api/?locale=fr&amp;channel=org.mozilla.firefox_beta">api/?locale=fr&amp;channel=org.mozilla.firefox_beta</a><br>
        <strong>RELEASE:</strong>
            <?=$base?><a href="api/?locale=fr&amp;channel=org.mozilla.firefox">api/?locale=fr&amp;channel=org.mozilla.firefox</a><br>
    </dd>
</dl>
