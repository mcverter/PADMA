<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');
require_once (__DIR__ . "/../functions/db_ReadFunctions.php");

class ExperimentDescriptionPage extends DatabaseConnectionPage {
    function __construct() {
        parent::__construct();
        check_role('a');
    }

    function print_content() {
      $db_conn = $this->db_conn;
      read_experiment_description($db_conn); 
    }
?>
 
 
 
 
 
 
 
 
 
 
 
 
