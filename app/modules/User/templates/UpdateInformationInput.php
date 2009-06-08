<?php $userinfo = $us->getAttribute('userinfo'); ?>
<p><a href="<?php echo $ro->gen('user.index'); ?>">Cancel</a></p>
<form action="<?php echo $ro->gen('user.updateinformation'); ?>" method="post">
    <table>
        <tbody>
            <tr>
                <td>Username</td>
                <td><?php echo $userinfo['username']; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" value="<?php echo $userinfo['email']; ?>" /></td>
            </tr>
            <tr>
                <td>Real Name</td>
                <td><input type="text" name="realname" value="<?php echo $userinfo['realname']; ?>" /></td>
            </tr>
            <tr>
                <td>Rights</td>
                <td><?php echo $userinfo['role']; ?></td>
            </tr>
        </tbody>
    </table>
    <input type="submit" value="Update" />
</form>
