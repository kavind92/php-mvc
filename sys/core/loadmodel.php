<?php

class LoadModel{
    
    function __construct() {
        /* save controller instance */
        mvc::instance($this, 'LoadModel');
    }
    
    /**
     * database
     * returns a database plugin object
     * @access	public
     * @param	string $database_group the name of the database pool (if NULL default pool is used)
     * @return	object
     */
    public function database($database_group = NULL) {

        static $dbs = array();
        /* load config information */
        
        $database =array();
        //include(configurations_PATH . 'all_configurations.php');
        include('app_config.php');
        
        if (!$database_group) {
            $database_group = isset($database['default_database_group']) ? $database['default_database_group'] : 'default';
        }
        
        /* if Requested Database group already loaded*/
        if (isset($dbs[$database_group])) {
            /* returns object from runtime cache */
            return $dbs[$database_group];
        }
        
        if (isset($database[$database_group]) && !empty($database[$database_group]['database_driver'])) {
            $dbs[$database_group] = new $database[$database_group]['database_driver']($database[$database_group]);
        }
        
        $Model = mvc::instance(NULL, 'Model');
        $Model->db = $dbs[$database_group];

        return $dbs[$database_group];
    }

    
}
