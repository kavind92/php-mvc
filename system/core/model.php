<?php

class Model {

    /**
     * $db
     * the database object instance
     * @access	public
     */
    var $db = null;
    
    /**
     * $load
     * the controller load object instance
     * @access	public
     */
    var $load = null;

    /**
     * class constructor
     * @access	public
     */
    function __construct() {
        
        /* save controller instance */
        mvc::instance($this,'Model');
        
        //$this->load = Boot::instance(NULL,'controller')->load;
        
        /* instantiate loadModel */
        $this->load = new LoadModel;
        
    }

}
