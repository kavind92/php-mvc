<?php

class PDODriver extends Database {

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
        $dbtype = $database_configuration['database_type'];

        try {
            $this->connection = new PDO("$dbtype:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo 'PDO Connection Successfull to Database :' . $dbname . '<br/>';
        } catch (PDOException $e) {
            throw new Exception("PDO Connection failed: " . $e->getMessage());
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
        $this->result = $this->connection->prepare($sql);
        $this->result->execute();

        return $this->result;
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
     * function : get_row()
     * @access public
     */
    public function result() {
        /**
         * FETCH_BOTH
         * FETCH_NUM 
         * FETCH_ASSOC
         */
        $this->result->setFetchMode(PDO::FETCH_ASSOC);
        return $this->result->fetch();
    }

    /**
     * function : get_all()
     * @access public
     */
    public function results() {
        /**
         * FETCH_BOTH
         * FETCH_NUM 
         * FETCH_ASSOC
         */
        $this->result->setFetchMode(PDO::FETCH_ASSOC); //FETCH_BOTH FETCH_NUM FETCH_ASSOC
        return $this->result->fetchAll();
    }

    /**
     * insert_id()
     * @access	public
     */
    function insert_id() {
        return $this->connection->lastInsertId();
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
        $this->connection = NULL;
    }

    /**
     * destructor
     * automatically close database connection
     * @access	public
     */
    function __destruct() {
        $this->connection = NULL;
    }

}
