<?php
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();

$userid=strtoupper($_SESSION['userid']);
unset($_SESSION['expName']);
?>


<!DOCTYPE html>

<html>

  <head>
    <title>Droso Pivot</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />

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
  <body>
    <?php
    //include the header page
    include("header.php");
    ?>


    <div class="edit_form">
      <h2> Select an Experiment </h2>
      <form name="form1" action="EditDescription.php" method="post">
	<?php select_from_all_experiments();  ?>
	<input name="btnSubmit" type="submit" value="Edit/Enter Description" class="submit button">
      </form>

      <?php include("footer.php"); ?>
  </body>
</html>


<?php oci_close($db_conn); ?>








