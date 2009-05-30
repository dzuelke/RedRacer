<table>
<thead>
<tr>
	<th>Key</th>
	<th>Value</th>
</tr>
</thead>
<tbody>
<?php 
$userinfo = $t['user']->toArray();
foreach ($userinfo as $key => $value) {
?>
<tr>
	<td><?php echo ucfirst($key); ?></td>
	<td><?php echo $value; ?></td>
</tr>
<?php 
}
?>
</tbody>
</table>