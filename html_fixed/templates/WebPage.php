<?
public class WebPage {
ControlFunctions  $control_functions;


public __construct() {
ControlFunctions = new ControlFunctions
}

function header() {
    insert("../widgets/header.php");
}

function html_start_head($title) {
    echo << EOT
    <!DOCTYPE html>
<html>
  <head>
    <title>PADMA: $title </title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta charset="UTF-8">
    <script src="js/prototype.js"></script>
    <script src="js/modalPopup.js"></script>
  </head>

    EOT;
}


?>