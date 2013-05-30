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


	class Container
	{

		private static $_database;

		public static function makeMember () {
			$member = new Cls\Members();
			$member->setDb( self::$_database );

			return $member;
		}

		public static function makeOrderItem () {
			$order_items = new Cls\Order_items();
			$order_items->setDb( self::$_database );

			return $order_items;
		}

		public static function makeOrder () {
			$order = new Cls\Order_items();
			$order->setDb( self::$_database );

			return $order;
		}

		public static function makeProduct () {
			$product = new Cls\Products();
			$product->setDb( setDb( self::$_database ) );

			return $product;
		}

		public static function makeRole () {
			$role = new Cls\Roles();
			$role->setDb( setDb( self::$_database ) );

			return $role;
		}

		public static function makeReview (){
			$review = new Cls\Reviews();
			$review->setDb( setDb( self::$_database ) );

			return $role;
		}

		public static function DB ( array $db_config ) {
			static::$_database = new Cls\Database( (array) $db_config );
		}

	}

	spl_autoload_register( function ( $class ) {
		require_once realpath( dirname( __FILE__ ) . '/../classes/' . strtolower( basename( $class ) ) . '.class.php' );
	} );









