<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
//include the header page
include("header.php");
//start session
session_start();

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
			echo			"<a title='back' href='loaderStart.php'>Back to Reference Load Page</a> <br/>";
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


											//Directory location of the file that will be loaded
											$Version=$_REQUEST['version'] ;
											$directories="C:/inetpub/wwwroot/droso/";
											$file = $_REQUEST['uploadedfile'] ;
											$fileName=$directories . $file;   
											echo $fileName ."<br><br>";

											//---Veriable declaration to track the file that will be loaded
											$TotalRowToInsert =0;
											$TotalGoNumber=0;
											$noError=true;
											$parts=array();
											$goBioParts=array();
											$InsideGoBioParts=array();
											$GoBioFunction="";

											$PID=array();
											$cgNumber=array();
											$geneName=array();
											$fbgn=array();
											$index=0;

											$pidGo=array();
											$goBio=array();
											$pidGoIndex=0;
											$goBioIndex=0;

											//----Check if the file is in right format and how many rows are in the file
											$handle = fopen($fileName, "rb") or die("ERROR: opening file");
											//read the line with header
											$line_of_text = fgets($handle);

											while ((!feof($handle)) and ($noError))
											{
												$line_of_text = fgets($handle);
												$parts = explode(',', $line_of_text);
												$goBioLength=strlen(trim($parts[4]));												
												if(count($parts)< 5)
												{
													$noError=false;
													break;
												}
												else
												{
													$GoBioFunction=$parts[4];
													if(count($parts)>5)
													{
														for($i=5;$i<count($parts);$i++)
														{
															$GoBioFunction=$GoBioFunction . ',' .$parts[$i];
														}
													}
												}
												//create array to insert into database
												$PID[$index]=$parts[0];
												$cgNumber[$index]=$parts[1];
												$geneName[$index]=$parts[2];
												$fbgn[$index]=$parts[3];
												$index++;

												//Remove double quote from GoBiofunction
												$tempGoBioParts=explode('"',$GoBioFunction);
												
												$GoBioFunction=$tempGoBioParts[0];												
												if (count($tempGoBioParts)==3)
												{
													$GoBioFunction=$tempGoBioParts[1];
												}
												else if (count($tempGoBioParts) > 3)
												{
													$noError=false;
													break;
												}
												$goBioParts=explode('///',$GoBioFunction);
												//echo $GoBioFunction . "<br><br>";
												for ($i=0;$i<count($goBioParts);$i++)
												{
													//echo $goBioParts[$i]."<br><br>";
													$InsideGoBioParts=explode('//',$goBioParts[$i]);
													if(count($InsideGoBioParts) >1)
													{
														$TotalGoNumber++;	
														$pidGo[$pidGoIndex]=trim($parts[0]) . "//" . trim($InsideGoBioParts[0]);
														$goBio[$goBioIndex]=trim($InsideGoBioParts[0]) . "//" . trim($InsideGoBioParts[1]);
														$pidGoIndex++;
														$goBioIndex++;

													}
												}
												$GoBioFunction="";
												$TotalRowToInsert++;									
											}
											//close the file
											fclose($handle);
											//Check if the version exist into the database
											$numrows=0;
											$str = "SELECT  * FROM REFERENCE_MAIN  WHERE VERSION=$Version";
											$parsed = ociparse($db_conn, $str);
											ociexecute($parsed);        
											$numrows = ocifetchstatement($parsed, $results);
											if($noError)
											{
												if($numrows>0)
												{
													echo " Reference data for Version: $Version already in the system";
												}
												else
												{
													$uniquePidGo=array_unique($pidGo);
													$uniqueGoBio=array_unique($goBio);

													echo "Total Record: " . $TotalRowToInsert . "<br>";
													echo "Total Go: " . count($uniqueGoBio) . "<br><br>";
													echo " <b>Verification Complete</b><br><br>";
													$_SESSION['pid']=$PID;
													$_SESSION['cgNumber']=$cgNumber;
													$_SESSION['geneName']=$geneName;
													$_SESSION['fbgn']=$fbgn;
													$_SESSION['uniquePidGo']=$uniquePidGo;
													$_SESSION['uniqueGoBio']=$uniqueGoBio;
													$_SESSION['noError']=$noError;
													$_SESSION['Version']=$Version;
													echo "<input name='Button1' type='submit' value='Load Data' />";
												}
											}
											else
											{
												echo "File is not in Right format <br> Check Row# " . $TotalRowToInsert++ . " PID: " .$parts[0]; 
											}
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
 oci_close($db_conn);
 ?>
</body>
</html>

