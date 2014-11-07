<?php
//include the header page
include("header.php");
if (session_id() == "") session_start();

//get session variabe
$db_UN=$_SESSION['un'];
$db_PASS=$_SESSION['pass'];
$db_DB=$_SESSION['db'];
$userid=strtoupper($_SESSION['userid']);
unset($_SESSION['expName']);
//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
if (! $db_conn) {
   $e = oci_error();
   print htmlentities($e['message']);
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
<title>Droso Pivot</title>

<script LANGUAGE="JavaScript" type="text/javascript">
var xmlHttp

function showDescription(strParameter){
 		
        xmlHttp=GetXmlHttpObject()
        if (xmlHttp==null){
                alert ("Browser does not support HTTP Request")
                return
        }
        var url="ExpDescription.php"
        url=url+"?param="+strParameter 
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
      <td align="left">&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="right"><font color="#4682B4"><h5><a href='DataManagement.php'>&lt;&lt;Back to Data ManageMent</a> | <a title='logout' href='index.php'>Log Out</a></h5></font></td>
    </tr>
  </table>
  <form name="form1" action="EditDescription.php" method="post">
    <table cellpadding="0" cellspacing="0" width="80%" align="center" bgcolor="#F0FFF0">
      <tr>
        <td>
          <fieldset>  
            <table cellpadding="0" cellspacing="0" width="100%" align="center">
              <tr>
                <td width="100%" align="CENTER">&nbsp;<br />
                  <table width="80%">
			<tr><td>&nbsp;</td></tr>
                    <tr>
                      <td>
			  <fieldset>
                            <table cellpadding="0" cellspacing="0" width="100%">
				<tr><td>&nbsp;</td></tr>
                              <tr>
                                <td>
                                  <table cellpadding="2" cellspacing="2" width="100%" style="font-family:Verdana; font-size:small">
                                    <tr>
                                      <td align="right" width="25%">
                                        Select an Experiment:&nbsp;&nbsp;
                                      </td>
                                      <td width="40%" align="left">
					<select name='expName' style='width:92%' onchange='showDescription(this.value)'>
					  <?php                                                                            
					     $cmdCountry = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0' order by EXP_NAME";
					     $parsed = ociparse($db_conn, $cmdCountry);	   
					     ociexecute($parsed);
					     $totalCountry = ocifetchstatement($parsed, $results);
					     for ($i=0;$i<$totalCountry;$i++) {                                     
       						echo "<option value=\"" . $results["EXP_NAME"][$i] . "\">" . $results["EXP_NAME"][$i] . "</option>";
					      }
				           ?>
                         		</select>                               											
				      </td>
                                      <td align="left" width="35%">
					<input name="btnSubmit" type="submit" value="Edit/Enter Description" style="width:100%;font-weight:bold;height:35px;COLOR:#4682B4"/>
                                      </td>
                                    </tr>                                                                  
				<tr><td>&nbsp;</td></tr>
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
	        <td>&nbsp;
                </td>
              </tr>
              <tr>
                <td width="100%" align="CENTER">&nbsp;<br />
                  <table width="80%">
                    <tr>
                      <td>                                                    
                        <table cellpadding="0" cellspacing="0" width="100%">
                          <tr>
                            <td>
                              <table cellpadding="2" cellspacing="2" width="100%" style="font-family:Verdana; font-size:small">
                                <tr>                                                                            
                                  <td width="100%" align="left">
				    <p><b><div id="txtHint"></div></b></p>
				  </td>
                                </tr>                                                                    
                              </table>
                            </td>
                          </tr>
                        </table>                                           
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table cellpadding="0" width="100%" style="font-family:Verdana; font-size:small; font-weight:bold">
              <tr>
                <td align="right">
                  &nbsp;&nbsp;&nbsp;&nbsp;                                
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

