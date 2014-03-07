<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');

class EditDescriptionPage extends DatabaseConnectionPage {
    function __construct() {
        check_role('a');
    }

    function print_content() {
        $ExpName = isset($_POST['expName'])? $_POST['expName'] : "";
        if (empty($ExpName)) {
            echo "ERROR: logic error";
            exit;
        }
        echo <<< EOT
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
  	    <?php

	    static function make_edit_description_widget ($db_conn, $userid) ;
	    //close database connection
	    oci_close($db_conn);
	    //include the header page
	    include("footer.php");
	    ?>
	  </form>
	</div>
EOT;

    }
}










