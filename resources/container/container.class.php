<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dimul, Aleksandra Mishevska, Motiejus Bagdonas, Hector Huaman
 * Date: 27/05/13
 * Time: 16:38
 * To change this template use File | Settings | File Templates.
 */

namespace Resources\DI;


use Resources\Classes\Database;
use Resources\Classes\Members;

class Container {

	public static $_database;

	function __construct ()
	{
		require_once( '/../classes/database.class.php' );
		self::$_database = new Database('localhost' , 'security_shop', '123456789','shop_admin' );

	}

	public static function makeMember () {




	}




}