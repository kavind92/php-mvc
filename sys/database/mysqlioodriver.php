<?php

class MySQLiOODriver extends Database {

   
    /**
     * constructor
     * create database connection
     * @access	public
     * @param   array $database_configuration database access details
     */
    function __construct($database_configuration) {
        parent::__construct();
        $servername = $database_configuration['hostname'];
        $username = $database_configuration['username'];
        $password = $database_configuration['password'];
        $dbname = $database_configuration['database_name'];

        // Create connection
        $this->connection = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($this->connection->connect_error) {
            throw new Exception("MySQLiOO Connection failed: " . $this->connection->connect_error);
        } else {
            //echo 'MySQLiOO Connection Successfull to Database :' . $dbname . '<br/>';
        }
    }

    /**
     * query
     * manual close database connection
     * @access	public
     * @param string $query SQL query to be execute
     * @param array $bind_params Binding Parameters in an array
     */
    function query($query = NULL, $bind_params = NULL) {
        if (empty($query)) {
            $query = $this->assemble_query();
        }
        if (is_array($bind_params)) {
            $query = $this->bind_query_params($query, $bind_params);
        }
        //echo $query . '<br/>';
        return $this->_query($query);
    }

    /**
     * function : _query()
     * run SQL and return results in object(READ SQL) , return TRUE/FALSE(WRITE SQL)
     * @access private
     * @param string $sql SQL query to execute
     */
    private function _query($sql) {
        $this->last_query = $sql;
        return $this->result = $this->connection->query($sql);
    }

    /**
     * function : bind_query_params()
     * BIND all params to sql
     * @access public
     * @return string SQL as string
     */
    private function bind_query_params($sql, $parms) {
        /* explode sql as an array using ? */
        $sql_array = explode('?', $sql);
        $sql_string = NULL;
        for ($i = 0; $i < count($sql_array) - 1; $i++) {
            $parm = $parms[$i];
            if (is_array($parms[$i])) {
                $parm = '(';
                $parm.=implode(',', $parms[$i]);
                $parm.=')';
            }
            $sql_string.=$sql_array[$i] . $parm;
        }
        return $sql_string;
    }

    /**
     * function : result()
     * @access public
     */
    public function result() {
        /**
         * MYSQLI_BOTH 
         * MYSQLI_NUM 
         * MYSQLI_ASSOC
         */
        return $this->result->fetch_array(MYSQLI_ASSOC);
    }

    /**
     * function : results()
     * @access public
     */
    public function results() {
        /**
         * MYSQLI_BOTH 
         * MYSQLI_NUM 
         * MYSQLI_ASSOC
         */
        return $this->result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * insert_id()
     * @access	public
     */
    function insert_id() {
        return $this->connection->insert_id;
    }

    /**
     * last_query()
     * manual close database connection
     * @access	public
     */
    function last_query() {
        return $this->last_query;
    }

    /**
     * close
     * manual close database connection
     * @access	public
     */
    function close() {
        $this->connection->close();
    }

    /**
     * destructor
     * automatically close database connection
     * @access	public
     */
    function __destruct() {
        $this->connection->close();
    }

}
