<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
//include the header page
include("header.php");
session_start();
$_SESSION['uidVerified']="false";
?>

<head>
<title>Droso Pivot</title>
<script LANGUAGE="JavaScript" type="text/javascript">
var xmlHttp;

function utility(strParameter)
{
 	var userid=document.forms.form1.userid.value; 
 	var emailAddress=document.forms.form1.email.value; 
        xmlHttp=GetXmlHttpObject();
        if (xmlHttp == null){
                alert ("Browser does not support HTTP Request");
                return;
        }
        var url="utility.php";
        url=url+"?param="+strParameter; 
	url=url+"&UserID="+userid;
	url=url+"&Email="+emailAddress;
        url=url+"&sid="+Math.random();
        xmlHttp.onreadystatechange = stateChanged;
        xmlHttp.open("GET",url,false);
        xmlHttp.send(null);
}

function stateChanged(){
        if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
                document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
                return;
        }
        else 
                document.getElementById("txtHint").innerHTML=
                   "<font sie='+1' color='red'>ERROR:</font> inner logic never responded, contact administrator.";
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

            <form name="form1"  method="post" onsubmit="return validate(form1);">
        
            <table cellpadding="0" cellspacing="0" width="80%" align="center" bgcolor="#F0FFF0">
                <tr>
                    <td>
                        <fieldset>  
						  
                            <table cellpadding="0" cellspacing="0" width="100%" align="center">
                            	<tr>
                                    <td width="100%" valign="top" style="font-family:Verdana; align="left">
                                    	<font color="#4682B4"><h2>Password Recovery</h2> </font> <br><font color="#4682B4"><h5>Enter your userID and Email Address. <u>We will send you a Email with new password</u></h5></font> <hr noshade height=1px style="border:dotted;color:gray">
                                    </td>
                                </tr>                                   
                                <tr>
                                	<td>&nbsp;<br>
                                		
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
                                                                            <td align="right" width="50%">
                                                                                User ID:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="userid" type="text" style="width:90%" />
																				                                                                             
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td align="right" width="50%">
                                                                                Email:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%" align="left">
                                                                                <input name="email" type="text" style="width:90%" />                                                                               
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
                            <table cellpadding="0" width="80%" align="center" style="font-family:Verdana; font-size:small; font-weight:bold">
                            	<tr>
                                    <td align="right">
                                        <input type="button" style="width:65;height:65" onClick="utility('ResetPassword')" value="Submit" />                                
                                    </td>
                                </tr>
                                <tr>                                
                                	<td width="100%" align="center">
					<div id="txtHint"></div>
					</td>
                                </tr>
                            </table>     
                        </fieldset>
                    </td>
                 </tr>
             </table>    
            <?php
			//include the header page
			include("footer.php");
			?> 
       
    </form>
</body>
</html>
