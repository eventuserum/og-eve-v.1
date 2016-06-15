<?php
require(posts/calendar/calendar-header.php);
if($function) {
 switch($function) {
  case 'login':
    if(($_GET['user'] == $temp_user) && ($_GET['pw'] == $temp_pw)) {
      $_SESSION['user'] = $_GET['user'];
      $_SESSION['pw'] = $_GET['pw'];
      header("Location: http://www.eventuserum.com");
    } else if(($_GET['user'] == $temp_admin) && ($_GET['pw'] == $temp_admin_pw)) {
      $_SESSION['user'] = $_GET['user'];
      $_SESSION['pw'] = $_GET['pw'];
      header("Location: http://http://www.eventuserum.com");
      $admin = 1;
    } else {
      $sys_msg = "Login Failed";
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

  $output[] = "<p>Logged in as {$_SESSION['user']} (<a href=\"http://www.eventuserum.com/calc/calc.php\">Logout</a>)</p>";
 }
}

 ?>
