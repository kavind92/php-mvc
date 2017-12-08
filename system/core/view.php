<?php

class View {

    /**
     * $view_data
     * data for view file assignment
     * @access	public
     */
    var $view_data = array();

    function __construct() {
        
    }

    /**
     * display
     * just display a view file
     * @access  public
     * @param   string $view_filename the name of the view file
     * @return  boolean
     */
    public function display($view_filename, $view_data = NULL) {
        return $this->view($view_filename, $view_data);
    }

    /**
     * fetch
     * return the contents of a view file
     * @access	public
     * @param   string $filename
     * @return  string contents of view
     */
    public function fetch($view_filename, $view_data = null) {
        ob_start();
        $this->display($view_filename, $view_data);
        $results = ob_get_contents();
        ob_end_clean();
        return $results;
    }

    /**
     * assign
     * assign view variables
     * @access	public
     * @param   mixed $key key of assignment, or value to assign
     * @param   mixed $value value of assignment
     */
    public function assign($key, $value = NULL) {
        if (isset($value)) {
            $this->view_data[$key] = $value;
        } else {
            foreach ($key as $k => $v) {
                if (is_int($k)) {
                    $this->view_data[] = $v;
                } else {
                    $this->view_data[$k] = $v;
                }
            }
        }
    }

    /**
     * view
     * internal: display a view file
     * @access	public
     * @param   string $view_filename
     * @param   array $view_data
     */
    public function view($view_filename, $view_data = NULL) {
        // bring view vars into view scope
        extract($this->view_data);
        if (isset($view_data)) {
            extract($view_data);
        }
        try {
            include($view_filename.'.php');
        } catch (Exception $e) {
            throw new Exception("File '$view_filename' Doesn't exist".$e->getMessage());
        }
    }

}
