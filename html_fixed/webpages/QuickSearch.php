<?php
require ("../templates/WebPage.php");
require ("../widgets/search_widgets.php");

initialize_session();
$db_conn = connect_to_db();
$html_start_head("Quick Search");
?>

<body>
<?php header_widget(); ?>
<?php list_of_experiment_popup_widget();

    <form class="central_widget" action="SearchResult.php" method="post" name="index" onsubmit="return validate(index);">
  <?php quick_search_widgets() ?>

  <input name="btn_submit" type="submit" value="Submit"/>
  <input type="hidden" name="searchtype" value="Quick" />
  </form>

  <?php   include("footer.php"); ?>

  </body>
</html>





