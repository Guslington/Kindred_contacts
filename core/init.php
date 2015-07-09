<?php
/**
	* Init.php
	*
	* Initialises configuration variables and users session, imports required classes
	*
	* @author	Angus Vine <angus.vine@internode.on.net>
	* @version	1.0
	* @since	5.5	(The php version used)
*/

error_reporting(~0);

date_default_timezone_set("Australia/Melbourne"); 

session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'kindred_contacts',
		'password' => 'BETG9fc4D6ejERRv',
		'db' => 'kindred_contacts'
	),
);

spl_autoload_register(function($class) {
	require_once 'classes/' . $class . '.php';
});

require_once 'functions/general.php';

?>