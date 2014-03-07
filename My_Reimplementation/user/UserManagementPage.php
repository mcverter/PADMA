<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");
require_once(__DIR__ . "/../widgets/DB_WidgetMaker.php");

class UserManagementPage extends DatabaseConnectionPage {

    function __construct() {
        parent::__construct();
        check_role('a');
        $this->title=" User Management ";
    }

    
    function print_content() {

        error_log(print_r($_SESSION, true));
    $db_conn = $this->db_conn;
        echo <<< EOT
     <h2>User Management</h2>
      <fieldset>
      <legend><font color="#4682B4">New User </font></legend>
EOT;

    DB_WidgetMaker::make_new_users_widget($db_conn);

        echo <<< EOT

    <fieldset>
      <legend>Existing Users</legend>
EOT;
        DB_WidgetMaker::make_existing_users_widget($db_conn);

        echo <<< EOT

    </fieldset>

    <fieldset>
	    <legend>Assign Access Right</legend>
    Select One:&nbsp;&nbsp;

   <form name="frmright">

EOT;
//    make_access_right_widget();

        echo <<< EOT

    <p><div id="access"></div></p>

    < button style="width:65;height:65" onClick="utility('AssignRight')"><b>Submit</b></button>
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

EOT;
    }

    function print_js() {
        echo <<< EOT
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

EOT;

    }

}

$ump = new UserManagementPage();
$ump->display_page();

?>



