<?php

/* MVC SYSTEM FOLDER */
$MVC['APP_MODE'] = "PRODUCTION"; //DEVELOPMENT TESTING PRODUCTION

switch ($MVC['APP_MODE']) {
    case "DEVELOPMENT":
        error_reporting(E_ALL);
        ini_set('display_errors', 1);//ON
        break;
    case "TESTING":
        ini_set('display_errors', 0);//OFF
        break;
    case "PRODUCTION":
        ini_set('display_errors', 0);//OFF
        break;
    default : 
        ini_set('display_errors', 0);//OFF
        break;
}

/* MVC SYSTEM FOLDER */
$MVC['SYS_PATH'] = "system/";


/* MVC APPLICATION FOLDER */
$MVC['APP_PATH'] = "application/";

/* ERROR HANDLING */
$MVC['MVC_ERROR_HANDLING'] = 1; // 1(handle errors internally) 0(to handle externelly)

/* -------------------DONT MODIFY CODE BELOW--------------------- */

$MVC['BASE_PATH'] = dirname(__FILE__) . '/';
$MVC['SYS_PATH'] = $MVC['BASE_PATH'] . $MVC['SYS_PATH'];
$MVC['APP_PATH'] = $MVC['BASE_PATH'] . $MVC['APP_PATH'];
//exit("dev checking");

require($MVC['SYS_PATH'] . "core/mvc.php");
$app = new mvc();
/*---------------------END DONT MODIFY CODE---------------------*/