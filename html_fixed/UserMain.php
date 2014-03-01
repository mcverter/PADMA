<?php
include ("control_functions.php");
initialize_session();
$userid=strtoupper($_SESSION['userid']);
?>


<!DOCTYPE html>
<html>
  <head>
    <title>PADMA: Welcome! </title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta charset="UTF-8">
  </head>
  <body>

    <?php
    include ("user_widgets.php");
    update_profile_widget();
    search_widgets();
    ?>

    <?php
    //close database connection
    oci_close($db_conn);
    //include the header page
    include("footer.php");
    ?>
  </body>
</html>


