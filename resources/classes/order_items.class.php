<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Dimul
	 * Date: 23/05/13
	 * Time: 14:14
	 * To change this template use File | Settings | File Templates.
	 */

	namespace Resources\Classes;


	class Order_items
	{

		private $id , $order_id , $product_id , $quantity;
		/** @var  Database $_db */
		private $_db;

		public function setDb ( $db ) {
			$this->_db = $db;
		}

		public function getId () {
			return $this->id;
		}

		public function setQuantity ( $quantity ) {
			$this->quantity = $quantity;
		}

		public function setOrderId ( $order_id ) {
			$this->order_id = $order_id;
		}

		public function setProductId ( $product_id ) {
			$this->product_id = $product_id;
		}

		public function getQuantity () {
			return $this->quantity;
		}

		public function getOrderId () {
			return $this->order_id;
		}

		public function getProductId () {
			return $this->product_id;
		}

	}