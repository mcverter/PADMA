<?php
include ("control_functions.php");
check_role('ar');
initialize_session();
$db_conn=connect_to_db();
$userid=strtoupper($_SESSION['userid']);
?>


<!DOCTYPE html>

<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>

    <?php include("header.php"); ?>

    <table class="headerImage"></table>
    <h2>Select One...</h2>
    <fieldset>
      <?php
      if ($role=="Researcher")
      {
	load_experiment_researcher();
	delete_researcher_widget();
	edit_researcher_widget();
      }

      if ($role=="Administrator")
      {

	load_reference_data_widget();
	delete_reference_data_widget();
	load_experiment_researcher();
	delete_administrator_widget();
	edit_administrator_widget();
      }

      ?>

    </fieldset>
    <table class="footerImage">
    </table>
    <?php
    //close database connection
    oci_close($db_conn);
    //include the header page
    include("footer.php");
    </body>
    </html>














