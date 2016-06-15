<?php

// archive.php

$day = $_GET['d'];
$hour = $_GET['h'];

$dir = "/home3/cpurkiss/motionalarm/archive/";

$dirs = array();
if(is_dir($dir)) {
 if($dh = opendir($dir)) {
  while(($file = readdir($dh)) !== false) {
   if( ($file !== ".") && ($file !== "..") ) {
    if(filetype($dir . $file) == "dir") {
     $last_mod = filemtime($dir . $file);
     $dirs[$file] = array();
     $dirs[$file]['show_date'] = date( "D, M jS, Y", $last_mod );
     $dirs[$file]['year'] = date( "Y", $last_mod );
     $dirs[$file]['month'] = date( "n", $last_mod );
     $dirs[$file]['day'] = date( "j", $last_mod );
     $dirs[$file]['file'] = $file;
    }
   }
  }
  closedir($dh);
 }
}

krsort($dirs);

if(!$day) {
 $temp_keys = array_keys($dirs);
 $day = $dirs[$temp_keys[0]]['file'];
}

if(!$hour) {
 $hour = 1;
}

$show_days = array();
foreach( $dirs as $this_day ) {
 if($this_day['file'] == $day) {
  $show_days[] = "<b>{$this_day['show_date']}</b>";
 } else {
  $show_days[] = "<a href=\"http://www.scsconcepts.com/monitoring?a=archive&d={$this_day['file']}&h={$hour}\">{$this_day['show_date']}</a>";
 }
}

$show_hours = array();
for( $x = 1; $x < 25; $x++ ) {
 if($x < 10) {
  $add_zero = "0";
 } else {
  $add_zero = "";
 }
 if($x == $hour) {
  $show_hours[] = "<b>{$add_zero}{$x}</b>";
 } else {
  $show_hours[] = "<a href=\"http://www.scsconcepts.com/monitoring?a=archive&d={$day}&h={$x}\">{$add_zero}{$x}</a>";
 }
}

// load files for that day

$show_before = mktime( $hour+1, 0, 0, $dirs[$day]['month'], $dirs[$day]['day'], $dirs[$day]['year'] );
$show_after = mktime( $hour, 0, 0, $dirs[$day]['month'], $dirs[$day]['day'], $dirs[$day]['year'] );

$files = array();
$day_dir = $dir . $day . "/";
if($dh = opendir($day_dir)) {
 while(($file = readdir($dh)) !== false) {
  if( ($file !== ".") && ($file !== "..") ) {
   if(filetype($day_dir . $file) !== "dir") {
    $last_mod = filemtime($day_dir . $file);
    
    if( ($last_mod > $show_after) && ($last_mod < $show_before) ) {
     $files[$last_mod] = array();
     $files[$last_mod]['dir'] = $day_dir;
     $files[$last_mod]['name'] = $file;
     $files[$last_mod]['last_mod'] = $last_mod;
    }
   }
  }
 }
 closedir($dh);
}

krsort($files);

//images
 
$show_images = array();
foreach($files as $file) {
 $show_images[] = "<div style=\"position:relative; float:left; width:225px; height:200px; text-align:left\"><span style=\"overflow:hidden; font-size:8pt\">{$file['name']}</span><br /><a href=\"image.php?p=" . $file['dir'] . $file['name'] . "\" target=\"_blank\"><img style=\"border:0; max-width:225px\" src=\"image.php?p=" . $file['dir'] . $file['name'] . "\" /></a></div>";
}

$output[] = "<div style=\"float:left; position:relative; width:200px; text-align:left\">day<br /><br />" . implode( "<br />", $show_days ) . "</div>";
$output[] = "<div style=\"float:left; position:relative; width:100px; text-align:left\">hour<br /><br />" . implode( "<br />", $show_hours ) . "</div>";
$output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1100px; text-align:left\">" . count($files) . " files<br />" . implode( "\n", $show_images ) . "</div>";

?>