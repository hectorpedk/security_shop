<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header('Location:index.php');
	}

	use Resources\Library as Lib;
	use Resources\Classes as Cls;
	use Resources\DI;

	require_once realpath(dirname(__FILE__) . '/../resources/config.php');
	require_once LIBRARY_PATH . '/templateFunctions.php';
	require_once CONTAINER_PATH;



	$member = DI\Container::makeMemberLogin( $_SESSION['user_id'] , $db_config );
	var_dump( $member );

	$variablesForContent = array(
		'member'	=>	$member
	);

	Lib\renderLayoutWithContentFile("home.php" , $variablesForContent );