<?php
    use Resources\Library as Lib;
    use Resources\Classes as Cls;
	use Resources\DI\Container;

	require_once realpath(dirname(__FILE__) . '/../resources/config.php');
	require_once LIBRARY_PATH . '/templateFunctions.php';
    require_once CONTAINER_PATH;


//	$review = Container::makeReview();
//
//	var_dump( $review );
//    exit();


//	$db = Container::DB( $db_config );



//	// Reviews REST service, Motiejus
//	if(isset($_GET['json']) && $_GET['json'] == '1'){
//
//        if(isset($_GET['page']) && $_GET['page']=='review' && isset($_GET['pid']) && is_numeric($_GET['pid'])){
//
//
//            $db = new Cls\Database( (array) $db_config );
//
//           	$db->select('reviews', '*', 'product_id='.$_GET['pid']);
//
//            if($_SERVER['REQUEST_METHOD'] === 'POST'){
//
//                $title = $_POST['title'];
//                print_r($_POST);
//                exit();
//
//            }
//
//            //$db = new Cls\Database( (array) $db_config );
//            $db->select('reviews', '*', 'product_id='.$_GET['pid']);
//
//            $reviews = $db->getResult();
//    		$db->clearResult();
//            $temp = array();
//
//            foreach ($reviews as $review){
//                $db->select('members', '*', 'id='.$review['member_id']);
//                $author = $db->getResult();
//                $review['author_name'] = $author['name'];
//                $review['author_lastname'] = $author['lastname'];
//                $review['author_email'] = $author['email'];
//                array_push($temp, $review);
//            }
//
//            $reviews = $temp;
//            $temp = null;
//            Lib\renderContentFile("review.get.php", array('review' => $reviews));
//
//        }
//
//        exit();
//    }
//
//    // Product page. Test
//    if(isset($_GET['page']) && $_GET['page']=='product' && isset($_GET['id']) && is_numeric($_GET['id'])){
//
//        $db = new Cls\Database( (array) $db_config );
//        $product = $db->select('products', '*', 'id='.$_GET['id']);
//        $product = $db->getResult();
//        Lib\renderLayoutWithContentFile('product.php', array('product'=>$product));
//        exit();
//
//    }

    
//    Lib\renderLayoutWithContentFile("home.php");

?>