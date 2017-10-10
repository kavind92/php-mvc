<?php

class Default_model extends Model {

    function __construct() {
        parent::__construct();
        //$this->load->database();
        //$this->db->query("SHOW TABLES");
        //print_r($this->db->results());
    }
    
    function testmodel(){
        $this->load->database();
        $this->db->query("SELECT * FROM test");
        //echo $this->db->last_query;
        return $this->db->results();
    }

}
