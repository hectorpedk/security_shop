<?php
    use Resources\Library as Lib;
    use Resources\Classes as Cls;
	use Resources\DI\Container;

	require_once realpath(dirname(__FILE__) . '/../resources/config.php');
	require_once LIBRARY_PATH . '/templateFunctions.php';
    require_once CONTAINER_PATH;
    
    /*
     *  Let's have it available globally
     * */
    global $db;
    $db = Container::DB( $db_config );
    
    
    /*
     * Login form postback
     */
    if(isset( $_POST[ 'login_form' ] )){
        
        $username = (isset( $_POST[ 'username' ] ) && !empty($_POST[ 'username' ])) ? strip_tags($_POST[ 'username' ]) : null;
        $password = (isset( $_POST[ 'password' ] ) && !empty($_POST[ 'password' ])) ? strip_tags($_POST[ 'password' ]) : null;
        
        if ( filter_var($username, FILTER_SANITIZE_STRING) && filter_var($password, FILTER_SANITIZE_STRING) ) {
            $member = Container::makeMember( $db_config );
            if ( $member->login( $username , $password ) ) {
                session_start();
                $_SESSION[ 'username' ] = $member->getLogin();
            }else{
                echo "User with credentials provided does not exist!";    
            }
        } else {
            echo "Please provide username and password.";
        }
        
    }

	
	/*
     *  Reviews short REST service.
     */
	if(isset($_GET['json']) && $_GET['json'] == '1'){

        if(isset($_GET['page']) && $_GET['page']=='review' && isset($_GET['pid']) && is_numeric($_GET['pid'])){
            
            /*
             * Review submit form postback
             */
            
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                
                if($user = Container::auth($db_config)){
                    
                    $title = (isset( $_POST[ 'title' ] ) && !empty($_POST[ 'title' ])) ? strip_tags($_POST[ 'title' ]) : null;
                    $body = (isset( $_POST[ 'body' ] ) && !empty($_POST[ 'body' ])) ? strip_tags($_POST[ 'body' ]) : null;
                    
                    if($title && $body){
                        $review = array();
                        $review['id'] = 0;
                        $review['member_id'] = $user['id'];
                        $review['product_id'] = $_GET['pid'];
                        $review['title'] = $title;
                        $review['body'] = $body;
                        $db->insert('reviews', array_values($review));
                        header('Content-Type: application/json');
                        echo json_encode($review);
                        exit();
                    }else{
                        header('HTTP/1.1 400 Bad Request');
                        exit();
                    }
                    
                }else{
                    
                    header('HTTP/1.1 401 Unauthorized');
                    exit();
                    
                }
            
            }
        
            
            /*
             * Get reviews for the current product
             */
            
            $db->select('reviews', '*', 'product_id='.$_GET['pid']);
            $reviews = $db->getResult();
    		$db->clearResult();
            $temp = array();            
            
            if(array_keys($reviews) !== range(0, count($reviews) - 1)){
                $review = $reviews;
                $db->select('members', '*', 'id='.$review['member_id']);
                $author = $db->getResult();
                $review['author_name'] = $author['name'];
                $review['author_lastname'] = $author['lastname'];
                $review['author_email'] = $author['email'];
                array_push($temp, $review);
            }else{
                foreach ($reviews as $review){
                    $db->select('members', '*', 'id='.$review['member_id']);
                    $author = $db->getResult();
                    $review['author_name'] = $author['name'];
                    $review['author_lastname'] = $author['lastname'];
                    $review['author_email'] = $author['email'];
                    array_push($temp, $review);
                }
            }
            
            $reviews = $temp;
            $temp = null;
            Lib\renderContentFile("review.get.php", array('review' => $reviews));
            
        }
        
        exit();
    }
    
    
    /*
     * Products page + Auth check
     */
    if(isset($_GET['page']) && $_GET['page']=='products'){
        
        $products = $db->select('products', '*');
        $products = $db->getResult();
        $db->clearResult();
        
        if($user = Container::auth($db_config)){
            Lib\renderLayoutWithContentFile('products.php', array('products'=>$products, 'user'=>$user));
            exit();
        }else{
            Lib\renderLayoutWithContentFile('products.php', array('products'=>$products, 'user'=>null));
            exit();
        }
        
    }
    
    
    /*
     * Product page + Auth check
     */
    if(isset($_GET['page']) && $_GET['page']=='product' && isset($_GET['id']) && is_numeric($_GET['id'])){
        
        $product = $db->select('products', '*', 'id='.$_GET['id']);
        $product = $db->getResult();
        
        if($user = Container::auth($db_config)){
            Lib\renderLayoutWithContentFile('product.php', array('product'=>$product, 'user'=>$user));
            exit();
        }else{
            Lib\renderLayoutWithContentFile('product.php', array('product'=>$product, 'user'=>null));
            exit();
        }
        
    }
    
    
    /*
     * Home page. Pass user obj if auth = true, else if anonymous = null 
     */
    if($user = Container::auth($db_config)){
        Lib\renderLayoutWithContentFile("home.php", array("user"=>$user));
    }else{
        Lib\renderLayoutWithContentFile("home.php", array("user"=>null));
    }
    
    
    /*
     * Logout. Should be always at the bottom to avoid sesstion resetting.
     */
    if(isset($_GET['logout']) && $_GET['logout'] == 'true'){
        session_unset();
        session_destroy();
        header( 'Location: /' ) ;
    }    

?>