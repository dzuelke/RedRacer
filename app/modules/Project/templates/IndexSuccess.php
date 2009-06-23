<p>The public project hub</p>

<p><a href="<?php echo $ro->gen('project.list'); ?>">Project List</a></p>

<div>
	<div style="width:50%;float:left;">
		<h3>Latest Projects</h3>
		<table>
			<thead>
				<th>Name</th>
				<th>Created</th>
			</thead>
			<tbody>
			<?php foreach($t['latestProjects'] as $p): ?>
				<tr>
					<td><?php echo $p['name']; ?></td>
					<td><?php echo date('Y/m/d', strtotime($p['created_at'])); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div style="width:50%;float:left;">
		<h3>Popular Projects</h3>
		<table>
			<thead>
				<th>Name</th>
				<th>Avg. Rating</th>
			</thead>
		<?php foreach($t['popularProjects'] as $p): ?>
			<tr>
				<td><?php echo $p['name']; ?></td>
				<td><?php echo $p['average_rating']; ?>
					(<?php echo $p['number_of_ratings']; ?> rates)</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
</div>