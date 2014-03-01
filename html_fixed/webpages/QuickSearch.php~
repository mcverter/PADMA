<?php
include("control_functions.php");
initialize_session();
$db_conn=connect_to_db();
error_log("DB CONN IS " . $db_conn . "\n");

include("utility.php");
$userid=strtoupper($_SESSION['userid']);

require_once("search_widgets.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title> PADMA: Quick Search </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <script  src="js/prototype.js"></script>
    <script  src="js/modalPopup.js"></script>


    <script  type="text/javascript">
     function validate(index)
     {
       //Check if a search criteria is checked
       var found_it=null
       for (var i=0; i<document.forms.index.searchCriteria.length; i++)  {
	 if (document.forms.index.searchCriteria[i].checked)  {
	   found_it = document.forms.index.searchCriteria[i].value //set found_it equal to checked button's value
	 }
       }
       if(found_it != null){}
       else{
	 alert("Please select a search criteria.");
	 return false;
       }
       //Check if the search field is empty
       if(""==document.forms.index.txt_searchToken.value)
       {
         alert("Please enter a valid search string.");
         return false;
       }

     }
    </script>
  </head>
  <body>

    <?php include("header.php"); ?>

    <!-- -
    <div id="GENENAME_bg" class="modalPopupTransparent" style="display: none;"></div>
    <div id="GENENAME" class="modalPopupWindow" style="display: none; width: 600px;">
      <table class="_100"><tr><td class="_R">><a href="javascript:closeModalWindow(1);">X  Close</a></td></tr></table>

      <? php
      $GN="GENENAME";
     printList($GN,$db_conn);
      ? >
      <br>
    </div>
 -->

    <form class="central_widget" action="QuickSearchResult.php" method="post" name="index" onsubmit="return validate(index);">
      <fieldset>
	<legend> Quick Search </legend>
	<h3> Search Criteria</h3>

	<small>Search String</small>
	<input type="radio" name="searchCriteria" value="PROBEID">Prob ID<br>
	<input type="radio" name="searchCriteria" value="CGNUMBER">CG Number<br>
	<input type="radio" name="searchCriteria" value="GENENAME">Gene Name&nbsp;&nbsp;(<a href="javascript:openModalWindow(1);">list</a>)
	<input name="txt_searchToken" type="text" style="width: 150px" />
	<br>(example: aaa,bbb,ccc)
      </fieldset>
      <div>
	<br>
	<fieldset>
      get_quick_search_widgets();
	</fieldset>
      </div>

      <input name="btn_submit" type="submit" value="Submit"/>
    </form>

    <?php   include("footer.php"); ?>
  </body>
</html>

<?php
    //include("session_maintenance.php");
//save_search_Qvars($EXP_NAME, $CATG, $SPEC, $SUBJ, $REG_VAL);
?>








