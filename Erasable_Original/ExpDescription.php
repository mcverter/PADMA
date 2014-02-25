<?php

session_start();
$param=$_GET["param"];

//store experimentname into a session variable
$_SESSION['expName']=$param;


//get connection string variable from session
$db_UN=$_SESSION['un'];
$db_PASS=$_SESSION['pass'];
$db_DB=$_SESSION['db'];
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);

$role=$_SESSION['role'];
//REDIRECT THE USER TO LOGIN PAGE IF USER IS NOT ADMINISTRATOR OR RESEARCHER
if($role == "Administrator" || $role =="Researcher" || $role =="GeneralUser") {}
else
{
 	header("location: index.php"); 
}

$str ="SELECT EXP_MASTER.* FROM EXP_MASTER WHERE EXP_MASTER.EXP_NAME = '".$param."'";
$parsed = ociparse($db_conn, $str);
ociexecute($parsed);
$numrows = ocifetchstatement($parsed, $results);

echo "<table cellpadding='2' cellspacing='2' width='95%' align='center' style='font-family:Verdana; font-size:MEDIUM'>";
echo	"<tr>";
echo        "<td>";
echo        	$results["EXP_DESC"][0];                                                                                                                                                  
echo        "</td>";
echo    "</tr>";
echo "</table>";
oci_close($db_conn);
?>

