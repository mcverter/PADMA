<?php

function read_researcher_experiments(){}

function read_all_experiments() {
  }

function read_login_user($db_conn) {
    if (isset($_POST['userid']) &&
        isset($_POST['Password1'])) {

        $userid = $_POST['userid'];
        $password=$_POST['Password1'];
        $role="";

        // hash the password
        $hashedPassword = sha1($password);
        $modifiedUserID=strtoupper($userid);

        //insert all information to database
        $stmt = 'BEGIN LOGIN(:PARAM_USERNAME,:PARAM_PASSWORD,:PARAM_ROLE); END;';
        $stmt = oci_parse($db_conn,$stmt);
        //  Bind the input parameter
        oci_bind_by_name($stmt,":PARAM_USERNAME",$modifiedUserID,15);
        oci_bind_by_name($stmt,":PARAM_PASSWORD",$hashedPassword,250);
        oci_bind_by_name($stmt,":PARAM_ROLE",$role,30);

        $execute=oci_execute($stmt);

        $_SESSION['role']=$role;
        $_SESSION['userid']=$modifiedUserID;

    }
}
function read_all_countries($db_conn) {
    $cmdCountry = "select country,countryid from country order by countryid";
    $parsed = ociparse($db_conn, $cmdCountry);
    ociexecute($parsed);
    $totalCountry = ocifetchstatement($parsed, $results);

    for ($i=0 ; $i < $totalCountry; $i++) {
        echo "<option value=" . $results["COUNTRYID"][$i] . ">" . $results["COUNTRY"][$i] . "</option>";
    }
    oci_free_statement($parsed);

}

function read_experiment_description($db_conn) {
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

?>