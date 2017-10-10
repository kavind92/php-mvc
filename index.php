<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

/* MVC SYSTEM FOLDER */
$MVC['APP_MODE'] = "DEVELOPMENT"; //DEVELOPMENT TESTING PRODUCTION

/* MVC SYSTEM FOLDER */
$MVC['SYS_PATH'] = "sys/";


/* MVC APPLICATION FOLDER */
$MVC['APP_PATH'] = "app/";

/* ERROR HANDLING */
$MVC['MVC_ERROR_HANDLING'] = 1; // 1(handle errors internally) 0(to handle externelly)

/* -------------------DONT MODIFY CODE BELOW--------------------- */

$MVC['BASE_PATH'] = dirname(__FILE__) . '/';
$MVC['SYS_PATH'] = $MVC['BASE_PATH'].$MVC['SYS_PATH'];
$MVC['APP_PATH'] = $MVC['BASE_PATH'].$MVC['APP_PATH'];
//exit("dev checking");

require($MVC['SYS_PATH'] . "core/mvc.php");
$app = new mvc();
/*---------------------END DONT MODIFY CODE---------------------*/