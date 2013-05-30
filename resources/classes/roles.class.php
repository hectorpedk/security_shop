<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dimul
 * Date: 23/05/13
 * Time: 13:58
 * To change this template use File | Settings | File Templates.
 */

namespace Resources\Classes;


class Roles {
	private $id , $name;
	/** @var  Database $_db */
	private $_db;

	public function setDb ( $db ) {
		$this->_db = $db;
	}

	public function setName ( $name ) {
		$this->name = $name;
	}

	public function getId () {
		return $this->id;
	}

	public function getName () {
		return $this->name;
	}


}