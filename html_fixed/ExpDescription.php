<?php
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();

$param=$_GET["param"];
//store experimentname into a session variable
$_POST['expName']=$param;
$str ="SELECT EXP_MASTER.* FROM EXP_MASTER WHERE EXP_MASTER.EXP_NAME = '".$param."'";

$parsed = ociparse($db_conn, $str);
ociexecute($parsed);
$numrows = ocifetchstatement($parsed, $results);


echo        	$results["EXP_DESC"][0];
oci_close($db_conn);
?>

 
 
 
 
 
 
 
 
 
 
 
 
 
