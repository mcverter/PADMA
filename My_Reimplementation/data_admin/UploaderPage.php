<?php

require_once(__DIR__  . "/../templates/DatabaseConnectionPage.php");

class UploaderPage extends DatabaseConnectionPage {
    function __construct() {
        parent::__construct();
        check_role('ar');
        $this->title= " Upload ";
    }


    function print_content() {
      $db_conn = $this->db_conn;

       echo <<< EOT

    <form   action="insertReference.php" method="POST">
      <table class="headerImage">
	<b><font color="#ffffff">Confirmation...</font></b>
      </table>

EOT;

       upload($db_conn);


    }
}