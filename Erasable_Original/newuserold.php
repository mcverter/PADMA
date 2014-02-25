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


$_SESSION['uidVerified']="false";
?>

<head>

<script LANGUAGE="JavaScript" type="text/javascript">
var xmlHttp
function validate(form1)
{
 	str="Please Enter your "
 	str2="\nPlease..."
 	youCount=0
 	idCount=0
 	
	if(""==document.forms.form1.lname.value)
	{
		str=str + "\n  * Last Name."
		youCount=youCount+1;
	}
		
	if(""==document.forms.form1.fname.value)
	{
		str=str + "\n  * First Name."
		youCount=youCount+1;
	}
		
	if(""==document.forms.form1.email.value)
	{
		str=str + "\n  * Email Address."
		youCount=youCount+1;
	}
	
	if(""==document.forms.form2.userid.value)
	{
		str2=str2 + "\n  * Select a User ID."
		idCount=idCount+1;
	}
	
	if(""==document.forms.form1.password.value)
	{
		str2=str2 + "\n  * Select a Password."
		idCount=idCount+1;
	}
	
	if(""==document.forms.form1.password2.value)
	{
		str2=str2 + "\n  * Retype Password."
		idCount=idCount+1;
	}	
	if(document.forms.form1.password.value != document.forms.form1.password2.value)
	{
		str2=str2 + "\n  * Retype Same Password."
		idCount=idCount+1;
	}
	strstr="ERROR\n"
	if (youCount>0)
	{
		strstr=strstr+str
	}
	if(idCount>0)
	{
		strstr=strstr+str2
	}
	
	emailAddress=document.forms.form1.email.value
	reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
	if(reg.test(emailAddress) == false)
	{
		strstr=strstr + "\nInvalid Email Address"
	}
    if (strstr !="ERROR\n")
    	{
                alert(strstr);
                return false;
    	}
}
function utility(strParameter)
{
 		userid=document.forms.form2.userid.value 
        xmlHttp=GetXmlHttpObject()
        if (xmlHttp==null){
                alert ("Browser does not support HTTP Request")
                return
        }
        var url="utility.php"
        url=url+"?param="+strParameter 
		url=url+"&UserID="+userid
        url=url+"&sid="+Math.random()
        xmlHttp.onreadystatechange=stateChanged
        xmlHttp.open("GET",url,true)
        xmlHttp.send(null)
}

function stateChanged(){
        if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
                document.getElementById("txtHint").innerHTML=xmlHttp.responseText
        }
}



function GetXmlHttpObject(){
        var xmlHttp=null;
        try{
                // Firefox, Opera 8.0+, Safari
                xmlHttp=new XMLHttpRequest();
        }
        catch (e){
                //Internet Explorer
                try{
                        xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (e){
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
                <td align="right"><font color="#4682B4"><h5><a href='index.php'>Back to Homepage</a></h5></font></td>
        </tr>
        

</table>

        
            <table cellpadding="0" cellspacing="0" width="80%" align="center" bgcolor="#F0FFF0">
                <tr>
                    <td>
                        <fieldset>  
						  
                            <table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                    <td width="100%" valign="top" style="font-family:Verdana; align="left">
                                    	<font color="#4682B4"><h2> NEW USER</h2> </font> <br><font color="#4682B4"><h5>Welcome to PADMA Database. Just select an UserID and Password, answer a few simple questions. We will <u>send you a e-mail</u>  when your account setup is complete</h5></font> <hr noshade height=1px style="border:dotted;color:gray">
                                    </td>
                                </tr>  
								<tr>
                                	<td>&nbsp;<br>
                                		<b><font color="#4682B4">1. Select an ID and Password....</font></b>
                                	</td>
                                </tr>
                                <tr>
                                    <td width="100%" align="CENTER">&nbsp;<br />
                                    	<table width="70%">
                                            <tr>
                                                <td>
                                                    <fieldset>
                                                    	 <table cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td>
																	
                                                                    <table cellpadding="2" cellspacing="2" width="100%" style="font-family:Verdana; font-size:small" align="right">
                                                                        <tr>
                                                                            <td align="right" width="30%">
                                                                                User ID:*&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="40%" align="left">
																			<form name="form2" method="post">
                                                                                <input name="userid" type="text" style="width:90%" /></form>
																			</td>
																			<td width="30%" align="left">
																				<button style="width:65;height:65" onClick="utility('verifyUserName')"><b>Check</b></button>
																				
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="30%"></td>
                                                                            <td width="40%" align="left">
																			<p><div id="txtHint"><b></div></p>
																			</td>
																			<td width="30%" align="left">
                                                                                &nbsp;&nbsp;  
                                                                            </td>
                                                                        </tr>
																	</table>
																	
																	<form name="form1" action="newuserSubmit.php" method="post" onsubmit="return validate(form1);">

                                                                        <table table cellpadding="2" cellspacing="2" width="100%" style="font-family:Verdana; font-size:small" align="right">
                                                                        <tr>
                                                                            <td align="right" width="30%">
                                                                                Password:*&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="40%" align="left">
                                                                                <input name="password" type="password" style="width:90%" />  
                                                                            </td>
																			<td width="30%" align="left">
                                                                                &nbsp;&nbsp;  
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="30%">
                                                                                Re-Type Password:*&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="40%" align="left">
                                                                                <input name="password2" type="password" style="width:90%" />
                                                                            </td>
																			<td width="30%" align="left">
                                                                                &nbsp;&nbsp;  
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
                                    <td width="100%" valign="top" style="font-family:Verdana; font-size:medium" align="left">
                                           &nbsp;<br><b><font color="#4682B4">
2. Please, tell us about you.... </font></b>                          
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" align="CENTER">&nbsp;<br />
                                        <table width="70%">
                                            <tr>
                                                <td>
                                                    <fieldset>
                                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td>
                                                                    <table cellpadding="2" cellspacing="2" width="100%" style="font-family:Verdana; font-size:small">
                                                                        <tr>
                                                                            <td align="right" width="50%">&nbsp;<br />
                                                                                Your Title:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">&nbsp;<br />
                                                                                <select name="title" style="width:46%">
                                                                                    <option>Mr</option>
                                                                                    <option>Ms.</option>
                                                                                    <option>DR.</option>
                                                                                </select>                                                                                
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                Last Name:*&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="lname" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                First Name:*&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="fname" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                MI:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="MI" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                Address:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="address" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                Address2:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="address2" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                City:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="city" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                State:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="state" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                Zip Code:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="zip" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                Country:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                            <?php                                                                            
																			$cmdCountry = "select country,countryid from country order by countryid";
																			$parsed = ociparse($db_conn, $cmdCountry);
																			ociexecute($parsed);
																			$totalCountry = ocifetchstatement($parsed, $results);
																			
                                                                        	echo "<select name='Country' style='width:92%'>";
																				                         
                                													for ($i=0;$i<$totalCountry;$i++)
                                													{                                     
                                       													 echo "<option value=" . $results["COUNTRYID"][$i] . ">" . $results["COUNTRY"][$i] . "</option>";
                                													}
																			?>
                                											</select>
                                											
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                Phone #:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="phone" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                E-mail Address:*&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="email" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                Industry:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="industry" type="text" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                Profession:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="profession" type="text" style="width:90%" />
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
                                
                            </table>
                            <table cellpadding="0" width="100%" style="font-family:Verdana; font-size:small; font-weight:bold">
                            	<tr>
                                    <td align="right">
                                        <input name="btnSubmit" type="submit" value="Submit" />&nbsp;&nbsp;&nbsp;&nbsp;                                
                                    </td>
                                </tr>
                            </table>     
                        </fieldset>
                    </td>
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