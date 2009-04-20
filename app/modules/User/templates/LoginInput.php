<div id="login">
<form method="post" action="<?php echo $ro->gen('login'); ?>" id="redracer-login">
<fieldset>
	<legend>Sign-In</legend>
	<label for="username">Username:</label>
	<input id="username" type="text" name="username" value="" />
	<label for="password">Password:</label>
	<input id="password" type="password" name="password" value="" />
	<label for="remember">Remember me: <input id="remember" type="checkbox" name="remember" /></label>
	<input id="submit" type="submit" name="inputsubmit1" value="Sign In" />
	<p><a href="<?php echo $ro->gen('lostpassword'); ?>">Passwort vergessen?</a></p>
</fieldset>
</form>
</div>