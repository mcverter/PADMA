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
if($role == "Administrator") {}
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


											$PID=array();
											$cgNumber=array();
											$geneName=array();
											$fbgn=array();
											$pidGo=array();
											$goBio=array();	
											
											$PID=$_SESSION['pid'];
											$cgNumber=$_SESSION['cgNumber'];
											$geneName=$_SESSION['geneName'];
											$fbgn=$_SESSION['fbgn'];
											$uniquePidGo=$_SESSION['uniquePidGo'];
											$uniqueGoBio=$_SESSION['uniqueGoBio'];
											$noError=$_SESSION['noError'];
											$userid=$_SESSION['userid'];
											$Version=$_SESSION['Version'];

											//insert data to REFERENCE_MAIN Table
											$str = "";
											$date=date("m/d/y");
											$REFERENCE_MAIN_ERROR=false;
											$REFERENCE_GO_ERROR=false;
											$REFERENCE_BIO_ERROR=false;

											$REFERENCE_MAIN_ROWCOUNT=0;
											$REFERENCE_GO_ROWCOUNT=0;
											$REFERENCE_BIO_ROWCOUNT=0;

											//----------------------Insert REFERENCE_MAIN Data----------------------------------------
											for($i=0;$i<count($PID);$i++)
											{
												$geneNameTrimmed=str_replace("'", "", $geneName[$i]);
												$REFERENCE_MAIN_ROWCOUNT++;
												$str ="insert into REFERENCE_MAIN VALUES('$PID[$i]', '$cgNumber[$i]', '$geneNameTrimmed' ,'$fbgn[$i]', '$Version', '$userid', '$date')";
												//echo $str . "<br>";
												$parsed = ociparse($db_conn, $str);
												if(! ociexecute($parsed))
												{
													$REFERENCE_MAIN_ERROR=true;
													break;
												}
												//$numrows = ocifetchstatement($parsed, $results);
												//echo $str . "<br>";
											}
											if($REFERENCE_MAIN_ERROR)
											{
												$strDel ="delete from REFERENCE_MAIN where VERSION='".$Version."'";										
												$parsed = ociparse($db_conn, $strDel);
												ociexecute($parsed);
												exit("ERROR! Inserting Record# $REFERENCE_MAIN_ROWCOUNT Into REFERENCE_MAIN Table");
											}
											
											//----------------------Insert REFERENCE_GO Data----------------------------------------
											foreach($uniquePidGo as $strItem)
											{ 
												$REFERENCE_GO_ROWCOUNT++;
												$uniquePidGoPart=explode("//",$strItem); 
												$str ="insert into REFERENCE_GO VALUES('$uniquePidGoPart[0]', '$uniquePidGoPart[1]', '$Version', '$userid', '$date')";

												//echo $str . "<br>";
												$parsed = ociparse($db_conn, $str);
												if(! ociexecute($parsed))
												{
													$REFERENCE_GO_ERROR=true;
													break;
												}
												//$numrows = ocifetchstatement($parsed, $results);
												//echo $str . "<br>";
											} 

											if($REFERENCE_GO_ERROR)
											{
												$strDel1 ="delete from REFERENCE_MAIN where VERSION='".$Version."'";	
												$strDel ="delete from REFERENCE_GO where VERSION='".$Version."'";	
												
												$parsed = ociparse($db_conn, $strDel);
												ociexecute($parsed);

												$parsed = ociparse($db_conn, $strDel1);
												ociexecute($parsed);

												exit("ERROR! Inserting Record# $REFERENCE_GO_ROWCOUNT Into REFERENCE_GO Table");
											}
											
											//----------------------Insert REFERENCE_BIO Data----------------------------------------
											foreach($uniqueGoBio as $strItem)
											{ 
												$REFERENCE_BIO_ROWCOUNT++;
												$uniqueGoBioPart=explode("//",$strItem);
												$uniqueGoBioPartTrimmed=str_replace("'", "",$uniqueGoBioPart[1]);
												$str ="insert into REFERENCE_BIO VALUES('$uniqueGoBioPart[0]', '$uniqueGoBioPartTrimmed', '$Version', '$userid', '$date')";
												
												$parsed = ociparse($db_conn, $str);
												if(! ociexecute($parsed))
												{
													$REFERENCE_BIO_ERROR=true;
													break;
												}
												//$numrows = ocifetchstatement($parsed, $results);
												//echo $str . "<br>";
											} 

											if($REFERENCE_BIO_ERROR)
											{
												$strDel1 ="delete from REFERENCE_MAIN where VERSION='".$Version."'";	
												$strDel2 ="delete from REFERENCE_GO where VERSION='".$Version."'";
												$strDel ="delete from REFERENCE_BIO where VERSION='".$Version."'";	
												
												$parsed = ociparse($db_conn, $strDel1);
												ociexecute($parsed);

												$parsed = ociparse($db_conn, $strDel2);
												ociexecute($parsed);

												$parsed = ociparse($db_conn, $strDel);
												ociexecute($parsed);

												exit("ERROR! Inserting Record# $REFERENCE_BIO_ROWCOUNT Into REFERENCE_BIO Table");
											}
												
										echo "<b>Reference Data Version $Version Inserted SUCCESSFULLY. </b>";
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
 //close database connection
 unset($_SESSION['pid']);
 unset($_SESSION['cgNumber']);
 unset($_SESSION['geneName']);
 unset($_SESSION['fbgn']);
 unset($_SESSION['uniquePidGo']);
 unset($_SESSION['uniqueGoBio']);
 unset($_SESSION['noError']);
 //unset($_SESSION['userid']);
 unset($_SESSION['Version']);
 oci_close($db_conn);
 ?>
</body>
</html>

