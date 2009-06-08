<div id="changepw">
<p><a href="<?php echo $ro->gen('user.index') ?>">Cancel</a></p>
<form method="post" action="<?php echo $ro->gen('user.changepassword'); ?>" id="redracer-changepassword">
<fieldset>
	<legend>Sign-In</legend>
	<label for="newpassword">New Password:</label>
	<input id="newpassword" type="password" name="newpassword" value="" />
	<label for="newpassword2">Retype new Password:</label>
	<input id="newpassword2" type="password" name="newpassword2" value="" />
	<label for="oldpassword">Old Password:</label>
	<input id="oldpassword" type="password" name="oldpassword" value="" />
	<input id="submit" type="submit" name="inputsubmit1" value="Change" />
</fieldset>
</form>
</div>
