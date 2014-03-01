<?php
include ("control_functions.php");
check_role('ar');
initialize_session();
$db_conn=connect_to_db();
$userid=strtoupper($_SESSION['userid']);
?>



<!DOCTYPE html>
<html>

  <?php

  $userid=strtoupper($_SESSION['userid']);


  //delete experiment when delete button is clicked
  $exprimentName=$_POST['exp_name'];
  $cmdstr = "delete from EXPERIMENT where EXP_NAME='".$exprimentName."'";
  $cmdstr2 = "delete from EXP_MASTER where EXP_NAME='".$exprimentName."'";
  $parsed = ociparse($db_conn, $cmdstr);
  ociexecute($parsed);
  $parsed = ociparse($db_conn, $cmdstr2);
  ociexecute($parsed);

  ?>

  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>
    <?php
    //include the header page
    include("header.php");
    ?>

    <form name="form1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      <fieldset>
	<h2>(Select an Experiment to delete)</h2>

	<?php delete_experiment_administrator() ?>
      </fieldset>
      <?php include("footer.php"); ?>
    </form>
  </body>
</html>


<?php oci_close($db_conn); ?>











