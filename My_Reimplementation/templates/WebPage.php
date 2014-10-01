<?php

require_once(__DIR__ . "/../functions/PageControlFunctions.php");

require_once(__DIR__ . "/../components/HeaderMaker.php");
require_once(__DIR__ . "/../components/FooterMaker.php");
require_once(__DIR__ . "/../components/WidgetMaker.php");

abstract class WebPage {

    protected $title;
    protected $userid;
    protected $role;

     public function __construct() {
        initialize_session();
         $_SESSION['userid'] = 'akira';
         $_SESSION['role'] = 'Administrator';
         $this->userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";
         $this->role = isset($_SESSION['role']) ? $_SESSION['role'] : "";


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

        HeaderMaker::make_header();

        $this->print_content();

        FooterMaker::make_footer();
            echo <<< EOT
    </body>
    </html>
EOT;

    }

}

?>


