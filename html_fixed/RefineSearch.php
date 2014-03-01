<?
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();
?>


<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta charset="utf-8">
    <script  src="js/prototype.js"></script>
    <script  src="js/modalPopup.js"></script>
  </head>
  <body>
    <?php include("header.php"); ?>



    <!-- -
    <div id="GENENAME_bg" class="modalPopupTransparent" style="display: none;"></div>
    <div id="GENENAME" class="modalPopupWindow" style="display: none; width: 600px;">
    <table class="_100"><tr><td class="_R">><a href="javascript:closeModalWindow(1);">X  Close</a></td></tr></table>

    <
    ?php
    $GN="GENENAME";
    printList($GN,$db_conn);
    ?>
    <br>
    </div>

    -->

    <h2>Refine Search...</h2>
    <form  class="central_widget" action="RefineSearchResult.php" method="post" name="index">
      <fieldset>
	<br>
      <?php  get_string_widgets(); ?>
      </fieldset>
      <input name="btn_submit" type="submit" value="Submit"/>
    </form>


    <?php
    //close database connection
    oci_close($db_conn);
    //include the header page
    include("footer.php");
    ?>

  </body>
</html>









