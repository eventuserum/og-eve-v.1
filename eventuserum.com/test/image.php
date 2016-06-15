<?php

// image.php

$path = $_GET['p'];

//echo $path;

header('Content-Type: image/jpeg');
readfile($path);

//readfile("/home3/cpurkiss/motionalarm/Incoming_alarm/192.168.15.2_chn0_2016_04_22_20_59_28.jpg");

?>