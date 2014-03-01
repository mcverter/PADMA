<?php
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();
//get session variabe
$db_UN = "drosophilarc1";           //username
$db_PASS= "drosopivot";           //password
$db_DB= "//127.0.0.1/XE";      //database name


include("utility.php");

?>


<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload file</title>
  </head>
  <body>
    <?php include("header.php"); ?>





    <?php
    $cmdstr = "select *  from client";
    $parsed = ociparse($db_conn, $cmdstr);
    ociexecute($parsed);
    $total = ocifetchstatement($parsed, $results);

    for ($i = 0; $i < $total; $i++) {
      foreach ($results as $data) {
        echo "$data[$i] ,";
      }
      echo "<br>";
    }


    ?>
  </body>
</html> 
 
 
 
 
 
 
