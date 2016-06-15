<?php
require("header.php");

$function = $_GET['f'];
$area = $_GET['a'];

$output = array();

$js[] = "";

if($function) {
 switch($function) {
  case 'Login':
    if(($_GET['user'] == $temp_user) && ($_GET['pw'] == $temp_pw)) {
      $_SESSION['user'] = $_GET['user'];
      $_SESSION['pw'] = $_GET['pw'];
      header("Location: http://www.scsconcepts.com/monitoring/?a=alarms");
    } else if(($_GET['user'] == $temp_admin) && ($_GET['pw'] == $temp_admin_pw)) {
      $_SESSION['user'] = $_GET['user'];
      $_SESSION['pw'] = $_GET['pw'];
      header("Location: http://www.scsconcepts.com/monitoring/?a=alarms");
      $admin = 1;
    } else {
      $sys_msg = "Login failed";
    }
  break;
  
  case 'logout':
    unset($_SESSION['user']);
    unset($_SESSION['pw']);
  break;
 }
}

if($sys_msg) {
 $output[] = "<p>{$sys_msg}</p>";
}

$logged_in = 0;
if($_SESSION['user'] && $_SESSION['pw']) {
 if(($_SESSION['user'] == $temp_user) && ($_SESSION['pw'] == $temp_pw) || (($_SESSION['user'] == $temp_admin) && ($_SESSION['pw'] == $temp_admin_pw))) {
  $logged_in = 1;
  
  if($_SESSION['user'] == $temp_admin) { $admin = 1; }
  
  $output[] = "<p>Logged in as {$_SESSION['user']} (<a href=\"http://www.test.eventuserum.com/test?f=logout\">Logout</a>)</p>";
 }
}

$menu = array();
//$menu[] = "<a href=\"http://www.scsconcepts.com/monitoring?a=list\">list</a>";
$menu[] = "<a href=\"http://www.scsconcepts.com/monitoring?a=alarms\">alarms</a>";
$menu[] = "<a href=\"http://www.scsconcepts.com/monitoring?a=alerts\">notices</a>";
$menu[] = "<a href=\"http://www.scsconcepts.com/monitoring?a=archive\">archive</a>";

if($admin) {
 $menu[] = "<a href=\"http://www.scsconcepts.com/monitoring?a=edit\">edit</a>";
}

if($logged_in) {
 
 $output[] = "<div style=\"float:left; position:relative; margin:0 auto; width:1400px; font-size:20pt; margin-bottom:15px\">" . implode( " | ", $menu ) . "</div>";
 
 switch($area) {
  default:
  case 'edit':
   if($admin) {
    include("edit.php");
   } else {
    header("Location: http://www.scsconcepts.com/monitoring/?a=alarms");
   }
  break;
  case 'devices':
   if($admin) {
    include("devices.php");
   } else {
    header("Location: http://www.scsconcepts.com/monitoring/?a=alarms");
   }
  break;
  case 'list':
   include("list.php");
  break;
  case 'alarms':
   include("alarms.php");
  break;
  case 'alerts':
   include("alerts.php");
  break;
  case 'archive':
   include("archive.php");
  break;
 }
} else {
 $output[] = "<form action=\"http://www.scsconcepts.com/monitoring\" method=\"get\">
  <table align=\"center\" border=\"0\" cellpadding=\"1\">
   <tr><td style=\"width:100px; text-align:right; padding-right:15px\">User</td><td style=\"text-align:right\"><input style=\"width:150px\" type=\"text\" name=\"user\" required></td></tr>
   <tr><td style=\"width:100px; text-align:right; padding-right:15px\">Password</td><td style=\"text-align:right\"><input style=\"width:150px\" type=\"password\" name=\"pw\" required></td></tr>
   <tr><td></td><td style=\"text-align:right\"><input type=\"hidden\" name=\"f\" value=\"login\"><input type=\"submit\" value=\"login\"></td></tr>
  </table>
</form>";
}

/*if($area == "alarms") {
 $meta_refresh = "<meta http-equiv=\"refresh\" content=\"25\">";
} else {
 $meta_refresh = "";
}*/

$meta_refresh = "";

$html = "<!DOCTYPE html>
<html class=\"html\" lang=\"en-US\">
 <head>
  {$meta_refresh}
  <meta http-equiv=\"Content-type\" content=\"text/html;charset=UTF-8\"/>
  <meta name=\"description\" content=\"Don’t just report theft, but prevent it with our help. A San Antonio based Security Company offering a wide range of service and products. \"/>
  <meta name=\"keywords\" content=\"Video Surveillance, Security, San Antonio Surveillance, 24 hour recording, monitoring 24 hours, Motion Detectors, Security Cameras, Theft Prevention, Theft Reporting, Theft Break ins, IR cameras, IR Flood lighting, Long range cameras, PTZ cameras, Passive IR motion detection\"/>
  <link rel=\"shortcut icon\" href=\"images/favicon.ico?95697637\"/>
  <title>SCS Concepts | Monitoring</title>
 </head>
 <body>
  <div style=\"width:100%; text-align:center; margin-bottom:30px\"><img align=\"center\" src=\"http://www.scsconcepts.com/images/logo_web-crop-u1778.png\" border=\"0\" /></div>
  <div style=\"margin:0 auto; max-width:1400px; text-align:center\">" . implode( "", $output ) . "</div>
 </body>
 " . implode( "\n", $js ) . "
</html>";

echo $html;

?>