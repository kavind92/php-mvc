<?php

$MVC['config']['url'] = "http://localhost/github/php-mvc/";

/* URL routing, use preg_replace() compatible syntax */
$MVC['config']['routing']['search'] =  array();
$MVC['config']['routing']['replace'] = array();
 
/* set this to force controller and method instead of using URL params */
$MVC['config']['root_controller'] = null;
$MVC['config']['root_action'] = null;

/* name of default controller/method when none is given in the URL */
$MVC['config']['default_controller'] = 'welcome';
$MVC['config']['default_action'] = 'index';

/* name of PHP function that handles system errors */
$MVC['config']['error_handler_class'] = 'ExceptionHandler';

/* enable timer. use {TMVC_TIMER} in your view to see it */
$MVC['config']['timer'] = true;



/*ROUTES*/
//$MVC['routing']['search']= array('/helper'); // example route /foo/123 to /foo/index/123
//$MVC['routing']['replace']= array('/welcome/helpertest');

/*AUTOLOADERS*/
/* auto-loaded libraries
 * EXAMPLE :- $MVC['config']['autoload']['libraries'] = array('test_library');
 */
$MVC['config']['autoload']['libraries'] = array();

/* auto-loaded scripts 
 * EXAMPLE :- $MVC['config']['autoload']['helpers'] = array('test');
 */
$MVC['config']['autoload']['helpers'] = array();

/* auto-loaded scripts 
 *  EXAMPLE :- $MVC['config']['autoload']['models'] = array('default_model');
 */
$MVC['config']['autoload']['models'] = array();


/*
 * -----------------------------------------------------------------------------
 * -----------------------------------------------------------------------------
 * DATABASE CONFIGURATION ------------------------------------------------------
 * -----------------------------------------------------------------------------
 * -----------------------------------------------------------------------------
 */
/* DRIVERS LIST
 * -------------
 * MySQLiDriver
 * MySQLiOODriver
 * PDODriver
 */

$database['default_database_group'] = "default";

$database['default'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database_name' => 'php-mvc',
    'database_type' => 'mysql',
    'database_driver' => 'MySQLiOODriver',
    'char_set' => 'utf8',
    'persistent' => FALSE,
);

/**
 * EXAMPLES

$database['MySQLiDriver_DATABASE'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database_name' => 'test',
    'database_type' => 'mysql',
    'database_driver' => 'MySQLiDriver',
    'char_set' => 'utf8',
    'persistent' => FALSE,
);

$database['MySQLiOODriver_DATABASE'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database_name' => 'test',
    'database_type' => 'mysql',
    'database_driver' => 'MySQLiOODriver',
    'char_set' => 'utf8',
    'persistent' => FALSE,
);

$database['PDODriver_DATABASE'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database_name' => 'test',
    'database_type' => 'mysql',
    'database_driver' => 'PDODriver',
    'char_set' => 'utf8',
    'persistent' => FALSE,
);

 */
/*
 * -----------------------------------------------------------------------------
 * END -------------------------------------------------------------------------
 * -----------------------------------------------------------------------------
 */

