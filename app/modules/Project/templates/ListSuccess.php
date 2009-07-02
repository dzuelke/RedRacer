<form action="<?php echo $ro->gen(null); ?>" method="get" id="listform">
	Search name &amp; description:
	<br /><input type="text" name="search" />
	<br />
	<br />Only include projects made by user:
	<br /><input type="text" name="user" />
	<br />
	<br />Only include these project types:
	<?php foreach ($t['projectTypes'] as $pt): ?>
		<br /><?php echo ucwords($pt['type']); ?>
		<input type="checkbox" name="projectTypes[]"
			value="<?php echo $pt['type']; ?>" checked="checked" />
	<?php endforeach; ?>
	<br /><input type="submit" value="Search!" />
</form>

<p>Jump to page:
<?php
	end($t['relevantPages']);
	$lastpNum = current($t['relevantPages']);
	reset($t['relevantPages']);
?>
<?php foreach ($t['relevantPages'] as $pNum): ?>
	<a href="<?php echo $ro->gen(null, array('page' => $pNum)); ?>">
		<?php echo $pNum; ?>
	</a><?php if ($lastpNum != $pNum): ?>,<?php endif; ?>
<?php endforeach ?>
</p>

<?php
	$fieldIndex = $t['fieldDataIndexes']['field'];
	$readableIndex = $t['fieldDataIndexes']['readable'];
	$orderModeIndex = $t['fieldDataIndexes']['orderMode'];
	$nextOrderModeIndex = $t['fieldDataIndexes']['nextOrderMode'];
	$fieldData = $t['fieldData'];
?>
<?php if(empty($t['projects'])): ?>
	<p><strong>No results found.</strong></p>
<?php else: ?>
<table>
	<thead>
		<tr>
		<?php foreach ($fieldData as $fd): ?>
			<th><a href="<?php echo $ro->gen(null, array(
					'orderby' => $fd[$fieldIndex],
					'ordermode' => $fd[$nextOrderModeIndex]
					)
				); ?>"><?php echo $fd[$readableIndex]; ?>
				<?php if ($fd[$orderModeIndex] == 'descending'): ?>
					<img src="images/arrow_down.png" alt="Descending" />
				<?php elseif ($fd[$orderModeIndex] !== null): ?>
					<img src="images/arrow_up.png" alt="Ascending" />
				<?php endif; ?>
				</a></th>
		<?php endforeach; ?>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($t['projects'] as $project): ?>
		<tr>
			<td><a href="<?php echo $ro->gen('project.read',
				array('project' => $project['name']));
			?>"><?php echo $project['name']; ?></a></td>
			<td><?php echo $project['type']['type']; ?></td>
			<td><?php echo $project['average_rating']; ?></td>
			<td><?php echo $project['number_of_ratings']; ?></td>
			<td><?php echo $project['description']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>