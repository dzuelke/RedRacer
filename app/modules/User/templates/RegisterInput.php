<div id="register">
<form method="post" action="<?php echo $ro->gen('user.register'); ?>" id="register">
<fieldset>
	<legend>Register</legend>
	<label for="username">Username:</label>
	<input id="username" type="text" name="username" value="" size="30"/>
	<label for="realname">Real Name:</label>
	<input id="realname" type="text" name="realname" value="" size="150"/>
	<label for="email">Email address:</label>
	<input id="email" type="text" name="email" value="" size="150"/>
	<label for="password">Password:</label>
	<input id="password" type="password" name="password" value="" />
	<label for="password">Retype Password:</label>
	<input id="password2" type="password" name="password2" value="" />
	<input id="submit" type="submit" name="add" value="Register" />
</fieldset>
</form>
</div>
