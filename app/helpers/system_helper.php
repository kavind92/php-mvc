<?php

/*Auto Copyright Year*/
function auto_copyright($year = 'auto') {
    if (intval($year) == 'auto') {
        $year = date('Y');
    }
    if (intval($year) == date('Y')) {
        echo intval($year);
    }
    if (intval($year) < date('Y')) {
        echo intval($year) . ' - ' . date('Y');
    }
    if (intval($year) > date('Y')) {
        echo date('Y');
    }
}
/*USAGE
auto_copyright(); // 2011
auto_copyright("2010");  // 2010 - 2017 
*/

/*END Auto Copyright Year*/