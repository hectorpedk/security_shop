<?php
    use Resources\Library as Lib;
    use Resources\Classes as Cls;

	require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
	require_once(LIBRARY_PATH . "/templateFunctions.php");
	//require_once(LIBRARY_PATH . "/PasswordHash.php");
    require_once(CLASSES_PATH . "/database.class.php");
    
    $db = new Cls\Database('localhost', 'security_shop', '987654321', 'shop_user');
	$db->connect();
    
    
    // Reviews REST service, Motiejus
    if(isset($_GET['json']) && $_GET['json'] == '1'){
        
        if(isset($_GET['page']) && $_GET['page']=='review' && isset($_GET['pid']) && is_numeric($_GET['pid'])){
            
            $review = $db->select('reviews', '*', 'product='.$_GET['pid']);
            $review = $db->getResult();
            
            Lib\renderContentFile("review.get.php", array('review' => $review));
            
        }
        
        if(isset($_POST['review']) && is_numeric($_POST['id'])){
            
            //add review to the db
            
        }
        
        exit();
    }
    
    
    // Product page. Test
    if(isset($_GET['page']) && $_GET['page']=='product' && isset($_GET['id']) && is_numeric($_GET['id'])){
        
        $product = $db->select('products', '*', 'id='.$_GET['id']);
        $product = $db->getResult();
        Lib\renderLayoutWithContentFile('product.php', array('product'=>$product));
        exit();
        
    }
    
    Lib\renderLayoutWithContentFile("home.php");

?>