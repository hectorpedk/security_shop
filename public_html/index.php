<?php
    use Resources\Library as Lib;
    use Resources\Classes as Cls;

	require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
	require_once(LIBRARY_PATH . "/templateFunctions.php");
    require_once(CLASSES_PATH . "/database.class.php");

    $test = new Cls\Database();

$database = $test->connect();
$database = $test->tableExists('dimul');
var_dump($database);


/*
    Now you can handle all your php logic outside of the template
    file which makes for very clean code!
*/
	
//	$setInIndexDotPhp = "I am set in the index.php file.";
//
//    $test = "This is in index.php that is included in different place";
	
	// Must pass in variables (as an array) to use in template
//	$variables = array(
//		'setInIndexDotPhp' => $setInIndexDotPhp,
//        'test'             => $test
//	);
	
	Lib\renderLayoutWithContentFile("home.php");

?>