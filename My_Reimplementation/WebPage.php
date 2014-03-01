<?php

require_once("Controls.php");
class WebPage {
    public    $title;
    public    $js;
    public  $authorization;
    public  $content;

    public function prepare() {
        initialize_session();
    }

    public function display_page() {
        $this->prepare();

        $title = $this->title;
        $js = $this->js;
        $content = $this->content;
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
        echo $content;
        require("footer.php");

            echo <<< EOT
    </head>
    <body>
EOT;

    }

}

?>


