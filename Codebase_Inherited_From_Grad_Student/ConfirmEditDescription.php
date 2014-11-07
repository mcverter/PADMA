<?php
session_start();
$expName= isset($_POST['expName'])? urldecode($_POST['expName']) : "";
$desc= isset($_POST['desc'])? urldecode($_POST['desc']) : "";

if (empty($expName) || empty($desc)) {
 ECHO "<font color='#FF0000'>Error! Invalid input formation, contact PADMA administrator</font>";
 return;	
}
//get connection string variable from session
$db_UN=$_SESSION['un'];
$db_PASS=$_SESSION['pass'];
$db_DB=$_SESSION['db'];
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);

$role=$_SESSION['role'];
//REDIRECT THE USER TO LOGIN PAGE IF USER IS NOT ADMINISTRATOR OR RESEARCHER
if($role == "Administrator" || $role =="Researcher") {}
else
{
 	header("location: index.php"); 
}


$str ="update EXP_MASTER set EXP_DESC='".$desc."' WHERE EXP_MASTER.EXP_NAME = '".$expName."'";
$parsed = ociparse($db_conn, $str);
$execute=ociexecute($parsed);


echo "<table cellpadding='2' cellspacing='2' width='95%' align='center' style='font-family:Verdana; font-size:MEDIUM'>";
echo	"<tr>";
echo        "<td>";
//Check if the information is saved and show appropriate message
if($execute)
    {
		ECHO "<font color='#008000'>Description Saved</font>";		
	}
else
	{
		ECHO "<font color='#FF0000'>Error! Saving Description</font>";
	}                                                                                                                                                  
echo        "</td>";
echo    "</tr>";
echo "</table>";
oci_close($db_conn);
?>

