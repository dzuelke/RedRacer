<p><a href="<?php echo $ro->gen('user.index'); ?>">Cancel</a></p>
<form action="<?php echo $ro->gen('user.updateinformation'); ?>" method="post">
    <table>
        <tbody>
            <tr>
                <td>Username</td>
                <td><?php echo $t['user']->username; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" value="<?php echo $t['user']->email; ?>" /></td>
            </tr>
            <tr>
                <td>Real Name</td>
                <td><input type="text" name="realname" value="<?php echo $t['user']->realname; ?>" /></td>
            </tr>
            <tr>
                <td>Rights</td>
                <td><?php echo $t['user']->role; ?></td>
            </tr>
        </tbody>
    </table>
    <input type="submit" value="Update" />
</form>