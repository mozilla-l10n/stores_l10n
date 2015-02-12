<h2>Web application generating localized Google Play descriptions based on a template</h2>
<p><strong>Current template used: </strong><?= key($current_template) ?></p>
<table>
<tr>
    <th>Locale</th>
    <th>Completion</th>
    <th>General View</th>
    <th>Description Raw HTML</th>
    <th>Description Json</th>
</tr>
<?php foreach ($google_mozilla_supported as $lang): ?>
<tr>
    <th><?=$lang?></th>
    <td class='<?=$status[$lang]?>'><?=$status[$lang]?></td>
    <td><a href="./locale/?code=<?=$lang?>">Show</a></td>
    <td><a href="./locale/?code=<?=$lang?>&amp;output=html">HTML</a></td>
    <td><a href="./api/?locale=<?=$lang?>">Json</a></td>
</tr>
<?php endforeach; ?>
</table>
