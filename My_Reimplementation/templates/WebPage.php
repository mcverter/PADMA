<?php

require_once(__DIR__ . "/../functions/PageControlFunctions.php");

abstract class WebPage {

    protected $title;

     public function __construct() {
        initialize_session();
    }
    abstract public function print_content();


    public function print_js() {}
    public function cleanup() {}

    public function display_page() {
        $title = $this->title;
        echo <<< EOT
<!DOCTYPE html>
<html>
  <head>
    <title> PADMA: $title </title>
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <meta charset="UTF-8">
EOT;
    $this->print_js();

    echo <<< EOT

    </head>
    <body>
EOT;

        require(__DIR__ . "/../partials/header.php");

        $this->print_content();

        require(__DIR__ . "/../partials/footer.php");

            echo <<< EOT
    </body>
    </html>
EOT;

    }

}

?>


