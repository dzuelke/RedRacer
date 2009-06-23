<form action="<?php echo $ro->gen(null); ?>" method="post">
	Name: <input type="text" name="name" />
	<br />Type: <select name="type">
		<option value="0">-- Select --</option>
		<?php foreach($t['projectTypes'] as $pt): ?>
			<option value="<?php echo $pt['id']; ?>"><?php echo $pt['type']; ?></option>
		<?php endforeach; ?>
	</select>
	<br />Description:
	<br /><textarea rows="6" cols="50" name="description"></textarea>
	<br /><input type="submit" value="Create Project" />
</form>