<?php
include ("control_functions.php");
check_role('a');
initialize_session();
$db_conn = connect_to_db();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta charset="UTF-8">
    <?php 
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
  </head>
  <body>
    <?php include ("header.php"); ?>
      <div class="data_mgmt_nav">
	<!--
	<td class="_R">><font color="#4682B4"><h5><a href='DataManagement.php'>&lt;&lt;Back to Data ManageMent</a> | <a title='logout' href='index.php'>Log Out</a></h5></font></td>
	-->
	<div class="edit_description">
	  <form name="form1" method="post">
	    <h2>Experiment Name</h2>
	    <?php
	    echo "<b>" . $ExpName . "</b>";
	    ?>
	    <?php
	    $str ="SELECT EXP_MASTER.* FROM EXP_MASTER WHERE EXP_MASTER.EXP_NAME = '".$ExpName."'";
	    $parsed = ociparse($db_conn, $str);
	    ociexecute($parsed);
	    $numrows = ocifetchstatement($parsed, $results);
	    echo "<textarea  name='Description' rows ='15' cols='75' style='font-size:medium;font-family:verdana '>";
	    echo  $results["EXP_DESC"][0];
	    echo "</textarea>";
	    ?>
	    <input name="expName" type="hidden" value=<?php echo "\"$ExpName\"";?>
            <input name="btnSubmit" type="button" value="Save" style="width:65;height:65" onClick="save()"/>


  	    <?php
	    //close database connection
	    oci_close($db_conn);
	    //include the header page
	    include("footer.php");
	    ?>
	  </form>
	</div>
    </body>
</html>













