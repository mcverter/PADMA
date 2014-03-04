<?php
require_once("Controls.php");
require_once("MainPage.php");

if (!isset($_POST['userid']) ||
    !isset($_POST['Password1'])) {
// redirect
}
else {
    $db_conn = connect_to_db();

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

    error_log("Role is " . $role);

    if ($role=="GeneralUser") {
        $mp = new MainPage("User Main Page", "u");
        $mp->display_page();
    }
    else if ($role=="Administrator") {
        $mp = new MainPage("Administrator Main Page", "a");
        $mp->display_page();

    }
    else if ($role == "Researcher") {
        $mp = new MainPage("Researcher Main Page", "r");
        $mp->display_page();
    }
    else {
        header( 'Location: index.php' ) ;
    }

}

?>

