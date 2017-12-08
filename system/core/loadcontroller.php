<?php

class LoadController {

    function __construct() {
        /* save controller instance */
        mvc::instance($this, 'LoadController');
    }

    /**
     * model
     * load a model object
     * @access	public
     * @param   string $model_name the name of the model class
     * @param   string $model_alias the property name alias
     * @param   string $database_group the database group name to use
     * @return  boolean
     */
    public function model($model_name, $model_alias = NULL, $database_group = NULL) {

        /* if no alias, use the model name */
        if (!isset($model_alias) || empty($model_alias)) {
            $model_alias = $model_name;
        }

        if (!preg_match('!^[a-zA-Z][a-zA-Z0-9_]+$!', $model_alias)) {
            throw new Exception("Model name '{$model_alias}' is an invalid syntax");
        }

        if (method_exists($this, $model_alias)) {
            throw new Exception("Model name '{$model_alias}' is an invalid (reserved) name");
        }

        /* get instance of controller object */
        $controller = mvc::instance(null, 'Controller');

        /* model already loaded? silently skip */
        if (isset($controller->$model_alias)) {
            return true;
        } else {
            /* instantiate the object as a property */
            $controller->$model_alias = new $model_name($database_group);
        }
        return true;
    }

    /**
     * library
     * load a library object
     * @access	public
     * @param   string $library_name the name of the model class
     * @param   string $library_alias the property name alias
     * @param   string $filename the filename
     * @param   string $pool_name the database pool name to use
     * @return  boolean
     */
    public function library($library_name, $library_alias = null, $filename = null, $pool_name = null) {

        /* if no alias, use the model name */
        if (!isset($library_alias) || empty($library_alias)) {
            $library_alias = $library_name;
        }

        /* if no filename, use the lower-case model name */
        if (!isset($filename)) {
            $filename = strtolower($library_name) . '.php';
        }

        if (!preg_match('!^[a-zA-Z][a-zA-Z0-9_]+$!', $library_alias)) {
            throw new Exception("Library name '{$library_alias}' is an invalid syntax");
        }

        if (method_exists($this, $library_alias)) {
            throw new Exception("Library name '{$library_alias}' is an invalid (reserved) name");
        }

        /* get instance of controller object */
        $controller = mvc::instance(null, 'Controller');

        /* model already loaded? silently skip */
        if (isset($controller->$library_alias)) {
            return true;
        } else {
            /* instantiate the object as a property */
            $controller->$library_alias = new $library_name($pool_name);
        }
        return true;
    }

    /**
     * helper
     * load a helper plugin
     * @access	public
     * @param   string $helper_name the script plugin name
     * @return  boolean
     */
    public function helper($helper_name) {

        if (!preg_match('!^[a-zA-Z][a-zA-Z_]+$!', $helper_name)) {
            throw new Exception("Invalid script name '{$helper_name}'");
        }

        $filename = strtolower("{$helper_name}.php");

        try {
            require_once($filename);
        } catch (Exception $e) {
            throw new Exception("Unknown helper file '{$filename}'" . $e->getMessage());
        }
    }

    /**
     * language
     * load a language 
     * @access	public
     * @param   string $language the script plugin name
     */
    public function language($language) {
        $filename = strtolower("{$language}.php");
        try {
            if (file_exists($filename)) {
                $ld = array();
                include($filename);
                /* get instance of controller object */
                $controller = mvc::instance(null, 'Controller');
                $controller->language = $ld; // language data
            }
        } catch (Exception $e) {
            throw new Exception("Unknown language file '{$filename}'" . $e->getMessage());
        }
    }

}
