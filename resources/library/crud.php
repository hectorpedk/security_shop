<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dimul, Aleksandra Mishevska, Motiejus Bagdonas, Hector Huaman
 * Date: 31/05/13
 * Time: 18:56
 * To change this template use File | Settings | File Templates.
 */

namespace Resources\Library;
use PDO;

class CRUD {

	/** @var PDO $pdo */
	/* TODO:Have to be injected */
	private $pdo;
	private $result = array();

	/**
	 * Selects information from the database.
	 * Required: table      ( the name of the table )
	 * Optional: columns    ( the columns requested, separated by commas )
	 *           where      ( column = value as a string )
	 *           order      ( column DIRECTION as a string )
	 *
	 * @param string   $table      Table name to select from database                               | required parameter
	 * @param string   $columns    Column names to selet from table provided in $table parameter    | default *
	 * @param string   $where      WHERE clause for sql statement                                   | default null
	 * @param string   $order      ORDER BY clause fro sql statement                                | default null
	 *
	 * @return bool|\PDOException     Function returns true if execution of SQL statement was successful and false otherwise ( throws PDO exception $e )
	 */
	public function setPdo ( PDO $pdo ){
		$this->pdo = $pdo;
	}

	public function select( $table , $columns = '*' , $where = null , $order = null )
	{	/** @var $select */
		$select = 'SELECT ' . $columns . ' FROM ' . $table;

		if( $where != null )
			$select .= ' WHERE ' . $where;
		if( $order != null )
			$select .= ' ORDER BY ' . $order;

		try {
			/** @var \PDOStatement $stmt Holds a prepared statement for PDO object to handle */
//			var_dump( $select );
			$stmt = $this->pdo->prepare( $select );
			$stmt->execute();

			# Iteration through all rows that were return from the table
			for ( $i = 0 ; $i < $stmt->rowCount(); $i++ ) {

				# Associative array of rows from table
				# $rows - where array_index is row number, array_key is column name, array_key_value is column name value

				/** @var array $rows Holds arrays of associative arrays of row data */
				$rows = $stmt->fetch( PDO::FETCH_ASSOC );

				/** @var array $key  Holds all column names for each row in $rows variable*/
				$keys = array_keys( $rows );

				# Iterate through all the keys inside each row ( $rows variable )
				for ( $x = 0; $x < count( $keys ) ; $x++ ) {

					# Sanitize keys to allow only alphanumeric values of column names
					if ( !is_int( $keys[$x] ) ){

						# Handle conditions when there is more than one row, less than one or none and only one
						if ( $stmt->rowCount() > 1 ) {

							$this->result[ $i ][ $keys[$x] ] = $rows[ $keys[$x] ];

						} elseif ( $stmt->rowCount() < 1 ) {

							$this->result = null;

						} else {

							$this->result[ $keys[$x] ] = $rows[ $keys[$x] ];

						}

					}

				}

			}
			return true;

		} catch ( \PDOException $e ){
			echo 'Something is wrong in select(): ' . $e->errorInfo[2];
			return false;
		}

	}

	/**
	 * Insert values into the table
	 *
	 * Required: table      (the name of the table)
	 *           values     (the values to be inserted)
	 * Optional: columns    (if values don't match the number of rows)
	 *
	 * @param string    $table      Table name to insert into						| required parameter
	 * @param array     $values     indexed Array of values to insert into table			| required patameter
	 * @param array     $columns    Array of columns into which to insert values	| default null
	 *
	 * @return bool|PDOException
	 */
	public function insert( $table , $values , $columns = null )
	{
		if( $this->tableExists( $table ) )
		{
			$insert = 'INSERT INTO ' . $table;

			if( $columns != null ) {

				for ( $x = 0 ; $x < count( $columns ) ; $x++ ){

					/* Statement below is the same as
						if( is_string( $columns[$x] ) )
							$columns[$x] = $columns[$x];
					*/
					is_string( $columns[$x] ) ? $columns[$x] = $columns[$x] : null;

				}

				$columns = implode( ',' , $columns );
				$insert .= ' (' . $columns . ')';

			}

			for( $i = 0 ; $i < count( $values ) ; $i++ ) {

				if( is_string( $values[$i] ) )
					$values[$i] = '"' . $values[$i] . '"';

			}

			$valuesString = implode( ',' , $values );
			$insert .= ' VALUES (' . $valuesString . ')';

			try {
				/** @var \PDOStatement $stmt Holds a prepared statement for PDO object to handle */
				$stmt = $this->pdo->prepare( $insert );
				$stmt->execute();
				return true;

			} catch ( \PDOException $e ){
				echo "Something is wrong in insert(): " . $e->errorInfo[2];
				return false;
			}
		}
	}

	/**
	 * Deletes table or records where condition is true
	 * Required: table ( the name of the table to delete )
	 * Optional: where ( condition [column name = value] )
	 *
	 * @param string	$table	"Table name from which to delete" - or if $where is not provided - "table to delete" | required parameter
	 * @param array		$where	Associative array of conditions array_key ( column name to match ) => array_key_value( value to match )
	 *
	 * @return bool
	 */

	public function del( $table , $where = null )
	{
		if ( $this->tableExists( $table ) ) {

			$delete = 'DELETE FROM ' . $table;

			if ( $where != null ) {

				$conditions = array();
				$keys = array_keys( $where );
				for ( $i = 0 ; $i < count( $keys ) ; $i++ ) {

					$checkString = is_string( $where[ $keys[$i] ] ) ? '\'' . $where[ $keys[$i] ] . '\'' : $where[ $keys[$i] ];
					$conditions[$i] = $keys[$i] . ' = ' . $checkString;

				}
				$conditionsString = implode( ' AND ' , $conditions );
				$delete .= ' WHERE ' . $conditionsString;

			}

			try {

				/** @var \PDOStatement $stmt Holds a prepared statement for PDO object to handle */
				$stmt = $this->pdo->prepare( $delete );
				$stmt->execute();
				return true;

			} catch (\PDOException $e) {
				echo 'Something is wrong in remove(): ' . $e->getMessage();
				return false;
			};

		} else {
			return false;
		}
	}

	/**
	 * Updates the database with the values provided
	 *
	 * Required: table		( the name of the table to be updated )
	 *           columns	( the column/value in a key/value array )
	 *           where		( the column/condition in an array ( column , condition ) )
	 *
	 * @param string	$table		Table name in which values have to be updated
	 * @param array		$columns	Associative array of $key => $value pairs,
	 *								where $key is column_name and $value is column_value to update;
	 * @param array		$where		Associative array of $key => $value pairs,
	 * 								where $key is column_name and $value is column_value to match condition;
	 *
	 * @return bool|\PDOException	Function returns true if everything was successful,
	 *								Returns false if something was wrong during PDOstatement execution, throws \PDOException,
	 *								Returns false if provided $table is not present in the database;
	 */

	public function update ( $table , array $columns , array $where )
	{
		if ( $this->tableExists( $table ) ) {

			/** @var string $update SQL update string for database execution */
			$update = 'UPDATE ' . $table . ' SET ';

			/**
			 *	Below starts a Codeblock for handling $columns array;
			 *	Code creates SET parameters (column_name = column_value) and appends to SQL $update string;
			 *
			 * @var array $columnsToSet	Indexed array of SET parameters for SQL update statement
			 * 							like 'column_name = column_value';
			 */
			$columnsToSet = array ();

			/** @var array $keys Indexed array of column names to update */
			$keys   = array_keys( $columns );

			/* Iterate through all columns provided with function call */
			for ( $i = 0 ; $i < count( $keys ) ; $i++ ) {

				/**
				 * $checkSetString is if statement shorthand with ternary operator
				 * Checks values of the keys in $columns array
				 * In other words, check if column_value is a string - needed for correct SQL syntax
				 *
				 * @var string $checkSetString String of one SET parameter
				 */
				$checkSetString = (is_string( $columns[ $keys[$i] ] ) ? '\'' . $columns[ $keys[$i] ] . '\'' : $columns[ $keys[$i] ]);

				/* Populate array $columnsToSet with SET parameter */
				$columnsToSet[$i] = $keys[$i] . ' = ' . $checkSetString;

			}

			/**
			 * $setString is if shorthand that checks for amount of SET parameters,
			 * if there is more than one then they will be separated by comma ",",
			 * if there is other condition then no separation will be added
			 *
			 * @var string $setString  String of ALL SET parameters
			 */
			$setString = ( count( $columns ) > 1 ?
				implode( ' , ' , $columnsToSet ) : implode( "" , $columnsToSet ) );

			/* Append ALL SET parameter to SQL $update string */
			$update .= $setString;

			/* End of Codeblock for handling $columns array */

			/**
			 * Below starts a Codeblock for handling $where array;
			 * Code creates WHERE clause (condition_name = condition_value) and appends to SQL $update string;
			 *
			 * @var array $whereConditions	Indexed array of WHERE conditions for SQL update statement
			 * 								like 'condition_name = condition_value';
			 */
			$whereConditions = array();

			/** @var array $keys Indexed array of condition_names */
			$keys = array_keys( $where );
			/* Iterate through all condition provided with function call */
			for ( $i = 0 ; $i < count( $keys ) ; $i++ ) {


				/**
				 * $checkWhereString is if statement shorthand with ternary operator
				 * Checks values of the keys in $where array
				 * In other words, check if condition_value is a string - needed for correct SQL syntax
				 *
				 * @var string $checkSetString String of one SET parameter
				 */
				$checkWhereString = is_string( $where[ $keys[$i] ] ) ? '\'' . $where[ $keys[$i] ] . '\'' : $where[ $keys[$i] ];
				/* Populate array $whereConditions with WHERE conditions */
				$whereConditions[$i] = $keys[$i] . ' = ' . $checkWhereString;
			}
			/**
			 * $whereString is if shorthand that checks for amount of WHERE conditions,
			 * if there is more than one then they will be separated by sql's and "AND",
			 * if there is other condition then no separation will be added
			 *
			 * @var string $whereString  String of ALL SET parameters
			 */
			$whereString = ( count( $where ) > 1 ?
				implode( ' AND ' , $whereConditions ) : implode( "" , $whereConditions ) );

			/* Append ALL SET parameter to SQL $update string */
			$update .= ' WHERE ' . $whereString;

			/* End of Codeblock for handling $where array */

			/* Execute the query within try catch statement and catch errors from PDOstatement into $e variable */
			try {
				$stmt = $this->pdo->prepare( $update );
				$stmt->execute();
				return true;
			} catch ( \PDOException $e ) {
				echo "Something is wrong in update(): " . $e->getMessage();
				return false;
			};

		} else {
			return false;
		}
	}


	/**
	 * Checks to see if the table exists when performing queries
	 *
	 * @param $table    Table name to chekc in database
	 *
	 * @return bool|\PDOException     Function returns true if execution of SQL statement was successful and false otherwise ( throws PDO exception $e )
	 */
	private function tableExists ( $table )
	{
		try{
			/** @var \PDOStatement $stmt Holds a prepared statement for PDO object to handle */
			$stmt = $this->pdo->prepare( 'SHOW TABLES FROM ' . $this->db_name . ' LIKE "' . $table . '"' );
			$stmt->execute();
			$stmt->setFetchMode( PDO::FETCH_ASSOC );

			while ( $rows = $stmt->fetch() ){

				return ($stmt->rowCount() == 1 ? true : false);

			}
		} catch ( \PDOException $e ){
			echo 'Something is wrong in tableExists(): ' . $e->errorInfo[2];
			return false;
		}

	}
	/*
	* Returns the result set
	*/
	public function getResult()
	{
		return $this->result;
	}

	public function clearResult()
	{
		$this->result = null;
	}


}