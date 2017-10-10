<?php
echo "<script>console.log('Current Session time : " . json_encode(ini_get('session.gc_maxlifetime')) . "');</script>";