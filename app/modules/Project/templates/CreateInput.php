<form action="<?php echo $ro->gen(null); ?>" method="post">
	Name: <input type="text" name="name" />
	<br />Tags:
  <?php $i = 0; ?>
  <?php foreach($t['tags'] as $tag): ?>
    <br /><?php echo $tag['name']; ?>
    <input type="checkbox" name="tags[<?php echo $i; ?>]" value="<?php echo $tag['name']; ?>" />
    <?php ++$i; ?>
  <?php endforeach; ?>
  <br />SCM URL: <input type="text" name="scm_url" />
  <br />Bug tracker URL: <input type="text" name="bug_tracker_url" />
	<br />Short Description:
	<br /><textarea rows="3" cols="50" name="short_description"></textarea>
  <br />Long Description:
	<br /><textarea rows="12" cols="50" name="long_description"></textarea>
	<br /><input type="submit" value="Create Project" />
</form>