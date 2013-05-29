<?php
    use Resources\Library as Lib;
    use Resources\Classes as Cls;
	use Resources\DI\Container;

	require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
	require_once(LIBRARY_PATH . "/templateFunctions.php");
	require_once(LIBRARY_PATH . "/PasswordHash.php");
	require_once( CONTAINER_PATH . "/container.class.php" );


	
	//Lib\renderLayoutWithContentFile("home.php");

?>