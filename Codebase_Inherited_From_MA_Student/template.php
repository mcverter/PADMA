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


$role=$_SESSION['role'];
if($role == "Administrator") {}
else
{
 	echo "Access Denied";
	return;
}
?>

<head>
<title>Droso Pivot</title>

<script LANGUAGE="JavaScript" type="text/javascript">
var xmlHttp
function validate(form1)
{
 	str="Please Enter your "
 	str2="\nPlease..."
 	youCount=0
 	idCount=0
 	
}
function utility(strParameter)
{
 		userid=document.forms.form1.userid.value
 
        xmlHttp=GetXmlHttpObject()
        if (xmlHttp==null)
        {
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

function stateChanged()
{
        if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        {
                document.getElementById("txtHint").innerHTML=xmlHttp.responseText
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
                        			<form  action="QuickSearchResult.php" method="post" name="index" onsubmit="return validate(index);">
                        				fdfdfdfdfdf
									</form>
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