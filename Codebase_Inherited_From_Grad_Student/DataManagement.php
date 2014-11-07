<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
 </head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">

<?php
//include the header page
include("header.php");
session_start();

//get session variabe
$db_UN=$_SESSION['un'];
$db_PASS=$_SESSION['pass'];
$db_DB=$_SESSION['db'];
  
//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
if (! $db_conn)
{
	$e = oci_error(); 		
	echo "<font color='red'>";
	print htmlentities($e['message']);
	echo "<br>ERROR: Connecting to Database, Please try back later<br>";
	echo "</font>";
	echo "<a title='logout' href='index.php'>Click Here</a> to go back to home page";
	exit;
}
  
$role=$_SESSION['role'];
//REDIRECT THE USER TO LOGIN PAGE IF USER IS NOT ADMINISTRATOR OR RESEARCHER
if($role == "Administrator" || $role =="Researcher") {}
else
{
 	header("location: index.php"); 
}

?>

<table cellpadding="0" cellspacing="0" width="95%" align="center">
        <tr>
                <td >&nbsp;</td>
                <td align="right">&nbsp;</td>
        </tr>
        <tr>
                <td >&nbsp;</td>
                <td align="right"></td>
        </tr>
        

</table>

<table width="100%">
	<tr>
        <td style="width:20%">&nbsp;</td>
        <td style="width:60%">
        <table width="100%" border="1" style="border-collapse:collapse; border-color:#4682b4; border-style:solid">
    		<tr>
            	<td>
                    <table width="100%" style="background-image:url('images/Tblheader.png');color:#ffffff" cellpadding="4"cellspacing="0">
						<tr>
                            <td ><b>Select One...</b></td></tr></table>   
								<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    				<tr>
                        				<td style="width:10%">
                        				<td style="width:80%" align="left" >  
                        				<?php
                        				if ($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
                        				{
											echo "<table width='100%' cellpadding='0'  cellspacing='0' style='font-family:Verdana; font-size:small; font-weight:bold'>";
											echo	"<tr>";
                                        	echo		"<td align='right' valign='center'><br>";
											echo			"<a title='logout' href='switchboard_ret.php'>Back to Switchboard</a> <br />";
											echo		"</td>";
											echo	"</tr>";
											echo "</table>";    
										}
										else
										{
											echo "&nbsp;<br>";											
										}
											?>             				
											<table cellpadding="0" cellspacing="0" width="100%" bgcolor="#F0FFF0">
                    						<tr><td>                 					
                        					<fieldset>&nbsp;<br />
                        					<?php			
												if ($role=="Researcher")
                        						{
													echo "<table cellpadding='5' cellspacing='0' width='100%' border='0'>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='uploadagreement.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Load Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";																		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='deleteExpResearcher.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Delete Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";																		
													echo		"</td>";																										
													echo	"</tr>";
                    								echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='SelectExperimentResearcher.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Enter/Edit Experiment Detail' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo "</table>";										
																											
												}
												
												if ($role=="Administrator")
                        						{
													echo "<table cellpadding='5' cellspacing='0' width='100%' border='0'>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='loaderStart.php' method='post' name='usermanagement'>";													
													echo			"<input id='btnLogin' type='submit' value='Load Reference Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";																					
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='deleteRefAdministrator.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Delete Reference Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";																		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='uploadagreement.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Load Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='deleteExpAdministrator.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Delete Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";																		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='SelectExperiment.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Enter/Edit Experiment Detail' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";                    								
													echo "</table>";										
																											
												}
												
											?>
											<br/>
											</fieldset>
											</td>
											</tr>
											</table>    
											</form>
										</td>
                        				<td style="width:10%">&nbsp;</td>
                    				</tr>
								</table><br>
                				<table width="100%" style="background-image:url('images/Tblfooter.png');color:#ffffff" cellpadding="0"  cellspacing="0">
									<tr>
                                        <td>&nbsp;</td>
									</tr>
								</table>
            				</td>
         				</tr>
         			</table>
        		</td>
        		<td style="width:20%">&nbsp;</td>
     		</tr>
     	</table>
     	<?php
     		//close database connection
			oci_close($db_conn);
			//include the header page
			include("footer.php");
			?> 
	</body>
</html>

