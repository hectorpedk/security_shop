<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Dimul
	 * Date: 23/05/13
	 * Time: 14:07
	 * To change this template use File | Settings | File Templates.
	 */

	namespace Resources\Classes;

	class Members
	{

		private $id , $role_id , $name , $lastname , $email ,
				$phone , $login , $password , $salt;

		/** @var  Database $_db */
		private $_db;

		function __construct ( $id = 0 )
		{

		}

		# SETTERS

		public function setDb ( Database $db )
		{
			$this->_db = $db;
//			var_dump( $db );
		}

		public function setName ( $name )
		{
			$this->name = $name;
		}

		public function setLastname ( $lastname )
		{
			$this->lastname = $lastname;
		}

		public function setEmail ( $email )
		{
			$this->email = $email;
		}

		public function setPhone ( $phone )
		{
			$this->phone = $phone;
		}

		public function setLogin ( $login )
		{
			$this->login = $login;
		}

		public function setPassword ( $password )
		{
			$this->password = $password;
		}

		public function setSalt ( $salt )
		{
			$this->salt = $salt;
		}

		# GETTERS

		public function getId ()
		{
			return $this->id;
		}

		public function getRoleId ()
		{
			return $this->role_id;
		}

		public function getName ()
		{
			return $this->name;
		}

		public function getLastname ()
		{
			return $this->lastname;
		}

		public function getEmail ()
		{
			return $this->email;
		}

		public function getPhone ()
		{
			return $this->phone;
		}

		public function getLogin ()
		{
			return $this->login;
		}

		public function getPassword ()
		{
			return $this->password;
		}

		public function getSalt ()
		{
			return $this->salt;
		}

		public function getAll () {

			$this->_db->select('products');
			$result = $this->_db->getResult();

			var_dump( $result );
		}


	}