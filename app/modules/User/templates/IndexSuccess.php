<h3>Actions</h3>
<p><a href="<?php echo $ro->gen('project.create'); ?>">Create a project</a></p>
<p><a href="<?php echo $ro->gen('project.list',
	array('owner' => $t['user']['email'])); ?>">See projects you own</a></p>

<h3>Current Informaton</h3>

<table>
    <tbody>
        <tr>
            <td>Name</td>
            <td><?php echo $t['user']['name']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $t['user']['email']; ?></td>
        </tr>
        <tr>
            <td>Website</td>
            <td><a href="<?php echo $t['user']['website_url']; ?>">
                <?php echo $t['user']['website_url']; ?></a>
            </td>
        </tr>
        <tr>
          <td>Avatar</td>
          <td><?php if ($t['user']['avatar_url'] == ''): ?>
              N/A
            <?php else: ?>
              <img src="<?php echo $t['user']['avatar_url']; ?>" />
            <?php endif; ?>
          </td>
        </tr>
    </tbody>
</table>
<p><a href="<?php echo $ro->gen('user.updateinformation'); ?>">Update Information</a>
<br /><a href="<?php echo $ro->gen('user.changepassword'); ?>">Change Password</a></p>

<h3>**DEV** info</h3>
<table>
<thead>
<tr>
	<th>Key</th>
	<th>Value</th>
</tr>
</thead>
<tbody>
<?php 
foreach ($t['user'] as $key => $value) {
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
