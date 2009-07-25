<h2>Project Name: <?php echo $t['project']['name']; ?></h2>

<?php if ($t['belongsToCurrentUser']): ?>
	<p>You are a maintainer of this project!
	<br /><a href="<?php echo $ro->gen('project.update'); ?>">Update Project</a>
	</p>
<?php endif; ?>

<?php if ($t['rating'] === false): ?>
<p>Current Rating: N/A</p>
<?php else: ?>
<p>Current Rating: <?php echo round($t['rating'] * 100); ?>%</p>
<?php endif; ?>

<p><?php echo $t['project']['long_description']; ?></p>

<h3>Developers</h3>
<ul>
<?php foreach ($t['developers'] as $d): ?>
	<li><?php echo $d['name']; ?></li>
<?php endforeach; ?>
</ul>

<h3>Latest Release</h3>
<?php if ($t['latestRelease'] === false): ?>
<p>No releases!</p>
<?php else: ?>
<p><?php echo $t['latestRelease']['description']; ?></p>
<?php endif; ?>

<h3>All Releases</h3>
<?php if (empty($t['releases'])): ?>
<p>No releases!</p>
<?php endif; ?>
<?php foreach ($t['releases'] as $r): ?>
  <p>Date: <?php echo date('Y/m/d', $r['date']); ?>
  <br />Rating:
  <?php if ($r['ratingPercent'] === false): ?>
    N/A
  <?php else: ?>
    <?php echo $r['ratingPercent']; ?>%
  <?php endif; ?>
  (<?php echo $r['numRatings']; ?> rates)
  <br />Description: <?php echo $r['description']; ?>
  </p>
<?php endforeach; ?>