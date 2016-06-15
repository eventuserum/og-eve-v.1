<?php
$url = 'http://agency.governmentjobs.com/sanantoniotx/default.cfm?action=viewclassspec&ClassSpecID=828399';
$output = file_get_contents($url);


$html = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Eventuserum|Jobs?</title>
  <link rel=\"shortcut icon\" href=\"/assets/img/favicon.ico\" type=\"image/x-icon\"/>
  <link rel=\"shortcut icon\" href=\"/assets/img/favicon.ico\" type=\"image/x-icon\"/>
</head>
<body>
<h1><a href="/">Home</a></h1>
</body>';

echo $html;
echo $output;
?>
