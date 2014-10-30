<table>
<tr>
    <th>Locale</th>
    <th>View</th>
<!--     <th>Raw HTML</th>
    <th>Raw Text</th>
 -->    <th>Json</th>
</tr>
<?php foreach($android_locales as $lang): ?>
<tr>
    <th><?=$lang?></th>
    <td><a href='./?locale=<?=$lang?>'>View</a></td>
    <!-- <td></td>
    <td></td> -->
    <td><a href='./?locale=<?=$lang?>&amp;output=json'>Json</a></td>
</tr>
<?php endforeach; ?>
