<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Dimul, Aleksandra Mishevska, Motiejus Bagdonas, Hector Huaman
	 * Date: 27/05/13
	 * Time: 16:38
	 * To change this template use File | Settings | File Templates.
	 */
	namespace Resources\DI;

	use Resources\Classes as Cls;
	use Resources\Library as Lib;


	class Container
	{

		private static $_database;

		public static function makeMember ( $db_config ) {

			$member = new Cls\Members();
			$member->setDb( self::DB( $db_config ) );
			$member->setHashing( self::Hashing() );
			$member->setCRUD( self::CRUD( $db_config ) );

			return $member;
		}

		public static function makeMemberLogin ( $member_id , $db_config ) {
			$member = new Cls\Members( $member_id , self::CRUD( $db_config ) );
			$member->setDb( self::DB( $db_config ) );
			$member->setHashing( self::Hashing() );
			$member->setCRUD( self::CRUD( $db_config ) );

			return $member;
		}

		public static function makeOrderItem () {
			$order_items = new Cls\Order_items();
			$order_items->setDb( self::$_database );

			return $order_items;
		}

		public static function makeOrder () {
			$order = new Cls\Orders();
			$order->setDb( self::$_database );

			return $order;
		}

		public static function makeProduct () {
			$product = new Cls\Products();
			$product->setDb( self::$_database );

			return $product;
		}

		public static function makeRole () {
			$role = new Cls\Roles();
			$role->setDb( self::$_database );

			return $role;
		}

		public static function makeReview (){
			$review = new Cls\Reviews();
			$review->setDb( self::$_database );

			return $review;
		}

		public static function DB ( array $db_config ) {
			static::$_database = Cls\Database::getInstance( $db_config );

			return static::$_database;
		}

		private static function CRUD ( array $db_config ) {
			$crud =  new Lib\CRUD();
			$crud->setPdo( self::DB( $db_config ) );
			return $crud;
		}

		public static function Hashing () {
			return new Lib\Hashing();
		}

	}

	spl_autoload_register( function ( $class ) {

		$cls = realpath( dirname( __FILE__ ) . '/../classes/' . strtolower( basename( $class ) ) . '.class.php' );
		$lib =  realpath( dirname( __FILE__ ) . '/../library/' . strtolower( basename( $class ) ) . '.php' );

		require_once $cls ? $cls : $lib;

	} );









