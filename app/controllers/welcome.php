<?php

class welcome extends Controller {

    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        console_log("This page was rendered in " . MVC_SYSTEM_TIMER . " seconds.");
    }

    function index() {
        //Default View
        $this->view->display('welcome_view');
    }

    function baseurltest() {
        //Base URl test
        echo base_url();
    }

    function paramstest($a = NULL, $b = NULL, $c = NULL) {
        //parameters test
        echo "A : $a , B : $b , C : $c";
    }

    function modeltest() {
        //model test
        $this->load->model('default_model');
        $data['data'] = $this->default_model->testmodel();
        $this->view->display('testmodel', $data);
    }

    function helpertest() {
        //helper test
        $this->load->helper("test");
        echo testhelper();
    }

    function librarytest() {
        //library test
        $this->load->library("test_library");
        echo $this->test_library->test1();
    }

}
