<h2>Project Name: <?php echo $t['project']['name']; ?></h2>

<?php if ($t['belongsToCurrentUser']): ?>
	<p>You are a maintainer of this project!
	<br /><a href="<?php echo $ro->gen('project.update'); ?>">Update Project</a>
	</p>
<?php endif; ?>

<p>Type: <?php echo $t['project']['type']['type']; ?>
<br />Description: <?php echo $t['project']['description']; ?></p>

<h3>Maintainers</h3>
<ul>
<?php foreach ($t['maintainers'] as $m): ?>
	<li><?php echo $m['username']; ?></li>
<?php endforeach; ?>
</ul>

<h3>Comments</h3>
<?php foreach ($t['comments'] as $c): ?>
	<p>On <?php echo $c['date']; ?>,
	<?php echo $c['user']['username']; ?> said: <?php echo $c['comment']; ?></p>
<?php endforeach; ?>