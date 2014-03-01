<?php
include("utility.php");
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();

error_log("db conn is " . $db_conn);


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
  header( 'Location: UserMain.php' ) ;
}
else if ($role=="Administrator") {
  header( 'Location: AdminMain.php' ) ;
}
else if ($role == "Researcher") {
  header( 'Location: ResearcherMain.php' ) ;
}
else {
  header( 'Location: GuestMain.php' ) ;
}

?>

