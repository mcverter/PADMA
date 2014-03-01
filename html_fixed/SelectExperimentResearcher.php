<?php
include ("control_functions.php");
check_role('r');
initialize_session();
$db_conn = connect_to_db();
$userid=strtoupper($_SESSION['userid']);
unset($_SESSION['expName']);
?>


<!DOCTYPE html>


<head>
  <link rel="stylesheet" href="css/style.css" type="text/css" />
  <title>Droso Pivot</title>

  <script LANGUAGE="JavaScript" type="text/javascript">
   var xmlHttp
   function validate(form1) {
     if (document.forms.form1.expName.value == "Select one") {
       alert("Enter valid experiment");
       return false;
     }
     return true;
   }
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
<body>
  <?php
  //include the header page
  include("header.php");
  ?>

    <form name="form1" action="EditDescription.php" method="post" onSubmit="return validate(form1);">
      Select an Experiment:&nbsp;&nbsp;
	<?php select_from_researcher_experiments() ?>
      </select>
      <div id="txtHint"></div>
      <?php
      //close database connection
      oci_close($db_conn);
      //include the header page
      include("footer.php");
      ?>
    </form>
</body>
</html>








