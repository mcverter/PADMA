<?php
include("control_functions.php");
check_role('a');
initialize_session();
$db_conn=connect_to_db();
$userid=strtoupper($_SESSION['userid']);
?>


<!DOCTYPE html>

<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />

    <script LANGUAGE="JavaScript" type="text/javascript">
     var xmlHttp;
     function showUserInfo(str)
     {
       xmlHttp=GetXmlHttpObject();
       if (xmlHttp==null)
       {
	 alert ("Browser does not support HTTP Request");
	 return;
       }
       var url="getUserInfo.php";
       url=url+"?q="+str;
       url=url+"&sid="+Math.random();
       xmlHttp.onreadystatechange=stateChanged;
       xmlHttp.open("GET",url,false);
       xmlHttp.send(null);
     }

     function stateChanged()
     {
       if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
       {
	 //document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
	 document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
       }
     }

     function utility(strParameter)
     {
       var rightID = document.forms.frmright.accright.value;
       var gotUserID = document.getElementById('got_userid').innerHTML;
       var gotEmail = document.getElementById('got_email').innerHTML;
       if (gotUserID == null || gotEmail == null) {
	 alert ("Found Internal Logic Error -- please contact PADMA administrator at our CONTACT US option.");
	 return;
       }
       xmlHttp=GetXmlHttpObject();
       if (xmlHttp==null)
       {
	 alert ("Browser does not support HTTP Request");
	 return;
       }
       var url="utility.php";
       url=url+"?param="+strParameter;
       url=url+"&rightID="+rightID;
       url=url+"&sid="+Math.random();
       url=url+"&UserID="+gotUserID;
       url=url+"&Email="+gotEmail;
       xmlHttp.onreadystatechange=stateChanged2;
       xmlHttp.open("GET",url,true);
       xmlHttp.send(null);
     }

     function stateChanged2()
     {
       if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
       {
	 document.getElementById("accessright").innerHTML=xmlHttp.responseText;
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
    <fieldset>
      <legend><font color="#4682B4">New User </font></legend>

      <?php
      $cmdName = "select c_id,fname,lname from client where ACC_RIGHT_ID = 0 order by lname ";
      $parsed = ociparse($db_conn, $cmdName);
      ociexecute($parsed);
      $totalName = ocifetchstatement($parsed, $results);
      echo "<select name='country' style='width:92%' size='5' onchange='showUserInfo(this.value)'>";
      for ($i=0;$i<$totalName;$i++)
      {
        echo "<option value=" . $results["C_ID"][$i] . ">" . strtoupper($results["LNAME"][$i]) .", ". strtoupper($results["FNAME"][$i]). "</option>";
      }
      echo"</select>";
      ?>
    </fieldset>

    <fieldset>
      <legend>Existing User</legend>
      <?php
      $cmdName = "select c_id,fname,lname from client where ACC_RIGHT_ID > 0 order by lname ";

      $parsed = ociparse($db_conn, $cmdName);
      ociexecute($parsed);
      $totalName = ocifetchstatement($parsed, $results);
      echo "<select name='country' style='width:92%' size='8' onchange='showUserInfo(this.value)'>";
      for ($i=0;$i<$totalName;$i++)
      {
        echo "<option value=" . $results["C_ID"][$i] . ">" . strtoupper($results["LNAME"][$i]) .", ". strtoupper($results["FNAME"][$i]). "</option>";
      }
      echo"</select>";
      ?>
      <fieldset>
      </fieldset>
      <fieldset>
	<legend>Assign Access Right</legend>
	Select One:&nbsp;&nbsp;
	<form name="frmright">
	  <?php
	  $cmdName = "select ACC_RIGHT_ID,ACC_RIGHT_DESC from ACCESS_RIGHT order by ACC_RIGHT_DESC ";
	  $parsed = ociparse($db_conn, $cmdName);
	  ociexecute($parsed);
	  $totalName = ocifetchstatement($parsed, $results);
	  ?>

	  <select name="accright">

	    <?php
	    for ($i=0;$i<$totalName;$i++)
	    {
              echo "<option value=" . $results["ACC_RIGHT_ID"][$i] . ">" . ($results["ACC_RIGHT_DESC"][$i]). "</option>";
	    }
	    echo"</select>";

	    ?>
            <p><div id="access"></div></p>

	    <button style="width:65;height:65" onClick="utility('AssignRight')"><b>Submit</b></button>
        </form>
      </fieldset>


      <fieldset>
	<button style="width:65;height:65" onClick="utility('ResetPassword')"><b>Reset Password</b></button>
	<button style="width:65;height:65" onClick="utility('DeleteUser')"><b>Delete User</b></button>
	<button style="width:65;height:65" onClick="utility('ReActivate')"><b>Re-Activate</b></button>
	    </td>
	  </tr>
	</table>
	<table width="100%" cellpadding="2" cellspacing="2" style="font-family:Verdana; font-size:large; font-weight:bold">
	  <p><div id="accessright"></div></p>
      </fieldset>
      <a title='logout' href='index.php'>Log Out</a>

      <?php
      //close database connection
      oci_close($db_conn);

      //include the header page
      include("footer.php");
      ?>

  </body>
</html>






