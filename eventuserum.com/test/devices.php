<?php

// devices.php

$system_id = $_GET['id'];

$dir = "/home3/cpurkiss/public_html/monitoring/systems/";
$file = "system" . $system_id . ".txt";

$system = array();

if(file_exists($dir . $file)) {
 $file_content = file_get_contents($dir . $file);
 
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
  $system  = $file_parameters;
  $system ['filename'] = $file;
 }
 
} else {
 $output[] = "File not found.";
}

$show_systems = array();

if(count($system)) {
 $show_systems[] = "<form action=\"http://www.scsconcepts.com/monitoring/index.php?a=devices&id={$system['id']}\" method=\"post\">
 <table style=\"width:600px; margin-top:25px\" align=\"center\" border=\"1\" cellpadding=\"1\">
  <tr><td style=\"width:200px; text-align:left\">Customer</td><td style=\"width:400px; text-align:left\" colspan=\"2\">
   <input style=\"width:400px\" type=\"text\" name=\"customer\" value=\"{$system['customer']}\" required>
  </td></tr>
  <tr><td style=\"width:200px; text-align:left\">Domain</td><td style=\"width:400px; text-align:left\" colspan=\"2\">
   <input style=\"width:400px\" type=\"text\" name=\"domain\" value=\"{$system['domain']}\" required>
   </td></tr>";
 
 if($system['device']) {
  $counter = 1;
  foreach($system['device'] as $device ) {
   $show_systems[] = "<tr><td style=\"width:200px; text-align:left\"><input style=\"width:200px\" type=\"text\" name=\"{$counter}_name\" value=\"{$device['name']}\" required></td><td style=\"width:300px; text-align:left\">Port: <input style=\"width:50px\" type=\"text\" name=\"{$counter}_port\" value=\"{$device['port']}\" required></td><td style=\"width:100px; text-align:left\"><a href=\"http://www.scsconcepts.com/monitoring?a=devices&id={$system['id']}&f=del&device={$device['name']}&c=0\">Del</a></td></tr>";
   $counter++;
  }
 } else {
  $show_systems[] = "<tr><td style=\"width:600px; text-align:left\" colspan=\"3\">No devices</td></tr>";
 }
 $show_systems[] = "<tr><td style=\"text-align:right\" colspan=\"3\"><input type=\"hidden\" name=\"f\" value=\"edit_system\"><input type=\"submit\" value=\"save\"></td></tr></table></form>";
 
 //functions
 
 if($_POST['f']) {
  $function = $_POST['f'];
 } else if($_GET['f']) {
  $function = $_GET['f'];
 }
 
 if($function ) {
  switch($function ) {
   case 'add_device':
    if( $_POST['name'] && $_POST['port'] ) {
     $system_content = "id {$system['id']}\n";
     $system_content .= "customer {$system['customer']}\n";
     $system_content .= "domain {$system['domain']}\n";
     
     if($system['device']) {
      foreach($system['device'] as $device) {
       $system_content .= "device {$device['port']} {$device['name']}\n";
      }
     }
     
     $system_content .= "device {$_POST['port']} {$_POST['name']}\n";
    
     //$output[] = $system_content;
     
     $system_location = $dir . $file;
   
     $new_system_fh = fopen($system_location, "w");
     fwrite($new_system_fh, $system_content);
     fclose($new_system_fh);
     
     header("Location: http://www.scsconcepts.com/monitoring/?a=devices&id={$system['id']}");
    }
   break;
   
    case 'del':
    if(!$_GET['c']) {
     $sys_msg = "Delete <b>" . $_GET['device'] . "</b>? <a href=\"http://www.scsconcepts.com/monitoring?a=devices&id={$system['id']}&f=del&device={$_GET['device']}&c=1\">Delete</a>";
    } else {
     
     $system_content = "id {$system['id']}\n";
     $system_content .= "customer {$system['customer']}\n";
     $system_content .= "domain {$system['domain']}\n";
     
     if($system['device']) {
      foreach($system['device'] as $device) {
       if($device['name'] != $_GET['device']) {
        $system_content .= "device {$device['port']} {$device['name']}\n";
       }
      }
     }
     
     $system_location = $dir . $file;
   
     $new_system_fh = fopen($system_location, "w");
     fwrite($new_system_fh, $system_content);
     fclose($new_system_fh);
     
     header("Location: http://www.scsconcepts.com/monitoring/?a=devices&id={$system['id']}&msg=Device deleted");
    }
   break;
   
   case 'edit_system':
    if( $_POST['customer'] && $_POST['domain'] ) {
     $system_content = "id {$system['id']}\n";
     $system_content.= "customer {$_POST['customer']}\n";
     $system_content.= "domain {$_POST['domain']}\n";
     
     if($system['device']) {
      $counter = 1;
      foreach($system['device'] as $device) {
       if($_POST[$counter . '_name']) {
       	$system_content.= "device " . $_POST[$counter . '_port'] . " " . $_POST[$counter . '_name'] . "\n";
      	}
      	$counter++;
      }
     }
     
     $system_location = $dir . $file;
   
     $new_system_fh = fopen($system_location, "w");
     fwrite($new_system_fh, $system_content);
     fclose($new_system_fh);
     
     header("Location: http://www.scsconcepts.com/monitoring/?a=devices&id={$system['id']}&msg=System updated");
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
 
 //add new device
 $output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1300px; margin-top:25px; margin-bottom:15px; text-align:center\">add device</div>";
 $output[] = "<form action=\"http://www.scsconcepts.com/monitoring/index.php?a=devices&id={$system['id']}\" method=\"post\">
  <table align=\"center\" border=\"0\" cellpadding=\"1\">
   <tr><td style=\"width:100px; text-align:right; padding-right:15px\">Name</td><td style=\"text-align:right\"><input style=\"width:250px\" type=\"text\" name=\"name\" required></td></tr>
   <tr><td style=\"width:100px; text-align:right; padding-right:15px\">Port</td><td style=\"text-align:right\"><input style=\"width:250px\" type=\"text\" name=\"port\" required></td></tr>
   <tr><td></td><td style=\"text-align:right\"><input type=\"hidden\" name=\"f\" value=\"add_device\"><input type=\"submit\" value=\"add\"></td></tr>
  </table>
 </form>";
}

?>