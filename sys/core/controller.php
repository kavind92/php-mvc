<?php

class Controller {

    /**
     * $load
     * the controller load object instance
     * @access	public
     */
    var $load = NULL;

    /**
     * $view
     * the view load object instance
     * @access	public
     */
    var $view = NULL;

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
    var $language = NULL;

    /**
     * class constructor
     * @access	public
     */
    public function __construct() {

        /* save controller instance */
        mvc::instance($this, 'Controller');

        /* instantiate load library */
        $this->load = new LoadController;

        /* instantiate view library */
        $this->view = new View;
    }

}
