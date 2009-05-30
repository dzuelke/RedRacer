<?php
require('../libs/agavi/agavi.php');
require('../app/config.php');
Agavi::bootstrap('development.benjamin');

spl_autoload_register(array('Doctrine', 'autoload'));

$context = AgaviContext::getInstance('');

$user = new Users();
$user->fromArray(array('username' => 'admin',
	'password' => 'admin',
	'email' => 'admin@redracer.org'));

$db = $context->getDatabaseConnection('doctrine');
$db->getTable('Users')->validateUniques($user);
echo $user->getErrorStackAsString();

?>