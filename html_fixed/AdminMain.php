<?php
include ("control_functions.php");
check_role('a');
initialize_session();
$db_conn = connect_to_db();
$userid=strtoupper($_SESSION['userid']);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta charset="UTF-8">
  </head>
  <body>

    <?php include ("header.php"); ?>

    <div class="central_widget">
      <?php
      include ("user_widgets.php");
      update_profile_widget();
      user_mgmt_widget();
      data_mgmt_widget();
      search_widgets();
      ?>
    </div>

    <?php include("footer.php"); ?>
  </body>
</html>


