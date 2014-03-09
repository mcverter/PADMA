<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');

class ExperimentDescriptionPage extends DatabaseConnectionPage {
    function __construct() {
        parent::__construct();
        check_role('a');
    }

    function print_content() {
        $db_conn = $this->db_conn;
        $param=0;

        //store experimentname into a session variable
        $_POST['expName']=$param;
        $str ="SELECT EXP_MASTER.* FROM EXP_MASTER WHERE EXP_MASTER.EXP_NAME = '".$param."'";

        $parsed = ociparse($db_conn, $str);
        ociexecute($parsed);
        $numrows = ocifetchstatement($parsed, $results);


        echo        	$results["EXP_DESC"][0];
        oci_close($db_conn);

    }
}

?>
 
 
 
 
 
 
 
 
 
 
 
 
