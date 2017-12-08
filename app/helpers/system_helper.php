<?php

/* Auto Copyright Year */

function auto_copyright($year = 'auto') {
    if (intval($year) == 'auto') {
        $year = date('Y');
    }
    if (intval($year) == date('Y')) {
        return intval($year);
    }
    if (intval($year) < date('Y')) {
        return intval($year) . ' - ' . date('Y');
    }
    if (intval($year) > date('Y')) {
        return date('Y');
    }
}

/* USAGE
  echo auto_copyright(); // 2011
  echo auto_copyright("2010");  // 2010 - 2017
 */

/* END Auto Copyright Year */


/* Client IP Address */

function get_client_ip_getenv() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function get_client_ip_server() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function ipaddress() {
    if (get_client_ip_getenv() == "" || get_client_ip_getenv() == "UNKNOWN") {
        return get_client_ip_server();
    } else {
        return get_client_ip_getenv();
    }
}

/*USAGE
echo ipaddress();
*/

/*END Client IP Address*/

/*console log in PHP*/
function console_log($data = "This is PHP-JS Console Log Version 1.0") {
    $json_data = array($data);
    echo "<script>console.log('". json_encode($json_data)."');</script>";
}

/*USAGE
echo console_log($array or $variable);
*/

/*END console log in PHP*/