<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
//include the header page
include("header.php");
//start session
session_start();
$maxExecutionTime=6000;
set_time_limit ( $maxExecutionTime );

$role=$_SESSION['role'];
//REDIRECT THE USER TO LOGIN PAGE IF USER IS NOT ADMINISTRATOR OR RESEARCHER
if($role == "Administrator" || $role =="Researcher") {}
else
{
 	header("location: index.php"); 
}
?>

<head>

</head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">
<?php
	if ($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
		{
			echo "<table width='90%' align='center' cellpadding='0'  cellspacing='0' style='font-family:Verdana; font-size:small; font-weight:bold'>";
			echo	"<tr>";
            echo		"<td align='right' valign='center'>";
			echo			"<a title='back' href='DataManagement.php'>Back to Data Management Page</a> <br/>";
			echo		"</td>";
			echo	"</tr>";
			echo "</table>";    
		}
	else
		{
			echo "&nbsp;<br>";											
		}
?>  
	<br><br><br>
	<form   action="insertReference.php" method="POST">
	<table width="100%">
		<tr>
			<td style="width:20%">&nbsp;</td>
			<td style="width:60%">
				<table width="100%" border="1" style="border-collapse:collapse; border-color:#4682b4; border-style:solid">
					<tr>
						<td>
							<table width="100%" style="background-image:url('images/Tblheader.png');color:#ffffff" cellpadding="4"  cellspacing="0">
								<tr>
									<td ><b><font color="#ffffff">Confirmation...</font></b></td>								
								</tr>
							</table>
							
							<br><br><br>
							<table cellpadding="5" cellspacing="0" width="100%">
								<tr>
									<td style="width:20%" align="right" >&nbsp;</td>
									<td style="width:80%" align="left" valign="bottom">
										<?php
											//Get sesisson veriable to connect to database
											$db_UN=$_SESSION['un'];
											$db_PASS=$_SESSION['pass'];
											$db_DB=$_SESSION['db'];											

											//connection to the database
											$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
											if (! $db_conn)
											{
												$e = oci_error();
 												print htmlentities($e['message']);
 												exit;

											}
											$prob_id=array();
											$exp_name=array();
											$catg=array();
											$spec=array();
											$subj=array();
											$reg_val=array();
											$open=array();												
											
											$prob_id=$_SESSION['prob_id'];
											$exp_name=$_SESSION['exp_name'];
											$catg=$_SESSION['catg'];
											$spec=$_SESSION['spec'];
											$subj=$_SESSION['subj'];
											$reg_val=$_SESSION['reg_val'];
											$open=$_SESSION['open'];
											$hour=$_SESSION['hour'];
											$noError=$_SESSION['noError'];
											$userid=$_SESSION['userid'];
											$publish=$_SESSION['publish'];

											$restricted='1';
											if($publish=="YES")
												$restricted='0';
											elseif($publish=="NO")
												$restricted='1';
											
											

											//insert data to Experiment Table
											$str = "";
											$date=date("m/d/y");
											$EXPERIMENT_ERROR=false;
											$EXPERIMENT_ROWCOUNT=0;
											$exp_desc="Not Available";
											$recNum=count($prob_id);
											//----------------------Insert EXPERIMENT Data----------------------------------------
											for($i=0;$i<$recNum;$i++)
											{
												
												$EXPERIMENT_ROWCOUNT++;
												$str ="insert into EXPERIMENT VALUES('$prob_id[$i]', '$exp_name[$i]', '$catg[$i]' ,'$spec[$i]','$subj[$i]','$reg_val[$i]','$open[$i]','$userid', '$date','$restricted','$hour[$i]')";
												//echo $str . "<br>";
												$parsed = ociparse($db_conn, $str);
												if(! ociexecute($parsed))
												{
													$EXPERIMENT_ERROR=true;
													break;
												}
												if($EXPERIMENT_ROWCOUNT==($recNum-2))
												{
													$strSQL ="insert into EXP_MASTER VALUES('$exp_name[$i]', '$exp_desc','$userid', '$date','$restricted',$recNum)";
													//echo $str . "<br>";
													$parsed = ociparse($db_conn, $strSQL);
													if(! ociexecute($parsed))
													{
														$EXPERIMENT_ERROR=true;
														break;
													}
												}
												//$numrows = ocifetchstatement($parsed, $results);
												//echo $str . "<br>";
											}
											if($EXPERIMENT_ERROR)
											{
												$strDel ="delete from EXPERIMENT where EXP_NAME='".$exp_name[0]."'";					
												$parsed = ociparse($db_conn, $strDel);
												ociexecute($parsed);

												$strDel ="delete from EXP_MASTER where EXP_NAME='".$exp_name[0]."'";					
												$parsed = ociparse($db_conn, $strDel);
												ociexecute($parsed);

												exit("ERROR! Inserting Record# $EXPERIMENT_ROWCOUNT Into EXPERIMENT Table");
											}
										echo "<b>Experiment $exp_name[0] Inserted SUCCESSFULLY. </b>";
										?> 
									</TD>										
									<td style="width:20%" align="right">&nbsp;</td>
									<td> <p><div id="txtHint"><b></b></div></p> </td>
								</tr>
							</table>
							<br><br><br>
						</td>
					</tr>
				</table>
			<td style="width:20%">&nbsp;</td>
		</tr>
	</table>
</form>
<?php
unset($_SESSION['prob_id']);
unset($_SESSION['exp_name']);
unset($_SESSION['catg']);
unset($_SESSION['spec']);
unset($_SESSION['subj']);
unset($_SESSION['reg_val']);
unset($_SESSION['open']);
unset($_SESSION['noError']);
 //close database connection
 oci_close($db_conn);
 ?>
</body>
</html>

