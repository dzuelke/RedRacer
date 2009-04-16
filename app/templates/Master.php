<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<base href="<?php echo $ro->getBaseHref(); ?>" />
		<link rel="stylesheet" type="text/css" href="/css/styles.css" media="screen, projection" />
		<title><?php if(isset($t['_title'])) echo htmlspecialchars($t['_title']) . ' - '; echo AgaviConfig::get('core.app_name'); ?></title>
	</head>
	<body>
	<div id="outer">
	<div id="header">
		<h1><a href="http://www.redracer.org">Redracer</a></h1>
		<h2>a generic forge based on <a href="http://www.agavi.org">Agavi</a></h2>
	</div>
	<div id="menu">
		<ul>
			<li class="first"><a href="#" accesskey="1" title="">Home</a></li>
			<li><a href="#" accesskey="2" title="">About Us</a></li>
			<li><a href="#" accesskey="3" title="">Products</a></li>
			<li><a href="<?php echo $ro->gen('login');?>" accesskey="4" title="">Login</a></li>
			<li><a href="<?php echo $ro->gen('logout');?>" accesskey="5" title="">Logout</a></li>
		</ul>
	</div>
	<div id="content">
		<div id="featured">
			<h3>Etiam suscipit et</h3>
			<p>Rhoncus ac, lacinia, nisl. Aliquam gravida massa eu arcu. <a href="#">More&#8230;</a></p>
			<h3>Fusce dolor tristique</h3>
			<p>Sed eu eros imperdiet eros interdum blandit. Vivamus sagittis bibendum erat. Curabitur malesuada. <a href="#">More&#8230;</a></p>
			<h3>Nunc pellentesque</h3>
			<p>Sed vestibulum blandit nisl. Quisque elementum convallis purus. Suspendisse potenti. Donec nulla est, laoreet quis, pellentesque in. <a href="#">More&#8230;</a></p>
			<h3>Ipsum Dolorem</h3>
			<ul>
				<li><a href="#">Sagittis Bibendum Erat</a></li>
				<li><a href="#">Malesuada Turpis</a></li>
				<li><a href="#">Quis Gravida Massa</a></li>
				<li><a href="#">Inerat Viverra Ornare</a></li>
			</ul>
		</div>
		<div id="primary">
			<?php if(isset($t['_title'])) echo '<h2>' . htmlspecialchars($t['_title']) . '</h2>'; ?>
			<?php echo $slots['flash']; ?>
			<?php echo $inner; ?>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer">
		<p>Copyright &#169; 2009 http://www.redracer.org. </p>
	</div>
</div>
	</body>
</html>
