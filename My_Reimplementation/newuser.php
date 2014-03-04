<?php
include ("control_functions.php");
check_role('a');
initialize_session();
$db_conn = connect_to_db();
$_SESSION['uidVerified'] = "false";
?>

<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />


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
  <body>
    <?php
    //include the header page
    include("header.php");
    ?>
    <div class="nav_back">
      <!-- -
      <td class="_R">><font color="#4682B4"><h5><a href='index.php'>Back to Homepage</a></h5></font></td>
      -->
      <fieldset>
	<h2>NEW USER</h2>
	<h5>Welcome to PADMA Database. Just select an UserID and Password, answer a few simple questions. We will <u>send you a e-mail</u> when your account setup is complete</h5>
	<form name="form2" method="post">
	  <p>1. Select a non-existing User ID</p>
	  User ID:
	  <input name="userid" type="text" style="width:90%" />
	</form>
	<button style="width:65;height:65" onClick="utility('verifyUserName')"><b>Check</b></button>
	<div id="txtHint"></div>
	<form name="form1" action="newuserSubmit.php" method="post" onsubmit="return validate(form1);">
	  <b>2. Select your initial password</b>
	  Password:
	  <input name="password" type="password" style="width:90%" />
	  Re-Type Password:
	  <input name="password2" type="password" style="width:90%" />
	  3. Please tell us about you</font></b><p></p>
	  Your Title:
	  <select name="title" style="width:46%">
	    <option>Mr.</option>
	    <option>Ms.</option>
	    <option>Dr.</option>
	  </select>
	  Last Name:
	  <input name="lname" type="text" style="width:90%" />
	  First Name:
	  <input name="fname" type="text" style="width:90%" />
	  MI:&nbsp;&nbsp;
	  <input name="MI" type="text" style="width:90%" />
	  Address:&nbsp;&nbsp;
	  <input name="address" type="text" style="width:90%" />
	  Address2:&nbsp;&nbsp;
	  <input name="address2" type="text" style="width:90%" />
	  City:&nbsp;&nbsp;
	  <input name="city" type="text" style="width:90%" />
	  State:&nbsp;&nbsp;
	  <input name="state" type="text" style="width:90%" />
	  Zip Code:&nbsp;&nbsp;
	  <input name="zip" type="text" style="width:90%" />
	  Country:&nbsp;&nbsp;
	  <select name='Country' style='width:92%'>
	    <?php
	    $cmdCountry = "select country,countryid from country order by countryid";
	    $parsed = ociparse($db_conn, $cmdCountry);
	    ociexecute($parsed);
	    $totalCountry = ocifetchstatement($parsed, $results);

	    for ($i=0 ; $i < $totalCountry; $i++) {
              echo "<option value=" . $results["COUNTRYID"][$i] . ">" . $results["COUNTRY"][$i] . "</option>";
	    }
	    oci_free_statement($parsed);
	    ?>
	  </select>
	  Phone Number:&nbsp;&nbsp;
	  <input name="phone" type="text" style="width:90%" />
	  E-mail Address:<font color="red">*</font>&nbsp;&nbsp;
	  <input name="email" type="text" style="width:90%" />
	  Industry:&nbsp;&nbsp;
	  <input name="industry" type="text" style="width:90%" />
	  Profession:&nbsp;&nbsp;
	  <input name="profession" type="text" style="width:90%" />
      </fieldset>

      <input name="btnSubmit" type="submit" value="Submit" />&nbsp;&nbsp;&nbsp;&nbsp;
	</form>
	<?php
	//close database connection
	oci_close($db_conn);
	//include the header page
	include("footer.php");
	?>
  </body>
</html>








