<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/25/14
 * Time: 12:40 PM
 */

class WebView {
    private $control_function;

    public function __construct() {
        $this->control_function = new ControlFunctions();
    }

    public function display() {
        show_header();
        show_content();
        show_footer();
    }

}
?>

/*
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

*/