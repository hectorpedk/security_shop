<?php

/*
	The important thing to realize is that the config file should be included in every
	page of your project (or at least any page you want access to these settings).
	This allows you to confidently use these settings throughout a big project because
	if something changes such as your DB credentials or a path to a specific resource
	you'll only need to update it here.
*/

$db_config = array(
		"db_host" => "localhost",
		"db_name" => "security_shop",
		"db_user" => "shop_admin",
		"db_pass" => "123456789",
	);
$paths = array(
	"CLASSES" 	=>	"/classes",
	"DB"		=>	"/classes/database.class.php",
	"CONTAINER"	=>	"/container/container.class.php",
	"LIBRARY" 	=>	"/library",
	"TEMPLATES" =>	"/templates",
	"CONTENTS"	=>	"/content",
	"IMAGES" => array(
		"content" => $_SERVER["DOCUMENT_ROOT"] . "/public_html/img",
		"layout" => $_SERVER["DOCUMENT_ROOT"] . "/public_html/img/layout"
		)
	);

/*
	Creating constants for heavily used paths makes things a lot easier.
	ex. require_once(LIBRARY_PATH . "/Pagination.php")
*/
	$keys = array_keys( $paths );
	for( $i = 0 ; $i < count( $paths ) ; $i++){

		if ( !is_array( $paths[ $keys[$i] ] ) ){

			defined( $keys[ $i ] . '_PATH' )
				or define( $keys[ $i ] . "_PATH", realpath( dirname(__FILE__) . $paths[ $keys[ $i ] ] ) );

		}

	}
/*
	Error reporting.
*/
	ini_set("error_reporting", "true");
	error_reporting(E_ALL|E_STRICT);

?>