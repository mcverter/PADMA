<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
session_start();
//include the header page
include("header.php");

$maxExecutionTime=6000;
set_time_limit ( $maxExecutionTime );

//get session variabe
$db_UN=$_SESSION['un'];
$db_PASS=$_SESSION['pass'];
$db_DB=$_SESSION['db'];
$userid=strtoupper($_SESSION['userid']);

  
//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
if (! $db_conn)
{
	$e = oci_error();
 	print htmlentities($e['message']);
 	exit;

}

$role=$_SESSION['role'];
//REDIRECT THE USER TO LOGIN PAGE IF USER IS NOT ADMINISTRATOR OR RESEARCHER
if($role =="Researcher") {}
else
{
 	header("location: index.php"); 
}

//delete experiment when delete button is clicked
$exprimentName=$_POST['exp_name'];
$cmdstr = "delete from EXPERIMENT where EXP_NAME='".$exprimentName."'";
$cmdstr2 = "delete from EXP_MASTER where EXP_NAME='".$exprimentName."'";
$parsed = ociparse($db_conn, $cmdstr);
ociexecute($parsed);
$parsed = ociparse($db_conn, $cmdstr2);
ociexecute($parsed);

?>

<head>
<title></title>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana" >
<table cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr>
		<td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
    </tr>
    <tr>
		<td align="left">&nbsp;</td>
        <td align="right">&nbsp</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
        <td align="right">&nbsp</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
        <td align="right">&nbsp</td>
	</tr>
</table>

<form name="form1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<table cellpadding="0" cellspacing="0" width="100%" align="center">
		<tr>
			<td width="100%" align="center">
				<table width="60%" cellpadding="0" cellspacing="0" align="center">
					<tr>						
						<td align="right"><font color="#4682B4" size="2pt"><a href='DataManagement.php'><b>&lt;&lt;Back to Data Management</b></a> | <a title='logout' href='index.php'><b>Log Out</b></a></font>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<table cellpadding="0" cellspacing="0" width="100%" bgcolor="#F0FFF0">
									<tr>
										<td>
											<table cellpadding="0" cellspacing="0" width="100%" style="font-family:Verdana; font-size:small">
												<tr>
													<td align="right" width="30%">
														&nbsp;&nbsp;
                                                    </td>
                                                    <td width="40%" align="left"><br><br>
														<b>(Select an Experiment to delete)</b><br>
                                                        <?php                                                                            
															$cmdCountry = "select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='1' AND CREATED_BY='".$userid."' order by EXP_NAME";

															$parsed = ociparse($db_conn, $cmdCountry);
															ociexecute($parsed);
															$totalCountry = ocifetchstatement($parsed, $results);
															echo "<select name='exp_name' style='width:92%' size='8'>";
															for ($i=0;$i<$totalCountry;$i++)
                                							{                                     
                                       							echo "<option value=" . $results["EXP_NAME"][$i] . ">" . $results["EXP_NAME"][$i] . "</option>";
                                							}
															echo "</select><br><br><input name='cmdDelete' type='submit' value='Delete'/><br>";
														?>
                                					</td>
                                                    <td align="left" width="30%">
														&nbsp;
													</td>
												</tr>                                                                  
                                            </table>                                                                            
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
		<tr>
			<td>&nbsp;</td>
        </tr>
	</table>                  
	<?php
		//close database connection
		oci_close($db_conn);
		//include the header page
		include("footer.php");
	?> 
</form>
</body>
</html>