<?php
namespace Resources\Classes;

use PDO;
/*
 * Description: Contains database connection, result
 *              Management functions, input validation
 *
 *              All functions return true if completed
 *              successfully and false if an error
 *              occurred
 *
 */
class Database
{

    /*
     * Database configuration
     */
    private $db_host;     // Database Host
    private $db_name;          // Database
    private $db_user;          // Username
    private $db_pass;          // Password
    /*
     * End edit
     */

    /**
     * @var PDO pdo Holds PDO object after successful connection to the database;
     */
    private $pdo;              // Checks to see if the connection is active
    private $result = array(); // Results that are returned from the query

    /*
     * Connects to the database
     * Only one connection allowed
     */
    public function connect()
    {
        if( !$this->pdo ) {
            try {
                # Data Source Name for PDO connection;
                $dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
                # Connection to the database happens here;
                $this->pdo = new PDO( $dsn , $this->db_user , $this->db_pass );
                # Setts PDO error reporting to throw exceptions;
                $this->pdo->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
                # Setts private var $link to true indicating that connection was created;
                return true;

            } catch ( \PDOException $e ) {
                # If exception was thrown store into variable $e and echo it out;
                echo 'ERROR IN CONNECTION: ' . $e->getMessage();
                return false;
            }

        } else {
            return false;
        }
    }

    /**
     * Changes the new database, sets all current results to null
     *
     * @param $name     Name of the databse to change to
     *
     * @return bool     Returns true if condition is met
     */
    public function setDatabase( $name )
    {
            if( $this->pdo ) {
                $this->pdo = null;
                $this->db_name = $name;
                $this->connect();
                return true;
            }
    }

    /**
     * Checks to see if the table exists when performing queries
     *
     * @param $table    Table name to chekc in database
     *
     * @return bool|PDOException     Function returns true if execution of SQL statement was successful and false otherwise ( throws PDO exception $e )
     */
    private function tableExists ( $table )
    {
        try{

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
     * @return bool|PDOException     Function returns true if execution of SQL statement was successful and false otherwise ( throws PDO exception $e )
     */
    public function select( $table , $columns = '*' , $where = null , $order = null )
    {
        $sql = 'SELECT ' . $columns . ' FROM ' . $table;

        if( $where != null )
            $sql .= ' WHERE ' . $where;
        if( $order != null )
            $sql .= ' ORDER BY ' . $order;

        try {
            /** @var PDOStatement $stmt Holds a prepared statement for PDO object to handle */
            $stmt = $this->pdo->prepare( $sql );
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

                        } elseif ( $stmt->rowCount < 1 ) {

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
     * @param string    $table      Table name to insert into
     * @param array     $values     Array of values to insert into table
     * @param array     $columns    Array of columns into which to insert values
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

            $values = implode( ',' , $values );
            $insert .= ' VALUES (' . $values . ')';

            try {
                /** @var PDOStatement $stmt Holds a prepared statement for PDO object to handle */
                $stmt = $this->pdo->prepare( $insert );
                $stmt->execute();
                return true;

            } catch ( \PDOException $e ){
                echo "Something is wrong in insert(): " . $e->errorInfo[2];
                return false;
            }
        }
    }

    /*
    * Deletes table or records where condition is true
    * Required: table (the name of the table)
    * Optional: where (condition [column =  value])
    */
    // TODO: Finish delete, update with PDO class
    public function delete($table,$where = null)
    {
        if($this->tableExists($table))
        {
            if($where == null)
            {
                $delete = 'DELETE '.$table;
            }
            else
            {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }
            $del = @mysql_query($delete);

            if($del)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /*
     * Updates the database with the values sent
     * Required: table (the name of the table to be updated
     *           rows (the rows/values in a key/value array
     *           where (the row/condition in an array (row,condition) )
     */
    public function update($table,$rows,$where)
    {
        if($this->tableExists($table)) {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for($i = 0; $i < count($where); $i++) {
                if($i%2 != 0)
                {
                    if(is_string($where[$i]))
                    {
                        if(($i+1) != null)
                            $where[$i] = '"'.$where[$i].'" AND ';
                        else
                            $where[$i] = '"'.$where[$i].'"';
                    }
                }
            }
            $where = implode('',$where);


            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows);
            for($i = 0; $i < count($rows); $i++) {
                if(is_string($rows[$keys[$i]]))
                {
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                }
                else
                {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }

                // Parse to add commas
                if($i != count($rows)-1) {
                    $update .= ',';
                }
            }
            $update .= ' WHERE '.$where;
            $query = @mysql_query($update);
            if($query)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
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
}