<?php
include ("control_functions.php");
initialize_session();
$userid=$_POST['userid'];
$db_conn =    connect_to_db()
?>


<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css" type="text/css" />

  </head>
  <body>
    <?php
    include("header.php");
    require("buildExperimentQuery.php");

$query = build_query();
display_results();
allow_export_results();
    //close database connection
    oci_close($db_conn);
    ?>
  </body>
</html>