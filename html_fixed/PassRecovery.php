<?php
include ("control_functions.php");
initialize_session();
if (session_id() == "") session_start();
$_SESSION['uidVerified']="false";
?>



<!DOCTYPE html>
<head>
  <title>Droso Pivot</title>
  <link rel="stylesheet" href="css/style.css" type="text/css" />

  <link rel="stylesheet" href="css/style.css" type="text/css" />
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
<body>

  <?php  include("header.php"); ?>

  <h2>Password Recovery</h2>
  <div class="form_instructions">
    <p> Enter your userID and Email Address. </p>
    <p>We will send you a Email with new password</p>
  </div>

  <form name="form1"  method="post" onsubmit="return validate(form1);">
    <fieldset>

      <label> User ID:
	<input name="userid" type="text" /></label>

	<label> Email:
	  <input name="email" type="text" style="width:90%" /> </label>
    </fieldset>

    <input type="button"  onClick="utility('ResetPassword')" value="Submit" />
  </form>
  <div id="txtHint"></div>

  <?php include("footer.php");  ?>

</body>
</html>








