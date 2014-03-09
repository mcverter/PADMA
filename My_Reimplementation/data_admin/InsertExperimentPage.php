<?php
require_once (__DIR__ . "/../templates/DatabaseConnectionPage.php");
require_once (__DIR__ . "/../templates/functions/db_CreateFunctions.php");

class InsertExperimentPage extends DatabaseConnectionPage {
    function __construct() {
      parent::__construct();
    }
    function print_content() {
      $db_conn = $this->db_conn;
      insert_experiment($db_conn);
    }
      
}
 
 
 
 
 
 
 
