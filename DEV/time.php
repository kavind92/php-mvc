<?php

//Create a variable for start time

$time_start = microtime(true);

sleep(2);

// SCRIPT CODE
//Create a variable for end time
$time_end = microtime(true);


//Subtract the two times to get seconds
$time = $time_end - $time_start;
echo 'Execution time : ' . sprintf("%.4f", ($time)) . ' seconds';
?>
 