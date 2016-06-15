<?php

// alarms.php

$js[] = "<script type=\"text/javascript\" src=\"js/alarms.js\"></script>";
$js[] = "<script type=\"text/javascript\">window.onload = init();</script>";

//sidebar

//system hierarchy
 
$system_dir = "/home3/cpurkiss/public_html/monitoring/systems/";

$files = array();
//display sidebar profiles 

if(is_dir($system_dir)) {
 if($dh = opendir($system_dir)) {
  while(($file = readdir($dh)) !== false) {
   if( ($file !== ".") && ($file !== "..") ) {
    if(filetype($system_dir . $file) !== "dir") {
     $file_content = file_get_contents(($system_dir . $file));
      
     $temp_parts = explode( "\n", $file_content );
      
     $file_parameters = array();
      
     foreach($temp_parts as $part) {
      $setting = explode( " ", $part );
      if($setting[0] && $setting[1]) {
       $param = array_shift($setting);
       if($param == "device") {
        if(!array_key_exists( "device", $file_parameters ) ) {
       	 $file_parameters['device'] = array();
       	}
       	$port = array_shift($setting);
       	$file_parameters['device'][] = array( "port" => $port, "name" => implode( " ", $setting ) );
       } else {
        $value = implode( " ", $setting );
        $file_parameters[$param] = $value;
       }
      }
     }
      
     if(array_key_exists( 'id', $file_parameters)) {
      if( $file_parameters['id'] > $system_id_last ) {
       $system_id_last = $file_parameters['id'];
      }
      $files[$file_parameters['customer']] = $file_parameters;
      $files[$file_parameters['customer']]['filename'] = $files;
     }
    }
   }
  }
  closedir($dh);
 }
}

if(count($files)) { 
 ksort($files); 
  
 $show_systems = "";
 
//create sidebar square link control
 
 $incontrol_aliases = array();
 
 foreach( $files as $system ) {
  /*$show_systems .= "<a style=\"cursor:pointer\" onClick=\"\">
  <div id=\"snapview_system{$system['id']}\" style=\"float:left; position:relative; width:10px; padding-right:12px; padding-top:2px; padding-bottom:7px\">►</div>
</a>";*/
  $show_systems .= "<a style=\"cursor:pointer\" onClick=\"expand({$system['id']})\">
  <div id=\"expand_system{$system['id']}\" style=\"float:left; position:relative; border:1px solid #000; width:10px; padding-left:7px; padding-right:7px; padding-top:2px\">-</div>
</a>";
  $show_systems .= "<div style=\"float:left; position:relative; padding-left:10px; width:150px; text-align:left\">{$system['customer']}</div>";
  
  $show_systems .= "<div id=\"devices_system{$system['id']}\" style=\"float:left; position:relative; width:200px; margin-bottom:10px; height:auto; overflow:hidden\">";
  if($system['device']) {
   foreach($system['device'] as $device ) {
   
    if( ($device['port'] == "83") || ($device['port'] == "84") || ($device['port'] == "81") && ($device['name'] != "DVR") ) {
     $snapshow = "<a style=\"padding-left:10px; cursor:pointer\" onClick=\"snapview('{$system['domain']}:{$device['port']}')\">►</a>";
    } else {
     $snapshow = "";
    }
    
    $show_systems .= "<div style=\"float:left; position:relative; padding-left:37px; width:170px; text-align:left\">
     <a href=\"http://{$system['domain']}:{$device['port']}\" target=\"_blank\">{$device['name']}</a>
     {$snapshow}
    </div>";
   }
  }
  $show_systems .= "</div>";
  
  $parts_one = explode( "system", $system['domain'] );
  $parts_two = explode( ".", $parts_one[1] );
  $alias_id = $parts_two[0];
  $incontrol_aliases["sys" . $alias_id] = $system['customer'];
 }
 
 $systems_sidebar = "<div style=\"float:left; position:relative; width:220px; padding-right:20px\">" . $show_systems . "</div>";
} else {
 $systems_sidebar = "";
}

//alerts (notices)

$alert_dir = "/home3/cpurkiss/public_html/monitoring/alerts/";
$alerts = array();

if(is_dir($alert_dir)) {
 if($dh = opendir($alert_dir)) {
  while(($file = readdir($dh)) !== false) {
   if( ($file !== ".") && ($file !== "..") ) {
    if(filetype($alert_dir . $file) !== "dir") {
     $file_content = file_get_contents(($alert_dir . $file));
     
     //$temp_parts = explode( "InControl", $file_content );
     
     //$sub_parts = explode( "\n", $temp_parts[1] );
     
     $new_alert = array();
     
     //from
     $sub_parts = explode( "From: ", $file_content );
     $temp_parts = explode( "\n", $sub_parts[1] );
     $from = strip_tags( $temp_parts[0], "<a>" );
     
     $new_alert['from'] = $from;
     
     //subject
     $sub_parts = explode( "Subject: ", $file_content );
     $temp_parts = explode( "\n", $sub_parts[1] );
     $subject = strip_tags( ($temp_parts[0] . $temp_parts[1]), "<a>" );
     
     $new_alert['subject'] = $subject;
     
     //body
     $sub_parts = explode( "Content-Type: text/html", $file_content );
     $temp_parts = explode( "\n", $sub_parts[1] );
     array_shift($temp_parts);
     array_shift($temp_parts);
     array_shift($temp_parts);
     array_shift($temp_parts);
     $body = implode( "", $temp_parts );
     $body = strip_tags( $body, "<a>" );
     
     $new_alert['body'] = $body;
     
     $last_mod = filemtime($alert_dir . $file);
     
     $alerts[$last_mod] = $new_alert;
    }
   }
  }
  closedir($dh);
 }
}

krsort($alerts);

$show_alerts = array();

$show_alerts[] = "<p>Notices</p>";

//$output[] = implode( "<br /><br />", $alerts );

$show_limit = 3;
$shown = 0;
foreach( $alerts as $alert ) {
 if($shown >= $show_limit) { 
  break; 
 } else {
 
  $alert_system = "";
  
  /*if($incontrol_aliases) {
   $aliases = array_keys($incontrol_aliases);
   foreach($aliases as $alias) {
    if(substr_count( $alert['body'], ($alias . "<") )) {
     $alert_system = $incontrol_aliases[$alias];
    }
   }
  }*/
  
  $show_alerts[] = "{$alert['from']}: <b>{$alert_system}</b> {$alert['body']}<br />";
 }
 $shown++;
}

//alarms

/*$dir = "/home3/cpurkiss/motionalarm/Incoming_alarm/";

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
 
 $output[] = "<p>Found " . count($files) . " files. Moving " . count($old) . " files to archive.<p>";
 
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
 
 //show
 
 //images
 
 $show_images = array();
 foreach($save as $file) {
  //$output[] = "filename: {$file['name']} : filetype: {$file['type']} last modified: " . date ("F d Y H:i:s.", $file['last_mod']) . "<br />";
  $show_images[] = "<div style=\"position:relative; float:left; width:325px; height:300px; text-align:left\"><span style=\"overflow:hidden; font-size:8pt\">{$file['name']}</span><br /><a href=\"image.php?p=" . $file['dir'] . $file['name'] . "\" target=\"_blank\"><img style=\"border:0; max-width:325px\" src=\"image.php?p=" . $file['dir'] . $file['name'] . "\" /></a></div>";
 }
 
 $output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1000px\">" . implode( "\n", $show_images ) . "</div>";
 
 if(count($old) > 0) {
  $output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1300px; color:gray\">" . implode ( "<br />", $move_log ) . "</div>";
 }
 
} else {
 $output[] = "Not a directory.";
}*/

//controls the output of the 3x notices above the site
$output[] = "<div style=\"position:relative; float:left; width:1400px; text-align:left; font-size:11pt; color:gray; margin-bottom:20px\">" . implode( "", $show_alerts ) . "</div>";

//SnapView player output 307-318
$output[] = "<div style=\"float:left; position:relative; width:400px; text-align:left\"><div style=\"float:left; position:relative; margin-bottom:10px\">Snapview</div>
 <div style=\"float:left; position:relative; width:375px; margin-bottom:25px\">
  <a style=\"cursor:pointer\" onClick=\"change_channel(0)\"><div id=\"snapview_ch0\" style=\"float:left; position:relative; width:25px; border:2px solid gray; height:20px; margin-bottom:10px\"></div></a>
  <a style=\"cursor:pointer\" onClick=\"change_channel(1)\"><div id=\"snapview_ch1\" style=\"float:left; position:relative; width:25px; border:1px solid gray; height:20px; margin-bottom:10px; margin-left:10px\"></div></a>
  <a style=\"cursor:pointer\" onClick=\"change_channel(2)\"><div id=\"snapview_ch2\" style=\"float:left; position:relative; width:25px; border:1px solid gray; height:20px; margin-bottom:10px; margin-left:10px\"></div></a>
  <a style=\"cursor:pointer\" onClick=\"change_channel(3)\"><div id=\"snapview_ch3\" style=\"float:left; position:relative; width:25px; border:1px solid gray; height:20px; margin-bottom:10px; margin-left:10px\"></div></a>
  <div id=\"snapview\" style=\"float:left; position:relative; width:375px; border:1px solid gray; height:250px\"></div>
  <a style=\"cursor:pointer\" onClick=\"snapview_play()\"><div id=\"snapview_play\" style=\"float:left; color:green; position:relative; margin-top:15px; font-size:36pt; width:100px; text-align:left;\">►</div></a>
 </div>
 " . $systems_sidebar . "
</div>";
$output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1000px; font-size:18pt; text-align:left\">Incoming Alarms<br /><iframe style=\"float:left; position:relative; border:0px\" src=\"http://www.scsconcepts.com/monitoring/alarms_embed.php\" width=\"1000\" height=\"1800\"></iframe></div>";

?>
