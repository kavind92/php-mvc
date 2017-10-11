<?php

class welcome extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->display('welcome_view');
    }

    function test($a = NULL, $b = NULL, $c = NULL) {
        echo "A : $a , B : $b , C : $c";
    }

    function modeltest() {
        $this->load->model('default_model');
        $data['data'] = $this->default_model->testmodel();
        //print_r($data);
        $this->view->display('testmodel', $data);
    }

    function helpertest() {
        $this->load->helper("test");
        echo testhelper();
    }

    function librarytest() {
        $this->load->library("test_library");
        echo $this->test_library->test1();
    }

}
