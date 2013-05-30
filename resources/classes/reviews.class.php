<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dimul, Aleksandra Mishevska, Motiejus Bagdonas, Hector Huaman
 * Date: 30/05/13
 * Time: 06:50
 * To change this template use File | Settings | File Templates.
 */

namespace Resources\Classes;


class Reviews {
	private $id, $member_id, $product_id, $title, $body;
	/** @var  Database $_db */
	private $_db;

	public function setDb ( $db ) {
		$this->_db = $db;
	}

	public function setTitle ( $title ) {
		$this->title = $title;
	}

	public function setBody ( $body ) {
		$this->body = $body;
	}

	public function getId () {
		return $this->id;
	}

	public function getMemberId () {
		return $this->member_id;
	}

	public function getProductId () {
		return $this->product_id;
	}

	public function getTitle () {
		return $this->title;
	}

	public function getBody () {
		return $this->body;
	}




}