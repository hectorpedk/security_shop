<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Dimul
	 * Date: 23/05/13
	 * Time: 14:07
	 * To change this template use File | Settings | File Templates.
	 */

	namespace Resources\Classes;

	use Resources\Library as Lib;

	class Members
	{
		/* Variables correspond to column names in database */
		private $id , $role_id , $name , $lastname , $email ,
				$phone , $login , $password , $salt;

		/* Dependencies below are injected through container.class.php */

		/** @var \PDO $_db */
		private $_db;

		/** @var Lib\CRUD $_db */
		private $_crud;

		/** @var  Hashing $_hashing */
		private $_hashing;

		function __construct ( $id = 0 , Lib\CRUD $crud = null) {

			if( $id > 0 ) {
				if ( $crud instanceof Lib\CRUD ){

					$where = 'id = \'' . $id . '\'';
					$columns = ' id , role_id , name , lastname, email, phone, login , password , salt';
					$crud->select( 'members' , $columns, $where );

					$row = $crud->getResult();
					$crud->clearResult();

					$this->id			= $row[ 'id' ];
					$this->role_id		= $row[ 'role_id' ];
					$this->name 		= $row[ 'name' ];
					$this->lastname 	= $row[ 'lastname' ];
					$this->email 		= $row[ 'email' ];
					$this->phone 		= $row[ 'phone' ];
					$this->login 		= $row[ 'login' ];
					$this->password 	= $row[ 'password' ];
					$this->salt 		= $row[ 'salt' ];

					$this->_crud		= $crud;
				}
			}



		}

		/* End dependencies */




		# SETTERS

		/* Dependencies setters */
		public function setDb ( \PDO $db ){
			$this->_db = $db;
		}

		public function setCRUD ( Lib\CRUD $db ) {
			$this->_crud = $db;
		}

		public function setHashing ( Lib\Hashing $hashing_class){
			$this->_hashing = $hashing_class;
		}

		/* End dependencies setter */

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

		public function login ( $username , $password ){

			if ( self::validateUser($username) ) {

				$where = 'login = \'' . $username . '\'';
				$columns = ' id , role_id , name , lastname, email, phone, login , password , salt';
				$this->_crud->select( 'members' , $columns, $where );

				$row = $this->_crud->getResult();
				$this->_crud->clearResult();

				if ( $row !== null ){

					$validatePassword = $this->_hashing->validate_password($password, $row['password']);

					if ( $validatePassword ) {

						/* If $username and $password validations passed,
							values will be assigned to private properties of this class */
						$this->id			= $row[ 'id' ];
						$this->name 		= $row[ 'name' ];
						$this->lastname 	= $row[ 'lastname' ];
						$this->email 		= $row[ 'email' ];
						$this->phone 		= $row[ 'phone' ];
						$this->login 		= $row[ 'login' ];
						$this->password 	= $row[ 'password' ];
						$this->salt 		= $row[ 'salt' ];

						# If everything is correct, login function will return true only from here
						return true;
					} else {

						# If password is incorrect, login() will return false from here;
						return false;
					}
				}
			}
			# If $username does not exist in Database, login() will return false from here;
			return false;


		}

		private function validateUser ( $username ) {

			$where = 'login = \'' . $username . '\'';
			$columns = 'login ';
			$this->_crud->select( 'members' , $columns, $where );
			$this->_crud->getResult();

			$result = $this->_crud->getResult();
			$this->_crud->clearResult();
			return ( $result ? true : false );

		}



	}