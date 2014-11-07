<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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
if($role == "Administrator") {}
else
{
 	header("location: index.php"); 
}
?>

<head>
<title></title>

<script LANGUAGE="JavaScript" type="text/javascript">
var xmlHttp;
function showUserInfo(str)
{
        xmlHttp=GetXmlHttpObject();
        if (xmlHttp==null)
        {
                alert ("Browser does not support HTTP Request");
                return;
        }
        var url="getUserInfo.php";
        url=url+"?q="+str;
        url=url+"&sid="+Math.random();
        xmlHttp.onreadystatechange=stateChanged;
        xmlHttp.open("GET",url,false);
        xmlHttp.send(null);
}

function stateChanged()
{
        if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        {
                //document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
                document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
        }
}

function utility(strParameter)
{
		var rightID = document.forms.frmright.accright.value;
		var gotUserID = document.getElementById('got_userid').innerHTML;
		var gotEmail = document.getElementById('got_email').innerHTML;
		if (gotUserID == null || gotEmail == null) {
			alert ("Found Internal Logic Error -- please contact PADMA administrator at our CONTACT US option.");
			return;
		}
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
        }
        var url="utility.php";
        url=url+"?param="+strParameter;
		url=url+"&rightID="+rightID;
        url=url+"&sid="+Math.random();
        url=url+"&UserID="+gotUserID;
        url=url+"&Email="+gotEmail;
        xmlHttp.onreadystatechange=stateChanged2;
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
}

function stateChanged2()
{
        if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        {
                document.getElementById("accessright").innerHTML=xmlHttp.responseText;
        }
}

function GetXmlHttpObject()
{
        var xmlHttp=null;
        try
        {
                // Firefox, Opera 8.0+, Safari
                xmlHttp=new XMLHttpRequest();
        }
        catch (e)
        {
                //Internet Explorer
                try
                {
                        xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (e)
                {
                        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
        }
        return xmlHttp;
}
</script>

</head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana" >

<table cellpadding="0" cellspacing="0" width="95%" align="center">
        <tr>
                <td >&nbsp;</td>
                <td align="right">&nbsp;</td>
        </tr>
        <tr>
                <td >&nbsp;</td>
                <td align="right"><font color="#4682B4"><h5><a href='switchboard_ret.php'>&lt;&lt;Back to Switchboard</a></h5></font></td>
        </tr>
</table>

<table width="100%">
	<tr>
        <td style="width:5%">
			&nbsp;
		</td>
        <td style="width:90%">
        	<table width="100%" border="1" style="border-collapse:collapse; border-color:#4682b4; border-style:solid">
    			<tr>
            		<td>
                    	<table width="100%" style="background-image:url('images/Tblheader.png');color:#ffffff" cellpadding="4"cellspacing="0">
							<tr>
                            	<td>
									<b>User Management</b>
								</td>
							</tr>
						</table>
						
						<br><br><br>
                		<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    		<tr>
                        		<td style="width:10%">
									&nbsp;
								</td>
                        		<td style="width:80%" align="left" >                        		
                        			    <table cellpadding="5" cellspacing="0" width="100%"border="0" align="center">
                    						<tr>
                        						<td style="width:50%">
													<table cellpadding="0" cellspacing="0" width="80%"border="0" align="left" >
														<tr>
                        									<td>
                        										<fieldset>
                        										<legend><font color="#4682B4">New User </font></legend>
                        										<br><br>
																
																	<?php                                                                            
																		$cmdName = "select c_id,fname,lname from client where ACC_RIGHT_ID = 0 order by lname ";
																		$parsed = ociparse($db_conn, $cmdName);
																		ociexecute($parsed);
																		$totalName = ocifetchstatement($parsed, $results);
                                                                        echo "<select name='country' style='width:92%' size='5' onchange='showUserInfo(this.value)'>";																				                         
                                										for ($i=0;$i<$totalName;$i++)
                                										{                                     
                                       										echo "<option value=" . $results["C_ID"][$i] . ">" . strtoupper($results["LNAME"][$i]) .", ". strtoupper($results["FNAME"][$i]). "</option>";
                                										}
                                										echo"</select>";
                                									?>
                                									<BR>&nbsp;<BR>
                        										</fieldset> 
															</td>
														</tr>													
														<tr>
                        									<td>
																<br><br>
                        										<fieldset>
                        										<legend><font color="#4682B4">Existing User </font></legend>
                        										<br><br>
																
																<?php                                                                            
																		$cmdName = "select c_id,fname,lname from client where ACC_RIGHT_ID > 0 order by lname ";
																		
																		$parsed = ociparse($db_conn, $cmdName);
																		ociexecute($parsed);
																		$totalName = ocifetchstatement($parsed, $results);
                                                                        echo "<select name='country' style='width:92%' size='8' onchange='showUserInfo(this.value)'>";																				                         
                                										for ($i=0;$i<$totalName;$i++)
                                										{                                     
                                       										echo "<option value=" . $results["C_ID"][$i] . ">" . strtoupper($results["LNAME"][$i]) .", ". strtoupper($results["FNAME"][$i]). "</option>";
                                										}
                                										echo"</select>";
                                									?>
                                									<BR>&nbsp;<BR>
                        										
															</td>
														</tr>
													</table>														
												</td>	
												<td style="width:50%" valign="top">
												<fieldset>
                        						<legend><font color="#4682B4">Detail </font></legend>
													<table width="100%">
														<tr>
															<td>
																
                        											<p><div id="txtHint"></div></p>                        							
                        																									
															</td>
														</tr>
													</table>
													</fieldset>
													<BR>&nbsp;
													<fieldset>
                        							<legend><font color="#4682B4">Assign Access Right </font></legend>
													<table width="100%" cellpadding="2" cellspacing="2" style="font-family:Verdana; font-size:small; font-weight:bold">
														<tr>
															<td align="right" width="50%" valign="top">
																Select One:&nbsp;&nbsp;															
															</td>
															<td width="50%" align="left" valign="top">
																<form name="frmright">
																<?php                                                                            
																$cmdName = "select ACC_RIGHT_ID,ACC_RIGHT_DESC from ACCESS_RIGHT order by ACC_RIGHT_DESC ";
																$parsed = ociparse($db_conn, $cmdName);
																ociexecute($parsed);
																$totalName = ocifetchstatement($parsed, $results);
																?>
																
                                                        		<select name="accright">	
                                                        		
																<?php																	                         
                                								for ($i=0;$i<$totalName;$i++)
                                									{                                     
                                       									echo "<option value=" . $results["ACC_RIGHT_ID"][$i] . ">" . ($results["ACC_RIGHT_DESC"][$i]). "</option>";
                                									}
                                								echo"</select>";
                                								
                                								?>
                        										<p><div id="access"></div></p> 
                        										</form>
															</td>
														</tr>
														
														<tr>
															<td align="right" width="50%">																
															</td>
															<td align="center" width="50%">
																<button style="width:65;height:65" onClick="utility('AssignRight')"><b>Submit</b></button>
															</td>
														</tr>
													</table>                   							                       							
                        							</fieldset> 
                        							
                        							<BR>&nbsp;
													<fieldset>
													<table width="100%" cellpadding="2" cellspacing="2" style="font-family:Verdana; font-size:small; font-weight:bold">														
														<tr>
															<td align="left" width="33%">			
																<button style="width:65;height:65" onClick="utility('ResetPassword')"><b>Reset Password</b></button>													
															</td>
															<td align="center" width="33%">
																<button style="width:65;height:65" onClick="utility('DeleteUser')"><b>Delete User</b></button>
															</td>
															<td align="Right" width="34%">
																<button style="width:65;height:65" onClick="utility('ReActivate')"><b>Re-Activate</b></button>
															</td>
														</tr>
													</table>  
													<table width="100%" cellpadding="2" cellspacing="2" style="font-family:Verdana; font-size:large; font-weight:bold">														
														<tr>
															<td align="center" width="100%">			
																<p><div id="accessright"></div></p>
															</td>															
														</tr>
													</table>                     							                       							
                        							</fieldset> 
                        							
                        							
												</td>
											</tr>
										</table>                   				
									
								</td>
                        		<td style="width:10%">
									&nbsp;
								</td>
                    		</tr>
						</table><br>
                		<table width="100%" style="background-image:url('images/Tblfooter.png');color:#ffffff" cellpadding="0"  cellspacing="0">
							<tr>
                                <td align="right">
									<a title='logout' href='index.php'>Log Out</a>
								</td>
							</tr>
						</table>
            		</td>
         		</tr>
        	</table>
    	</td>
    	<td style="width:5%">
			&nbsp;
		</td>
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
