<?php
require_once (__DIR__ . "/../templates/DatabaseConnectionPage.php");
class InsertReferencePage extends DatabaseConnectionPage {
    function __construct() {
      parent::__construct();
    }
    function print_content() {

	$db_conn = $this->db_conn;
        echo <<<EOT

<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>

    <form   action="insertReference.php" method="POST">
      <table class="headerImage"></table>
      <td ><h2><font color="#ffffff">Confirmation...</font></h2></td>
EOT;
	insert_reference($db_conn);
}









