<?php
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();
require ("search_widgets.php");
$html_head();
?>

  <body>
    <?php include("header.php"); ?>
    <!-- -
    <div id="GENENAME_bg" class="modalPopupTransparent" style="display: none;"></div>
    <div id="GENENAME" class="/* modalPopupWindow" */ style="display: none; width: 600px;">
    <table class="_100"><tr><td class="_R">
    <a href="javascript:closeModalWindow(1);">X  Close</a>
    </td></tr></table>

    <
    ?php
    $GN="GENENAME";
    printList($GN,$db_conn);
    ?>
    <br>
    </div>
    -->

    <h2>Advanced Query...</h2>

    <form class="central_widget" action="AdvancedQueryResult.php" method="post" name="index" onsubmit="return validate(index);">
<?php

      get_string_widgets($db_conn);
      get_advanced_select_widgets($db_conn);
?>
      <input name="btn_submit" type="submit" value="Submit"/>
    </form>
    </div>

    <?php include("footer.php"); ?>
  </body>
  <?php oci_close($db_conn); ?>
</html>














