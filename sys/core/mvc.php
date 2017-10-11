<?php

/*console log in PHP*/
function console_log($data = "This is PHP-JS Console Log Version 1.0") {
    echo "<script>console.log('". json_encode($data)."');</script>";
}

/* base_url */
function base_url($path = NULL) {
    //$actual_link = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    //$actual_link = str_replace("index.php", "", $actual_link);
    include('app_config.php');
    $url= $MVC['config']['url'];
    return "$url";
}

/* file_access */
function file_access($path = NULL) {
    $base_url = base_url();
    return "$base_url$path";
}

/**
 * redirect
 * redirect web browser and exit
 * @access  public
 * @param   string   $uri     where to redirect to
 */
function redirect($uri) {

    if (empty($uri)) {
        return false;
    }
    header("Location: $uri");
    exit;
}


$MVC['VERSION'] = "0.0.1(beta)";

/* set include_path for spl_autoload */
set_include_path(get_include_path()
        . PATH_SEPARATOR . $MVC['APP_PATH'] . "configs" . "/"
        . PATH_SEPARATOR . $MVC['APP_PATH'] . "controllers". "/"
        . PATH_SEPARATOR . $MVC['APP_PATH'] . "helpers" . "/"
        . PATH_SEPARATOR . $MVC['APP_PATH'] . "languages". "/"
        . PATH_SEPARATOR . $MVC['APP_PATH'] . "libraries". "/"
        . PATH_SEPARATOR . $MVC['APP_PATH'] . "models". "/"
        . PATH_SEPARATOR . $MVC['APP_PATH'] . "views". "/"
        . PATH_SEPARATOR . $MVC['SYS_PATH'] . "core". "/"
        . PATH_SEPARATOR . $MVC['SYS_PATH'] . "database". "/"
);

//echo PATH_SEPARATOR . $MVC['SYS_PATH'] . "core". "/";
//exit("dev checking");

/* set .php first for speed */
spl_autoload_extensions('.php,.inc');

$spl_funcs = spl_autoload_functions();
if ($spl_funcs === false) {
    spl_autoload_register();
} elseif (!in_array('spl_autoload', $spl_funcs)) {
    spl_autoload_register('spl_autoload');
}

class mvc {

    private $config = null;
    private $controller = null;
    private $action = null;
    private $arguments = null;
    private $path_info = null;
    private $url_segments = null;

    function __construct($class_id = 'DEFAULT') {
        self::instance($this, $class_id);
          
        $this->start();
    }

    function __destruct() {
        if($GLOBALS['MVC']['APP_MODE'] == "DEVELOPMENT"){
            //console_log(sprintf('%0.5f', self::timer('mvc_app_start', 'mvc_app_end'))." seconds.(v".$GLOBALS['MVC']['VERSION'].")","Page rendered in");
        }
        
    }

    public function start() {
        /* set initial timer */
        $this->timer('mvc_app_start');

        $this->getSetPathInfo();

        $this->setupErrorHandling();

        include('app_config.php');
        $this->config = $MVC['config'];

        $this->setupRouting();

        $this->setupSegments();

        $this->setupController();

        $this->setupAction();

        $this->setupArguments();
        
        $this->setupAutoloaders();

        /* capture output if timing */
        if ($this->config['timer']) {
            ob_start();
        }

        $this->setupDispatch();

        if ($this->config['timer']) {
            /* insert timing info */
            $output_contents = ob_get_contents();
            ob_end_clean();
            self::timer('mvc_app_end');
            define("MVC_SYSTEM_TIMER", sprintf('%0.5f', self::timer('mvc_app_start', 'mvc_app_end')));
            $output_timer = str_replace('{MVC_SYSTEM_TIMER}', MVC_SYSTEM_TIMER, $output_contents);
            $output_version = str_replace('{MVC_SYSTEM_VERSION}',$GLOBALS['MVC']['VERSION'] , $output_timer);
            $output = $output_version;
            echo $output;
        }
    }

    /**
     * getSetPathInfo - get the url and set to $path_info
     * @access private
     */
    private function getSetPathInfo() {
        $this->path_info = !empty(filter_input(INPUT_SERVER, 'PATH_INFO')) ? filter_input(INPUT_SERVER, 'PATH_INFO') : (!empty(filter_input(INPUT_SERVER, 'ORIG_PATH_INFO')) ? filter_input(INPUT_SERVER, 'ORIG_PATH_INFO') : '');
        //$this->path_info = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
    }

    /**
     * setup error handling for tmvc
     * @access	public
     */
    public function setupErrorHandling() {
        if ($GLOBALS['MVC']['MVC_ERROR_HANDLING'] === 1) {
            //require_once('exception_handler.php');
            set_exception_handler(array('ExceptionHandler', 'handleException'));
            require_once('mvc_errorhandler.php');
            set_error_handler('myErrorHandler');
            
        }
    }

    /**
     * setup url routing for tmvc
     * @access	public
     */
    public function setupRouting() {
        if (!empty($this->config['routing']['search']) && !empty($this->config['routing']['replace'])) {
            $this->path_info = preg_replace($this->config['routing']['search'], $this->config['routing']['replace'], $this->path_info);
        }
    }

    /**
     * setup url segments array
     * @access	public
     */
    public function setupSegments() {
        $this->url_segments = !empty($this->path_info) ? array_filter(explode('/', $this->path_info)) : NULL;
    }

    /**
     * setup controller
     * @access	public
     */
    public function setupController() {

        /* get controller/method */
        if (!empty($this->config['root_controller'])) {
            $controller_name = $this->config['root_controller'];
            $controller_file = "{$controller_name}.php";
        } else {
            $controller_name = !empty($this->url_segments[1]) ? preg_replace('!\W!', '', $this->url_segments[1]) : $this->config['default_controller'];
            $controller_file = "{$controller_name}.php"; 
            /* if no controller, use default */
            if (!stream_resolve_include_path($controller_file)) {
                $controller_name = $this->config['default_controller'];
                $controller_file = "{$controller_name}.php";
            }
        }
        
        include($controller_file);
        /* see if controller class exists */
        $controller_class = $controller_name;
       
        /* instantiate the controller */
        $this->controller = new $controller_class(true);
    }

    /**
     * setup controller method (action) to execute
     * @access	public
     */
    public function setupAction() {
        if (!empty($this->config['root_action'])) {
            /* user override if set */
            $this->action = $this->config['root_action'];
        } else {
            /* get from url if present, else use default */
            $this->action = !empty($this->url_segments[2]) ? $this->url_segments[2] :
                    (!empty($this->config['default_action']) ? $this->config['default_action'] : 'index');
            /* cannot call method names starting with underscore */
            if (substr($this->action, 0, 1) == '_') {
                throw new Exception("Action name not allowed '{$this->action}'");
            }
        }
    }
    
    public function setupArguments() {
        $this->arguments = !empty($this->url_segments[3]) ? array_slice($this->url_segments, 2) : NULL;
    }

  public function setupAutoloaders() {
        if (!empty($this->config['autoload']['libraries'])) {
            foreach ($this->config['autoload']['libraries'] as $library) {
                $this->controller->load->library($library);
            }
        }
        if (!empty($this->config['autoload']['helpers'])) {
            foreach ($this->config['autoload']['helpers'] as $helper) {
                $this->controller->load->helper($helper);
            }
        }
        if (!empty($this->config['autoload']['models'])) {
            foreach ($this->config['autoload']['models'] as $model) {
                $this->controller->load->model($model);
            }
        }
    }
    
    function setupDispatch() {
        //include($controller_file);
        
        //$this->controller = new $this->controller(true);
        if (method_exists($this->controller, $this->action)) {
            if (is_array($this->arguments)) {
                call_user_func_array(array($this->controller, $this->action), $this->arguments);
            } else {
                $this->controller->{$this->action}();
            }
        } else {
            //redirect(base_url("Error/page/Controller_Method_Not_Exist/"));
            throw new Exception("method/function doesn't exist '{$this->action}'");
        }
    }
    /**
     * timer
     * get/set timer values
     * @access  public
     * @param   string $id the timer id to set (or compare with $id2)
     * @param   string $id2 the timer id to compare with $id
     * @return  float  difference of two times
     */
    public static function timer($id = null, $id2 = null) {
        static $times = array();
        if ($id !== null && $id2 !== null) {
            return (isset($times[$id]) && isset($times[$id2])) ? ($times[$id2] - $times[$id]) : false;
        } elseif ($id !== null) {
            return $times[$id] = microtime(true);
        }
        return false;
    }

    /**
     * instance get/set the mvc object instance(s) of required classes
     * @access	public
     * @param   object $new_instance reference to new object instance
     * @param   string $id object instance id
     * @return  object $instance reference to object instance
     */
    public static function &instance($new_instance = NULL, $id = 'DEFAULT') {
        static $instance = array();
        if (isset($new_instance) && is_object($new_instance)) {
            $instance[$id] = $new_instance;
        }
        return $instance[$id];
    }

}
