<?php
require_once("DatabaseConnectionPage.php");
require_once("DB_Entity.php");

class ExperimentList extends DatabaseConnectionPage {
    function __construct() {
        parent::__construct();
        $this->title = " Experiment List ";
    }

    function print_js() {
        echo <<< EOT

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
EOT;
    }
    function print_content() {
        $db_conn = $this->db_conn;

        echo <<< EOT


<form class="central_widget" name="form1" action="EditDescription.php" method="post">
      <legend>      Select an Experiment:</legend>
      <fieldset>
EOT;

    DB_Entity::make_experiment_list_widget($db_conn);
        echo <<< EOT

      </fieldset>
    </form>
    <div id="txtHint"></div>
EOT;
    }
}

$loe = new ExperimentList();
$loe->display_page();