<?php

// Backup argv, otherwise stripped by agavi
$args = $_SERVER['argv'];

require('../../libs/agavi/agavi.php');
require('../../app/config.php');

Agavi::bootstrap('development.benjamin');

spl_autoload_register(array('Doctrine', 'autoload'));

$con = AgaviContext::getInstance('console')->getDatabaseConnection();

$dir = dirname(__FILE__);

$config = array(
	'data_fixtures_path'  => AgaviConfig::get('doctrine.fixture_dir', $dir . '/data/fixtures'),
	'models_path' => AgaviConfig::get('core.lib_dir') . '/doctrine',
	'migrations_path' =>  AgaviConfig::get('doctrine.migration_dir', $dir . '/migrations'),
	'sql_path' => AgaviConfig::get('doctrine.migration_dir', $dir . '/data/sql'),
	'yaml_schema_path' =>  AgaviConfig::get('doctrine.schema_dir', $dir . '/schema/schema.yml'),
	'generate_models_options' => array(
//		'base_class_name' => 'RedracerDoctrineRecord',
		'suffix' => '.class.php'
	)
);


// Configure Doctrine Cli
$cli = new Doctrine_Cli($config);
$cli->run($args);

?>