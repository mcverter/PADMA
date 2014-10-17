<?php

require_once( __DIR__ . "/../functions/DBFunctions.php");

$userid = $_POST['userid'];
$password = $_POST['password'];
$role = '';

$db_conn = dbFn::connect_to_db();
$stored_proc_statement = 'BEGIN LOGIN(:PARAM_USERNAME,:PARAM_PASSWORD,:PARAM_ROLE); END;';
$stored_proc_statement = oci_parse($db_conn,$stored_proc_statement);

oci_bind_by_name($stored_proc_statement,":PARAM_USERNAME",strtoupper($userid),15);
oci_bind_by_name($stored_proc_statement,":PARAM_PASSWORD",sha1($password),250);
oci_bind_by_name($stored_proc_statement,":PARAM_ROLE",$role,30);
$execute=oci_execute($stored_proc_statement);


$_SESSION['role']=$role;
$_SESSION['userid']=ucfirst($userid);

/**

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
?>

 */
