<?php

// alarms_embed.php

//alarms
$dir = "/home3/cpurkiss/motionalarm/Incoming_alarm/";

$files = array();
$sub_dirs = array();
// top dir
if(is_dir($dir)) {
 if($dh = opendir($dir)) {
   while(($file = readdir($dh)) !== false) {
    if( ($file !== ".") && ($file !== "..") ) {
     if(filetype($dir . $file) !== "dir") {
      $last_mod = filemtime($dir . $file);
   
      $files[$last_mod] = array();
      $files[$last_mod]['dir'] = $dir;
      $files[$last_mod]['name'] = $file;
      $files[$last_mod]['type'] = filetype($dir . $file);
      $files[$last_mod]['last_mod'] = $last_mod;
     } else {
      $sub_dirs[] = $file . "/";
     }
    }
   }
   closedir($dh);
 }
 // sub dirs
 foreach($sub_dirs as $sub_dir) {
  if(is_dir($dir . $sub_dir)) {
   if($dh = opendir($dir . $sub_dir)) {
    while(($file = readdir($dh)) !== false) {
     if( ($file !== ".") && ($file !== "..") ) {
      if(filetype($dir . $sub_dir . $file) !== "dir") {
       $last_mod = filemtime($dir . $sub_dir . $file);
   
       $files[$last_mod] = array();
       $files[$last_mod]['dir'] = $dir . $sub_dir;
       $files[$last_mod]['name'] = $file;
       $files[$last_mod]['type'] = filetype($dir . $sub_dir . $file);
       $files[$last_mod]['last_mod'] = $last_mod;
      }
     }
    }
    closedir($dh);
   }
  }
 }
 
 // sort it out
 
 krsort($files);
 
 $file_limit = 50;
 $count = 0;
 
 $save = array();
 $old = array();
 
 foreach($files as $file) {
  if($count > $file_limit) {
   $old[] = array( "dir" => $file['dir'], "name" => $file['name'] );
  } else {
   $save[] = $file;
  }
  $count++;
 }
 
 //$output[] = "<p>Found " . count($files) . " files. Moving " . count($old) . " files to archive.<p>";
 $found = "<p>Found " . count($files) . " files. Moving " . count($old) . " files to archive.<p>";
 
 //archive
 
 $archive_top = "/home3/cpurkiss/motionalarm/archive/";
 $archive_sub = date( "Ymd" );
 
 $can_archive = 0;
 
 if(!is_dir($archive_top)) {
  mkdir( $archive_top, 0777 );
 }
 
 if(!is_dir($archive_top . $archive_sub)) {
  if(mkdir( $archive_top . $archive_sub, 0777 )) {
   $can_archive = 1;
  }
 } else {
  $can_archive = 1;
 }
 
 $move_log = array();
 
 foreach($old as $old_file) {
  $move_log[] = "Moved " . $old_file['dir'] . $old_file['name'] . " to " . $archive_top . $archive_sub . "/" . $old_file['name'];
  rename( $old_file['dir'] . $old_file['name'], $archive_top . $archive_sub . "/" . $old_file['name'] );
 }
 
 //images
 
 $show_images = array();
 foreach($save as $file) {
  //$output[] = "filename: {$file['name']} : filetype: {$file['type']} last modified: " . date ("F d Y H:i:s.", $file['last_mod']) . "<br />";
  $show_images[] = "<div style=\"position:relative; float:left; width:325px; height:300px; text-align:left\"><span style=\"overflow:hidden; font-size:8pt\">{$file['name']}</span><br /><a href=\"image.php?p=" . $file['dir'] . $file['name'] . "\" target=\"_blank\"><img style=\"border:0; max-width:325px\" src=\"image.php?p=" . $file['dir'] . $file['name'] . "\" /></a></div>";
 }
 
 $output[] = $found;
 $output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1000px\">" . implode( "\n", $show_images ) . "</div>";
 
 if(count($old) > 0) {
  $output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1300px; color:gray\">" . implode ( "<br />", $move_log ) . "</div>";
 }
} else {
 $output[] = "Not a directory.";
}
 
$html = "<!DOCTYPE html>
<html class=\"html\" lang=\"en-US\">
 <head>
  <meta http-equiv=\"refresh\" content=\"25\">
  <meta http-equiv=\"Content-type\" content=\"text/html;charset=UTF-8\"/>
  <meta name=\"description\" content=\"Don’t just report theft, but prevent it with our help. A San Antonio based Security Company offering a wide range of service and products. \"/>
  <meta name=\"keywords\" content=\"Video Surveillance, Security, San Antonio Surveillance, 24 hour recording, monitoring 24 hours, Motion Detectors, Security Cameras, Theft Prevention, Theft Reporting, Theft Break ins, IR cameras, IR Flood lighting, Long range cameras, PTZ cameras, Passive IR motion detection\"/>
  <link rel=\"shortcut icon\" href=\"images/favicon.ico?95697637\"/>
  <title>Alarms Embed</title>
 </head>
 <body style=\"margin:0px\">
  " . implode( "", $output ) . "
 </body>
</html>";

echo $html;

?>