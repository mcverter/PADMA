<?php
include ("control_functions.php");
check_role('any');
initialize_session();
$db_conn = connect_to_db();
$userid=strtoupper($_SESSION['userid']);
$username=$_SESSION['userid'];
?>

<!DOCTYPE html>


<?php
?>

<head>
  <title>Droso Pivot</title>
  <link rel="stylesheet" href="css/style.css" type="text/css" />
  <script LANGUAGE="JavaScript" type="text/javascript">
   var xmlHttp;
   function utility(strParameter)
   {
     var password=document.forms.form1.oldPass.value;
     var newPassword=document.forms.form1.newPass.value;
     var retypeNewPassword=document.forms.form1.retypeNewPass.value;

     if (newPassword != retypeNewPassword) {
       alert ("Retype same password");
       return;
     }

     xmlHttp=GetXmlHttpObject();
     if (xmlHttp==null){
       alert ("Browser does not support HTTP Request");
       return;
     }
     var url="utility.php";
     url=url+"?param="+strParameter;
     url=url+"&Pass="+password;
     url=url+"&newPass="+newPassword;
     url=url+"&sid="+Math.random();
     xmlHttp.onreadystatechange=stateChanged;
     xmlHttp.open("GET", url, false);
     xmlHttp.send(null);
   }

   function stateChanged(){
     if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
       document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
       return;
     }
     else document.getElementById("txtHint").innerHTML="<font size='+1' color='red'>ERROR:</font> inner logic never responded, contact administrator!";
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

  <form name="form1" method="post" onsubmit="return validate(form1);">

    <h2> Password Change </h2>
    <fieldset>
      <label> User ID:
	<?php strtoupper($username)  ?> </label>
      <label> Old Password:
	<input name="oldPass" type="PASSWORD" /> </label>
	<label> New Password:
	  <input name="newPass" type="PASSWORD" /> </label>
	  <label> Retype New Password:
	    <input name="retypeNewPass" type="PASSWORD" /> </label>

	    <input type="button"  onClick="utility('ChangePassword')" value="Submit" />
	    <div id="txtHint"></div>
    </fieldset>



    <?php  include("footer.php"); ?>

  </form>
</body>
</html>

<?php
oci_close($db_conn);
?>




