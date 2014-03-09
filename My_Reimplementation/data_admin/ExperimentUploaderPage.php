<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');

class ExperimentUploaderPage extends DatabaseConnectionPage {
    function __construct() {
        check_role('ar');
    }

    function print_content() {

        $db_conn = $this->db_conn;
	create_experiment($db_conn);
    }
?>
 
 
 
 
 
 
 
 
 
 
