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
     * @var object pdo Holds PDO object database connection after successful connection;
     */
    private $pdo;             // Checks to see if the connection is active
    private $result = array();

    function __construct() {
        $this->db_host = 'localhost';
        $this->db_name = 'test';
        $this->db_user = 'admin';
        $this->db_pass = '31081987';

    } // Results that are returned from the query

    /*
     * Connects to the database, only one connection
     * allowed
     */



    public function connect()
    {
        if(!$this->pdo)
        {
            try {
                // Data Source Name for PDO connection;
                $dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
                // Connection to the database happens here;
                $this->pdo = new PDO($dsn, $this->db_user, $this->db_pass);
                // Setts PDO error reporting to throw exceptions;
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Setts private var $link to true indicating that connection was created;
                return true;
            // If exception was thrown store into variable $e and echo it out;
            } catch (PDOException $e) {
                echo 'ERROR IN CONNECTION: ' . $e->getMessage();
            }

        }
        else
        {
            return false;
        }
    }

    /*
    * Changes the new database, sets all current results
    * to null
    */
    public function setDatabase($name)
    {
            if($this->pdo)
            {
                $this->pdo = null;
                $this->db_name = $name;
                $this->connect();
                return true;
            }
    }

    /*
    * Checks to see if the table exists when performing
    * queries
    */
    public function tableExists ( $table )
    {


        $stmt = $this->pdo->prepare('SHOW TABLES FROM :dbname LIKE ":table"');
        $data = array (
            'dbname' => $this->db_name,
            'table' => $table
        );
        $stmt->execute($data);

        $rows = $stmt->fetch(PDO::FETCH_ASSOC);



//        if($tablesInDb)
//        {
//            if(mysql_num_rows($tablesInDb)==1)
//            {
//                return true;
//            }
//            else
//            {
//                return false;
//            }
//        }

    }

//    /*
//    * Selects information from the database.
//    * Required: table (the name of the table)
//    * Optional: rows (the columns requested, separated by commas)
//    *           where (column = value as a string)
//    *           order (column DIRECTION as a string)
//    */
//
//    public function select($table, $rows = '*', $where = null, $order = null)
//    {
//        $stmt = 'SELECT ' . $rows . ' FROM ' . $table;
//
//        if($where != null)
//            $stmt .= ' WHERE '.$where;
//        if($order != null)
//            $stmt .= ' ORDER BY '.$order;
//
//        $query = @mysql_query($stmt);
//        if($query)
//        {
//            $this->numResults = mysql_num_rows($query);
//            for($i = 0; $i < $this->numResults; $i++)
//            {
//                $r = mysql_fetch_array($query);
//                $key = array_keys($r);
//                for($x = 0; $x < count($key); $x++)
//                {
//                    // Sanitizes keys so only alpha values are allowed
//                    if(!is_int($key[$x]))
//                    {
//                        if(mysql_num_rows($query) > 1)
//                            $this->result[$i][$key[$x]] = $r[$key[$x]];
//                        else if(mysql_num_rows($query) < 1)
//                            $this->result = null;
//                        else
//                            $this->result[$key[$x]] = $r[$key[$x]];
//                    }
//                }
//            }
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }
//
//    /*
//    * Insert values into the table
//    * Required: table (the name of the table)
//    *           values (the values to be inserted)
//    * Optional: rows (if values don't match the number of rows)
//    */
//    public function insert($table,$values,$rows = null)
//    {
//        if($this->tableExists($table))
//        {
//            $insert = 'INSERT INTO '.$table;
//            if($rows != null)
//            {
//                $insert .= ' ('.$rows.')';
//            }
//
//            for($i = 0; $i < count($values); $i++)
//            {
//                if(is_string($values[$i]))
//                    $values[$i] = '"'.$values[$i].'"';
//            }
//            $values = implode(',',$values);
//            $insert .= ' VALUES ('.$values.')';
//
//            $ins = @mysql_query($insert);
//
//            if($ins)
//            {
//                return true;
//            }
//            else
//            {
//                return false;
//            }
//        }
//    }
//
//    /*
//    * Deletes table or records where condition is true
//    * Required: table (the name of the table)
//    * Optional: where (condition [column =  value])
//    */
//    public function delete($table,$where = null)
//    {
//        if($this->tableExists($table))
//        {
//            if($where == null)
//            {
//                $delete = 'DELETE '.$table;
//            }
//            else
//            {
//                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
//            }
//            $del = @mysql_query($delete);
//
//            if($del)
//            {
//                return true;
//            }
//            else
//            {
//                return false;
//            }
//        }
//        else
//        {
//            return false;
//        }
//    }
//
//    /*
//     * Updates the database with the values sent
//     * Required: table (the name of the table to be updated
//     *           rows (the rows/values in a key/value array
//     *           where (the row/condition in an array (row,condition) )
//     */
//    public function update($table,$rows,$where)
//    {
//        if($this->tableExists($table))
//        {
//            // Parse the where values
//            // even values (including 0) contain the where rows
//            // odd values contain the clauses for the row
//            for($i = 0; $i < count($where); $i++)
//            {
//                if($i%2 != 0)
//                {
//                    if(is_string($where[$i]))
//                    {
//                        if(($i+1) != null)
//                            $where[$i] = '"'.$where[$i].'" AND ';
//                        else
//                            $where[$i] = '"'.$where[$i].'"';
//                    }
//                }
//            }
//            $where = implode('',$where);
//
//
//            $update = 'UPDATE '.$table.' SET ';
//            $keys = array_keys($rows);
//            for($i = 0; $i < count($rows); $i++)
//            {
//                if(is_string($rows[$keys[$i]]))
//                {
//                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
//                }
//                else
//                {
//                    $update .= $keys[$i].'='.$rows[$keys[$i]];
//                }
//
//                // Parse to add commas
//                if($i != count($rows)-1)
//                {
//                    $update .= ',';
//                }
//            }
//            $update .= ' WHERE '.$where;
//            $query = @mysql_query($update);
//            if($query)
//            {
//                return true;
//            }
//            else
//            {
//                return false;
//            }
//        }
//        else
//        {
//            return false;
//        }
//    }
//
//    /*
//    * Returns the result set
//    */
//    public function getResult()
//    {
//        return $this->result;
//    }
}