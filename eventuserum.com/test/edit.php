<?php

// edit.php

//find existing systems

$dir = "/home3/cpurkiss/public_html/monitoring/systems/";

if(!is_dir($dir )) {
 mkdir( $dir , 0777 );
}

$files = array();

$system_id_last = 0;

if(is_dir($dir)) {
 if($dh = opendir($dir)) {
   while(($file = readdir($dh)) !== false) {
    if( ($file !== ".") && ($file !== "..") ) {
     if(filetype($dir . $file) !== "dir") {
      $file_content = file_get_contents(($dir . $file));
      
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
       $files[$file_parameters['id']] = $file_parameters;
       $files[$file_parameters['id']]['filename'] = $file;
      }
     }
    }
   }
   closedir($dh);
 }
}

//display systems

if(count($files)) { krsort($files); }

$output[] = "<p>Found " . count($files) . " systems.";

$show_systems = array();

foreach( $files as $system ) {
 $show_systems[] = "<table style=\"width:800px; margin-top:25px\" align=\"center\" border=\"1\" cellpadding=\"1\">
  <tr><td style=\"width:300px; text-align:left\">{$system['customer']}</td>
  <td style=\"width:400px; text-align:left\">{$system['domain']}</td>
  <td style=\"width:50px; text-align:left\"><a href=\"http://www.scsconcepts.com/monitoring?a=devices&id={$system['id']}\">Edit</a></td>
  <td style=\"width:50px; text-align:left\"><a href=\"http://www.scsconcepts.com/monitoring?a=edit&f=del&id={$system['id']}&c=0\">Del</a></td></tr>";
 
 if($system['device']) {
  foreach($system['device'] as $device ) {
   $show_systems[] = "<tr><td style=\"width:300px; text-align:left\">{$device['name']}</td><td style=\"width:500px; text-align:left\" colspan=\"3\">Port: {$device['port']}</td></tr>";
  }
 } else {
  $show_systems[] = "<tr><td style=\"width:800px; text-align:left\" colspan=\"4\">No devices</td></tr>";
 }
 $show_systems[] = "</table>";
}



//functions

if($_POST['f']) {
 $function = $_POST['f'];
} else if($_GET['f']) {
 $function = $_GET['f'];
}

if($function ) {
 switch($function ) {
  case 'add_system':
   if( $_POST['customer'] && $_POST['domain'] ) {
    $new_system_id = $system_id_last + 1;
   
    while($files[$new_system_id]) {
     $new_system_id++;
    }
    
    $system_content = "id {$new_system_id}\n";
    $system_content .= "customer {$_POST['customer']}\n";
    $system_content .= "domain {$_POST['domain']}\n";
    
    $new_system_location = $dir . "system" . $new_system_id . ".txt";
   
    $new_system_fh = fopen($new_system_location, "w");
    fwrite($new_system_fh, $system_content);
    fclose($new_system_fh);
    
    header("Location: http://www.scsconcepts.com/monitoring/?a=edit");
   }
  break;
  
  case 'del':
   if(!$_GET['c']) {
    $sys_msg = "Delete <b>" . $files[$_GET['id']]['customer'] . "</b>? <a href=\"http://www.scsconcepts.com/monitoring?a=edit&f=del&id={$_GET['id']}&c=1\">Delete</a>";
   } else {
    
    unlink($dir . $files[$_GET['id']]['filename']);
    header("Location: http://www.scsconcepts.com/monitoring/?a=edit&msg=System deleted");
   }
  break;
 }
}

if($sys_msg) {
 $output[] = "<p>{$sys_msg}</p>";
} else if ($_GET['msg']) {
 $output[] = "<p>{$_GET['msg']}</p>";
}

$output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1300px; font-size:14pt; margin-bottom:15px; text-align:left\">" . implode( "", $show_systems) . "</div>";

//add new system
$output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1300px; margin-top:25px; margin-bottom:15px; text-align:center\">add system</div>";
$output[] = "<form action=\"http://www.scsconcepts.com/monitoring/index.php?a=edit\" method=\"post\">
 <table align=\"center\" border=\"0\" cellpadding=\"1\">
  <tr><td style=\"width:100px; text-align:right; padding-right:15px\">Customer</td><td style=\"text-align:right\"><input style=\"width:250px\" type=\"text\" name=\"customer\" required></td></tr>
  <tr><td style=\"width:100px; text-align:right; padding-right:15px\">Domain</td><td style=\"text-align:right\"><input style=\"width:250px\" type=\"text\" name=\"domain\" required></td></tr>
  <tr><td></td><td style=\"text-align:right\"><input type=\"hidden\" name=\"f\" value=\"add_system\"><input type=\"submit\" value=\"add\"></td></tr>
 </table>
</form>";

?>