<?php
namespace Resources\Classes;

use PDO;
/*
 * Description: Contains database connection, result
 *              Management functions, input validation
 *
 *              All functions return true if completed
 *              successfully and false if an error
 *              occurred
 *
 */
class Database
{

    /*
     * Database configuration
     */
    private static $db_host;     // Database Host
    private static $db_name;          // Database
    private static $db_user;          // Username
    private static $db_pass;          // Password

    /**
     * @var PDO pdo Holds PDO object after successful connection to the database;
     */

    private static $pdo;


	public static function getInstance ( array $db_config = null)
	{
		if ( is_array( $db_config ) && $db_config != null ) {

			$allowed_variables = get_class_vars(__CLASS__);

			$keys = array_keys( $db_config );

			for ( $i = 0 ; $i < count( $db_config ) ; $i++ ) {

				switch ( $keys[$i] ) {

					case $keys[$i]:
						$validate = array_key_exists( $keys[$i] , $allowed_variables );
						if($validate){
							self::${$keys[$i]} = $db_config [ $keys[$i] ];
							break;
						}
					default:
						echo $keys[$i] . ' from config.php is not a valid parameter ';
						break;
				}
			}

			if( !self::$pdo ) {
				try {
					# Data Source Name for PDO connection;
					$dsn = 'mysql:host=' . self::$db_host . ';dbname=' . self::$db_name;
					# Connection to the database happens here;
					self::$pdo = new PDO( $dsn , self::$db_user , self::$db_pass );
					# Setts PDO error reporting to throw exceptions;
					self::$pdo->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
					# Setts private var $link to true indicating that connection was created;
					return self::$pdo;

				} catch ( \PDOException $e ) {
					# If exception was thrown store into variable $e and echo it out;
					echo 'Error with connection in connect(): ' . $e->getMessage();
					return false;
				}

			} else {
				return self::$pdo;
			}

		} else {
			return false;
		}
	}

//	public static function getInstance ( ) {
//		if( self::$pdo ){
//			return self::$pdo;
//		}
//	}

    /*
     * Connects to the database
     * Only one connection allowed
     */
//    public function connect()
//    {
//        if( !$this->pdo ) {
//            try {
//                # Data Source Name for PDO connection;
//                $dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
//                # Connection to the database happens here;
//                $this->pdo = new PDO( $dsn , $this->db_user , $this->db_pass );
//                # Setts PDO error reporting to throw exceptions;
//                $this->pdo->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
//                # Setts private var $link to true indicating that connection was created;
//                return true;
//
//            } catch ( \PDOException $e ) {
//                # If exception was thrown store into variable $e and echo it out;
//                echo 'Error with connection in connect(): ' . $e->getMessage();
//                return false;
//            }
//
//        } else {
//            return false;
//        }
//    }

    /**
     * Changes the new database, sets all current results to null
     *
     * @param $name     Name of the databse to change to
     *
     * @return bool     Returns true if condition is met
     */
//    public function setDatabase( $name )
//    {
//            if( $this->pdo ) {
//                $this->pdo = null;
//                $this->db_name = $name;
//                $this->connect();
//                return true;
//            }
//    }
//
//
//
//
//
//	public function getPdo () {
//		return $this->pdo;
//	}
//}
}