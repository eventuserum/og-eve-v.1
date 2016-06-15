<?php

//alerts.php

//alerts
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

$output[] = "<p>Found " . count($alerts) . " alerts.</p>";

//$output[] = implode( "<br /><br />", $alerts );

$show_limit = 50;
$shown = 0;
foreach( $alerts as $alert ) {
 if($shown >= $show_limit) { 
  break; 
 } else {
  $output[] = "{$alert['from']}: {$alert['body']}<br />";
 }
 $shown++;
}

?>