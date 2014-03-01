<?php
require ("../templates/WebPage.php");
require ("../widgets/search_widgets.php");

initialize_session();
$db_conn = connect_to_db();
$html_head("Advanced Query");
?>

<body>
  <?php header_widget(); ?>
  <?php list_of_experiment_popup_widget();

  <h2>Advanced Query...</h2>

  <form class="central_widget" action="SearchResults.php" method="post" name="index" onsubmit="return validate(index);">
  <?php advanced_search_widgets($db_conn);
  ?>

  <input name="btn_submit" type="submit" value="Submit" />
  <input type="hidden" name="searchtype" value="Advanced" />
  </form>

  <?php include("footer.php"); ?>
  </body>
  <?php oci_close($db_conn); ?>
  </html>














