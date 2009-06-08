<h3>Current Informaton</h3>

<table>
    <tbody>
        <tr>
            <td>Username</td>
            <td><?php echo $t['user']->username; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $t['user']->email; ?></td>
        </tr>
        <tr>
            <td>Real Name</td>
            <td><?php echo $t['user']->realname; ?></td>
        </tr>
        <tr>
            <td>Rights</td>
            <td><?php echo $t['user']->role; ?></td>
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
