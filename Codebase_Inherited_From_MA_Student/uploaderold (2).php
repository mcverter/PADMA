<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
//include the header page
include("header.php");
//start session
session_start();

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
	<form   action="uploader.php" method="POST">
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

											//Directory location of the file that will be loaded
											$directories="C:/inetpub/wwwroot/droso/";
											$file = $_REQUEST['uploadedfile'] ;
											$fileName=$directories . $file;   
											echo $fileName ."<br><br>";

											//---Veriable declaration to track the file that will be loaded
											$TotalRowToInsert =0;
											$TotalGoNumber=0;
											$TotalBioFunction=0;
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

											//----Check if the file is in right format and how many rows are in the file
											$handle = fopen($fileName, "rb");
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
														//PID and GO number
														//echo $parts[0] . ": " . $InsideGoBioParts[0]."<br><br>";
														$TotalGoNumber++;
													for ($j=1;$j<count($InsideGoBioParts);$j++)
													{
														if(count($InsideGoBioParts) >1)
															//GO and biofunction
															//echo "\t" . $InsideGoBioParts[0] . ": " . $InsideGoBioParts[$j]."<br><br>";
															$TotalBioFunction++;
													}

												}
												$GoBioFunction="";
												$TotalRowToInsert++;									
											}
											//close the file
											fclose($handle);
											if($noError)
											{
												echo "Total Record: " . $TotalRowToInsert . "<br>";
												echo "Total Go: " . $TotalGoNumber . "<br>";
												echo "Total Bio Function: " . $TotalBioFunction . "<br>";
												//for ($i=0;$i<$index;$i++)
													//echo "PID: " . $PID[$i] . "<br>";

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
</body>
</html>

