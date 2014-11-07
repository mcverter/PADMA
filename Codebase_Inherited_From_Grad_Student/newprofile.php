<?php
//include the header page
include("header.php");
if (session_id() == "") session_start();

//get session variabe
$db_UN = isset($_SESSION['un'])? $_SESSION['un'] : "undefined";
$db_PASS = isset($_SESSION['pass'])? $_SESSION['pass'] : "undefined";
$db_DB = isset($_SESSION['db'])? $_SESSION['db'] : "undefined";
$userid = isset($_SESSION['userid'])? $_SESSION['userid'] : "undefined";

if ($userid == "undefined") {
   echo "<font color='red'>";
   echo "<b>ERROR: undefined user ID (internal logic error), please contact PADMA administrator.</b>";
   echo "</font>";
   echo "<br /><a title='logout' href='index.php'>Click Here</a> to go back to home page";
   exit;
}
//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
if (! $db_conn) {
   $e = oci_error(); 		
   echo "<font color='red'>";
   print htmlentities($e['message']);
   echo "<b>ERROR: Connecting to Database, Please try back later</b>";
   echo "</font>";
   echo "<a title='logout' href='index.php'>Click Here</a> to go back to home page";
   exit;
   }
//obtain this user's profile 
$cmdName = "select title,fname,lname,mname,add_1,add_2,city,state,zip,country,phone,email,ind,prof,updated_by,updated_on from client where user_id = '".$userid."'";
$parsed = ociparse($db_conn, $cmdName);
ociexecute($parsed);
$result = oci_fetch_array($parsed, OCI_ASSOC+OCI_RETURN_NULLS);
if ($result == null) {
   echo "<font color='red'>";
   echo "<b>ERROR: invalid user ID (internal logic error), please contact PADMA administrator.</b>";
   echo "</font>";
   echo "<br /><a title='logout' href='index.php'>Click Here</a> to go back to home page";
   oci_free_statement($parsed);
   exit;
}
$Title= strtoupper($result["TITLE"]);
$Lname= $result["LNAME"];
$Fname= $result["FNAME"];
$Mname= $result["MNAME"];
$Address1=$result["ADD_1"];
$Address2=$result["ADD_2"];
$City=$result["CITY"];
$State=$result["STATE"];
$Zip=$result["ZIP"];
$Country=$result["COUNTRY"];
$Phone=$result["PHONE"];
$Email=$result["EMAIL"];
$Ind=$result["IND"];
$Profession=$result["PROF"];
$UpdatedBy=$result["UPDATED_BY"];
$UpdatedOn=$result["UPDATED_ON"];
oci_free_statement($parsed);
?>

<script LANGUAGE="JavaScript" type="text/javascript">
  var xmlHttp;
  function validate(form1) {
  str="Please Enter your ";
  str2="\nPlease...";
  youCount=0;
  idCount=0;
  if(""==document.forms.form1.lname.value) {
    str=str + "\n  * Last Name."
    youCount=youCount+1;
  }
  if(""==document.forms.form1.fname.value) {
    str=str + "\n  * First Name."
    youCount=youCount+1;
  }
  if(""==document.forms.form1.email.value)
  {
    str=str + "\n  * Email Address."
    youCount=youCount+1;
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
  return true;	
  }

function utility()
{
	if (validate("form1") == false) return; 
	
        xmlHttp=GetXmlHttpObject();
        if (xmlHttp==null){
                alert ("Browser does not support HTTP Request");
                return;
        }
        var url="newprofileSubmit.php";

	var params = "title=" + encodeURIComponent(document.getElementsByName("title")[0].value) + "&lname=" + encodeURIComponent(document.getElementsByName("lname")[0].value) 
	+ "&fname=" + encodeURIComponent(document.getElementsByName("fname")[0].value) + "&mname=" + encodeURIComponent(document.getElementsByName("mname")[0].value)
	+ "&address=" + encodeURIComponent(document.getElementsByName("address")[0].value) + "&address2=" + encodeURIComponent(document.getElementsByName("address2")[0].value)
	+ "&city=" + encodeURIComponent(document.getElementsByName("city")[0].value) + "&state=" + encodeURIComponent(document.getElementsByName("state")[0].value)
	+ "&zip=" + encodeURIComponent(document.getElementsByName("zip")[0].value) + "&country=" + encodeURIComponent(document.getElementsByName("country")[0].value)
	+ "&phone=" + encodeURIComponent(document.getElementsByName("phone")[0].value) + "&email=" + encodeURIComponent(document.getElementsByName("email")[0].value)
	+ "&industry=" + encodeURIComponent(document.getElementsByName("industry")[0].value) + "&profession=" + encodeURIComponent(document.getElementsByName("profession")[0].value);

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
                document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
		return;
        }
        else {
                document.getElementById("txtHint").innerHTML=
                   "<font sie='+1' color='red'>ERROR:</font> inner logic never responded, contact administrator.";
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

<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">
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

  <table cellpadding="0" cellspacing="0" width="80%" align="center" bgcolor="#F0FFF0">
    <tr>
      <td>
	<fieldset>

	  <table cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#F0FFF0">
	    <tr>
	      <td width="100%" valign="top"
	      style="font-family:Verdana;"
	      align="left"><font color="#4682B4"><h2>YOUR
	      PROFILE</h2></font><br /><font color="#4682B4"><h5>Please
	      reflect your up-to-date information to the system. This
	      profile data will be inspected by the PADMA system
	      administrator only at the selection of your account
	      type. The collected information will never be
	      disclosed.</h5></font><hr noshade height=1px
	      style="border:dotted;color:gray" />
	      </td>
	    </tr>
	    <tr><td>&nbsp;</td></tr>		  
	    <tr>
	      <td><b><font color="#4682B4">Your registered user ID</font></b>
	      <table cellpadding="2" cellspacing="2" width="100%" style="font-family:Verdana; font-size:small" align="right">
		<tr>
		  <td align="right" width="30%">&nbsp;<font color="red">*</font>&nbsp;&nbsp;</td>
		  <td width="40%" align="left"><?php echo "\"$userid\""; ?> &#8212; to change password, click <a href="PassChange.php">here</a></td>
		</tr>
		<tr>
		  <td align="right" width="30%"></td>
		  <td width="40%" align="left"><p></p><b><div id="txtHintX">&nbsp;</div></b></td>
		  <td width="30%" align="left">&nbsp;&nbsp;</td>
		</tr>
	      </table>
	    </td>
	  </tr>
	</table>
	<form name="form1" method="post">
	  <b><font color="#4682B4">Your current profile in the system</font></b>
	  <p></p>
	      <table width="70%" align="center">
		<tr>
		  <td>
		    <fieldset><legend><font size="-1">Last updated by <?php echo $UpdatedBy; ?> on <?php echo $UpdatedOn; ?></font></legend>
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
				    <option value="Mr." <?php if ($Title == "MR"  || $Title == "MR." || $Title == "") echo " selected" ?>>Mr.</option>
				    <option value="Ms." <?php if ($Title == "MS.") echo " selected" ?>>Ms.</option>
				    <option value="Dr." <?php if ($Title == "DR.") echo " selected" ?>>Dr.</option>
				  </select>                                                                                
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  Last Name:<font color="red">*</font>&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="lname" type="text" value=<?php echo "\"$Lname\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  First Name:<font color="red">*</font>&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="fname" type="text" value=<?php echo "\"$Fname\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  MI:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="mname" type="text" value=<?php echo "\"$Mname\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  Address:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="address" type="text" value=<?php echo "\"$Address1\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  Address2:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="address2" type="text" value=<?php echo "\"$Address2\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  City:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="city" type="text" value=<?php echo "\"$City\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  State:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="state" type="text" value=<?php echo "\"$State\""; ?> style="width:90%" />
			      </td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  Zip Code:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="zip" type="text" value=<?php echo "\"$Zip\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  Country:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <select name="country" style="width:92%">				
				    <?php                                                                            
				       $cmdCountry = "select country,countryid from country order by countryid";
				       $parsed = ociparse($db_conn, $cmdCountry);
				       ociexecute($parsed);
				       $totalCountry = ocifetchstatement($parsed, $results);
				       
				       for ($i=0 ; $i < $totalCountry; $i++) { 
            				 echo "<option value=" . $results["COUNTRYID"][$i] . ($Country == $results["COUNTRY"][$i]? " selected":"") . ">" . $results["COUNTRY"][$i] . "</option>";
				       }	
				       oci_free_statement($parsed);
				     ?>
				  </select>
				 </td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  Phone Number:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="phone" type="text" value=<?php echo "\"$Phone\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  E-mail Address:<font color="red">*</font>&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="email" type="text" value=<?php echo "\"$Email\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  Industry:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="industry" type="text" value=<?php echo "\"$Ind\""; ?> style="width:90%" />
				</td>
			      </tr>
			      <tr>
				<td align="right" width="50%"> 
				  Profession:&nbsp;&nbsp;
				</td>
				<td width="50%" align="left">
				  <input name="profession" type="text" value=<?php echo "\"$Profession\""; ?> style="width:90%" />
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
	      <table cellpadding="0" width="100%" style="font-family:Verdana; font-size:medium; font-weight:bold">
		<tr>
		  <td align="right">
		    <input name="btnSubmit" type="button" value="Submit" onClick="utility()"/>&nbsp;&nbsp;&nbsp;&nbsp;                                
		  </td>
		  <td width="40%" align="left"><p></p><font size="+1"><div id="txtHint">&nbsp;</div></font></td>
		</tr>
	      </table>     
	      </td>
	    </tr>
	  </table>
	</form>
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
</body>
</html>
