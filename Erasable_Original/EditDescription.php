<?php
//include the header page
include("header.php");
if (session_id() == "") session_start();

$maxExecutionTime=6000;
set_time_limit ( $maxExecutionTime );

//get session variabe
$db_UN=$_SESSION['un'];
$db_PASS=$_SESSION['pass'];
$db_DB=$_SESSION['db'];
  
//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);

$role=$_SESSION['role'];
//REDIRECT THE USER TO LOGIN PAGE IF USER IS NOT ADMINISTRATOR OR RESEARCHER
if($role == "Administrator" || $role =="Researcher") {}
else
{
 	header("location: index.php"); 
}
$ExpName = isset($_POST['expName'])? $_POST['expName'] : ""; 
if (empty($ExpName)) {
	echo "ERROR: logic error";
	exit; 
}
?>

<script LANGUAGE="JavaScript" type="text/javascript">
var xmlHttp

function save(){
	var description = encodeURIComponent(document.forms.form1.Description.value);  
	var expName = encodeURIComponent(document.forms.form1.expName.value);
	if (description == "" || expName=="") return false;
 		
        xmlHttp=GetXmlHttpObject();
        if (xmlHttp==null){
                alert ("Browser does not support HTTP Request");
                return;
        }
        var url="ConfirmEditDescription.php"
	var params = "expName=" + expName + "&desc=" + description;

    try{
        xmlHttp.onreadystatechange=stateChanged;
        xmlHttp.open("POST",url,false);
        // send the propoer header information along with the request
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Connection", "close");
        xmlHttp.send(params);
     } catch(e) {
        alert(e.toString()+" Please contact PADMA administrator");
     }
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
  <form name="form1" method="post">
    <table cellpadding="0" cellspacing="0" width="80%" align="center" bgcolor="#F0FFF0">
      <tr>
        <td>
          <fieldset>  
            <table cellpadding="0" cellspacing="0" width="100%" align="center">
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
                                      <td align="right" width="50%">
                                        Experiment Name:&nbsp;&nbsp;
                                      </td>
                                      <td width="50%" align="left">
                                        <?php
                                           echo "<b>" . $ExpName . "</b>";
					   ?>                           											
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
                                  <td>
				    <?php
				       $str ="SELECT EXP_MASTER.* FROM EXP_MASTER WHERE EXP_MASTER.EXP_NAME = '".$ExpName."'";
				       $parsed = ociparse($db_conn, $str);
				       ociexecute($parsed);
				       $numrows = ocifetchstatement($parsed, $results);
				       echo "<textarea  name='Description' rows ='15' cols='75' style='font-size:medium;font-family:verdana '>";
				       echo  $results["EXP_DESC"][0];
				       echo "</textarea>";
				       ?>
				  </td>
                                </tr>   
				<tr>
				  <td align="right">
				    <input name="expName" type="hidden" value=<?php echo "\"$ExpName\"";?>>	
                                    <input name="btnSubmit" type="button" value="Save" style="width:65;height:65" onClick="save()"/>
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
                <td align="center">
                  <p><b><div id="txtHint"></div></b></p>                                
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
