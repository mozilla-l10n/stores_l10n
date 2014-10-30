<table>
<tr>
    <th>Locale</th>
    <th>General View</th>
    <th>Description Raw HTML</th>
    <th>Description Json</th>
</tr>
<?php foreach($android_locales as $lang): ?>
<tr>
    <th><?=$lang?></th>
    <td><a href='./?locale=<?=$lang?>'>View</a></td>
    <td><a href='./?locale=<?=$lang?>&amp;output=html'>HTML</a></td>
    <td><a href='./?locale=<?=$lang?>&amp;output=json'>Json</a></td>
</tr>
<?php endforeach; ?>
</table>
