<?php
    use Resources\Library as Lib;
    use Resources\Classes as Cls;

	require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
	require_once(LIBRARY_PATH . "/templateFunctions.php");
	require_once(LIBRARY_PATH . "/PasswordHash.php");
    require_once(CLASSES_PATH . "/database.class.php");


	$db = new Cls\Database('localhost', 'security_shop', '987654321', 'shop_user');
	$db->connect();

	
	Lib\renderLayoutWithContentFile("home.php");

?>