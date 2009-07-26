<?php $userinfo = $us->getAttribute('userinfo'); ?>
<p><a href="<?php echo $ro->gen('user.index'); ?>">Cancel</a></p>
<form action="<?php echo $ro->gen('user.updateinformation'); ?>" method="post">
    <table>
        <tbody>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($userinfo['name']); ?>" /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" value="<?php echo htmlspecialchars($userinfo['email']); ?>" /></td>
            </tr>
            <tr>
                <td>Wesite</td>
                <td><input type="text" name="website" value="<?php echo htmlspecialchars($userinfo['website_url']); ?>" /></td>
            </tr>
            <tr>
                <td>Avatar</td>
                <td><input type="text" name="avatar" value="<?php echo htmlspecialchars($userinfo['avatar_url']); ?>" /></td>
            </tr>
        </tbody>
    </table>
    <input type="submit" value="Update" />
</form>