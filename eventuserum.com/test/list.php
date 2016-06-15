<?php

// list.php

$links = array();
$links[] = array( "type" => "new", "title" => "Abbey Residential 1 Channel 1", "config_port" => "83", "alarm_port" => "90", "link" => "http://scs-con-system14.from-tx.com" );
$links[] = array( "type" => "new", "title" => "Abbey Residential 1 Channel 2", "config_port" => "84", "alarm_port" => "90", "link" => "http://scs-con-system14.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Abbey Residential 2", "link" => "http://scs-con-system3.from-tx.com" );
$links[] = array( "type" => "new", "title" => "Abbey Residential 3 Channel 1", "config_port" => "83", "alarm_port" => "90", "link" => "http://scs-con-system20.from-tx.com" );
$links[] = array( "type" => "new", "title" => "Abbey Residential 3 Channel 2", "config_port" => "84", "alarm_port" => "90", "link" => "http://scs-con-system20.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Middleman", "link" => "http://scs-con-system6.from-tx.com" );
$links[] = array( "type" => "old", "title" => "SBS Alamo 1", "link" => "http://scs-con-system22.from-tx.com" );
$links[] = array( "type" => "old", "title" => "SBS Alamo 2", "link" => "http://scs-con-system17.from-tx.com" );
$links[] = array( "type" => "old", "title" => "CGI Georgetown 1", "link" => "http://scs-con-system9.from-tx.com" );
$links[] = array( "type" => "old", "title" => "CGI Georgetown 2", "link" => "http://scs-con-system10.from-tx.com" );
$links[] = array( "type" => "old", "title" => "CGI Georgetown 3", "link" => "http://scs-con-system15.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Capco Ingram 1", "link" => "http://scs-con-system1.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Capco Ingram 2", "link" => "http://scs-con-system13.from-tx.com" );
$links[] = array( "type" => "old", "title" => "SBS De Zavala", "link" => "http://scs-con-system24.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Wyatt Management", "link" => "http://scs-con-system11.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Crane New Braunfels 1", "link" => "http://scs-con-system7.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Crane New Braunfels 2", "link" => "http://scs-con-system8.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Turner Jefferson", "link" => "http://scs-con-system5.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Galaxy Corpus 1", "link" => "http://scs-con-system18.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Galaxy Corpus 2", "link" => "http://scs-con-system12.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Galaxy Corpus 3", "link" => "http://scs-con-system2.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Galaxy Lookout", "link" => "http://scs-con-system16.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Capco De Zavala 1", "link" => "http://scs-con-system23.from-tx.com" );
$links[] = array( "type" => "old", "title" => "Capco De Zavala 2", "link" => "http://scs-con-system21.from-tx.com" );
$links[] = array( "type" => "old", "title" => "RJ Allen 1", "link" => "http://scs-con-system26.from-tx.com" );
$links[] = array( "type" => "old", "title" => "RJ Allen 2", "link" => "http://scs-con-system19.from-tx.com" );
$links[] = array( "type" => "old", "title" => "RJ Allen 3", "link" => "http://scs-con-system4.from-tx.com" );

$link_table = "<table align=\"center\" border=\"1\" cellpadding=\"5\">";

foreach( $links as $link ) {
 if($link['type'] == "old") {
  $link_table .= "<tr><td style=\"width:200px\">{$link['title']}</td><td>ALARM</td><td><a href=\"{$link['link']}:81\" target=\"_blank\">CONFIG</a></td><td>DVR</td></tr>\n";
 } else {
  $link_table .= "<tr><td style=\"width:200px\">{$link['title']}</td><td><a href=\"{$link['link']}:{$link['alarm_port']}\" target=\"_blank\">ALARM</a></td><td><a href=\"{$link['link']}:{$link['config_port']}\" target=\"_blank\">CONFIG</a></td><td><a href=\"{$link['link']}:81\" target=\"_blank\">DVR</a></td></tr>\n";
 }
}
$link_table .= "</table>";

$output[] = $link_table;

?>