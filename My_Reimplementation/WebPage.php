<?php

require_once("Controls.php");
abstract class WebPage {
    public $title;


    protected  function set_title($title){
        $this->title = $title;
    }
    public function prepare() {
        initialize_session();
    }

    public function display_page() {
        $this->prepare();
        $this->html_start();
        $this->content();
        $this->html_end();
    	$this->cleanup();
    }


    function add_js() {}

    function cleanup() {}

    function header_nav() {
        require("header.php");
    }

    function footer_nav() {
        require("footer.php");
    }


    function html_start() {
        $title = $this->title;

        echo <<< EOT
<!DOCTYPE html>
<html>
  <head>
    <title> PADMA: $title </title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta charset="UTF-8">
EOT;

        $this->add_js();
        echo <<< EOT
    </head>
    <body>
EOT;
        $this->header_nav();
    }

    function html_end() {
        $this->footer_nav();
        echo <<< EOT
    </head>
    <body>
EOT;

    }

    function content() {

    }



}

?>


