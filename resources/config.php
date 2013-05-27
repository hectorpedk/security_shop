<?php

/*
	The important thing to realize is that the config file should be included in every
	page of your project (or at least any page you want access to these settings).
	This allows you to confidently use these settings throughout a big project because
	if something changes such as your DB credentials or a path to a specific resource
	you'll only need to update it here.
*/

$config = array(
	"db" => array(
		"db1" => array(
			"dbname" => "securityshop",
			"username" => "securityshop",
			"password" => "securityshop",
			"host" => "localhost"
		),
	),
	"paths" => array(
		"resources" => "/resources",
		"images" => array(
			"content" => $_SERVER["DOCUMENT_ROOT"] . "/public_html/img",
			"layout" => $_SERVER["DOCUMENT_ROOT"] . "/public_html/img/layout"
		)
	)
);

/*
	Creating constants for heavily used paths makes things a lot easier.
	ex. require_once(LIBRARY_PATH . "Paginator.php")
*/
defined("LIBRARY_PATH")
	or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
	
defined("TEMPLATES_PATH")
	or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

defined("CLASSES_PATH")
        or define("CLASSES_PATH", realpath(dirname(__FILE__) . '/classes'));

/*
	Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRICT);



?>