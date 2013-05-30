<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dimul
 * Date: 23/05/13
 * Time: 14:08
 * To change this template use File | Settings | File Templates.
 */

namespace Resources\Classes;


class Products {
	private $id , $name , $description , $stock , $price;
	/** @var  Database $_db */
	private $_db;

	public function setDb ( $db ) {
		$this->_db = $db;
	}

	public function getId () {
		return $this->id;
	}

	public function setName ( $name ) {
		$this->name = $name;
	}

	public function setDescription ( $description ) {
		$this->description = $description;
	}

	public function setPrice ( $price ) {
		$this->price = $price;
	}

	public function getName () {
		return $this->name;
	}

	public function getDescription () {
		return $this->description;
	}

	public function getStock () {
		return $this->stock;
	}

	public function getPrice () {
		return $this->price;
	}


}