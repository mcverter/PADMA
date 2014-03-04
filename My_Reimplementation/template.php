<?php
include ("control_functions.php");
check_role('a');
initialize_session();
$db_conn = connect_to_db();
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Droso Pivot</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />

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
  <body>

    <?php
    //include the header page
    include("header.php");
    ?>

    <h2>User Management</h2>
    <form  action="QuickSearchResult.php" method="post" name="index" onsubmit="return validate(index);">
    </form>

    <table class="footerImage">
      <a title='logout' href='index.php'>Log Out</a>
      <?php
      //close database connection
      oci_close($db_conn);

      //include the header page
      include("footer.php");
      ?>

  </body>
</html>






