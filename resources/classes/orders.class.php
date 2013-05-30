<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dimul
 * Date: 23/05/13
 * Time: 14:09
 * To change this template use File | Settings | File Templates.
 */

namespace Resources\Classes;


class Orders {

	private $order_id , $member_id , $datetime;
	/** @var  Database $_db */
	private $_db;


	public function setDb ( $db ) {
		$this->_db = $db;
	}

	public function setMemberId ( $member_id ) {
		$this->member_id = $member_id;
	}

	public function setDatetime ( $datetime ) {
		$this->datetime = $datetime;
	}

	public function getOrderId () {
		return $this->order_id;
	}

	public function getMemberId () {
		return $this->member_id;
	}

	public function getDatetime () {
		return $this->datetime;
	}


}