<?php
    use Resources\Library as Lib;
    use Resources\Classes as Cls;

	require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
	require_once(LIBRARY_PATH . "/templateFunctions.php");
	//require_once(LIBRARY_PATH . "/PasswordHash.php");
    require_once(CLASSES_PATH . "/database.class.php");
    
    $db = new Cls\Database('localhost', 'security_shop', '987654321', 'shop_user');
	$db->connect();

	
	//Lib\renderLayoutWithContentFile("home.php");
    
    
    // Reviews REST service, Motiejus
    if(isset($_GET['json']) && $_GET['json'] == '1'){
        
        if(isset($_GET['review']) && is_numeric($_GET['review'])){
            
            $review = $db->select('reviews', '*', 'id='.$_GET['review']);
            $review = $db->getResult();
            
            Lib\renderContentFile("review.get.php", array(
                'review' => $review
                //others vars probably needed here like 'is_logged' => bool
                ));
            
        }
        
        if(isset($_POST['review']) && is_numeric($_POST['id'])){
            
            //add review to the db
            
        }
        
        exit();
    }
    
    Lib\renderLayoutWithContentFile("home.php");

?>