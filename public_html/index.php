<?php
    use Resources\Library as Lib;
    use Resources\Classes as Cls;
	use Resources\DI;

	require_once realpath(dirname(__FILE__) . '/../resources/config.php');
	require_once LIBRARY_PATH . '/templateFunctions.php';
    require_once CONTAINER_PATH;


	if ( isset( $_POST[ 'username' ] ) ) {
			$member = DI\Container::makeMember( $db_config );
			if ( $member->login( $_POST[ 'username' ] , $_POST[ 'password' ] ) ) {
				session_start();
				$_SESSION[ 'user_id' ] = $member->getId();
				header('HTTP/1.1 303 See Other');
				header('Location: home.php');
				exit();
			}
		} else {
			$error = "User does not exist!";
		}


	Lib\renderLayoutWithContentFile("login.php");



?>