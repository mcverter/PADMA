<?php

require_once("Controls.php");
class WebPage {
    protected  $title;
    protected  $js;
    protected  $authorization;

    public function prepare() {
        initialize_session();
    }

    public function display_page() {
        $this->prepare();

        $title = $this->title;
        $js = $this->js;
        $content = $this->content
        echo <<< EOT
<!DOCTYPE html>
<html>
  <head>
    <title> PADMA: $title </title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta charset="UTF-8">
    $js
    </head>
    <body>
EOT;
        require("header.php");
        echo $this->content();
        require("footer.php");

            echo <<< EOT
    </head>
    <body>
EOT;

	$this->cleanup();
    }


    function add_js() {echo $js;}

    function cleanup() {}

    function header_nav() {
        require("header.php");
    }

    function footer_nav() {
        require("footer.php");
    }


    function html_start() {
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


