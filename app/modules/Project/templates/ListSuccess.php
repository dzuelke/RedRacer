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
<table>
	<thead>
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
	</thead>
	<tbody>
	<?php foreach($t['projects'] as $project): ?>
		<tr>
			<td><?php echo $project['name']; ?></td>
			<td><?php echo $project['type']; ?></td>
			<td><?php echo $project['average_rating'] ?></td>
			<td><?php echo $project['number_of_ratings'] ?></td>
			<td><?php echo $project['description']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>