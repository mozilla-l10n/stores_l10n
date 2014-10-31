<h2>Web application generating localized Google Play descriptions based on a template</h2>
<p><strong>Current template used: </strong><?= key($current_template) ?></p>
<table>
<tr>
    <th>Locale<br><sup>{<a href="./?locale_list=all&amp;output=json">json</a>}</sup></th>
    <th>Completion</th>
    <th>General View</th>
    <th>Description Raw HTML</th>
    <th>Description Json</th>
</tr>
<?php foreach($android_locales as $lang): ?>
<tr>
    <th><?=$lang?></th>
    <td class='<?=$status[$lang]?>'><?=$status[$lang]?></td>
    <td><a href="./?locale=<?=$lang?>">Show</a></td>
    <td><a href="./?locale=<?=$lang?>&amp;output=html">HTML</a></td>
    <td><a href="./?locale=<?=$lang?>&amp;output=json">Json</a></td>
</tr>
<?php endforeach; ?>
</table>
