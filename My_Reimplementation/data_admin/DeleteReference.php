<?php
include ("control_functions.php");
check_role('a');
$db_conn=initialize_session();
connect_to_db();
$userid=strtoupper($_SESSION['userid']);
?>


<?php

$userid=strtoupper($_SESSION['userid']);

//delete experiment when delete button is clicked
$version=$_POST['version'];
$cmdstr = "delete from REFERENCE_MAIN where VERSION='".$version."'";
$cmdstr2 = "delete from REFERENCE_GO where VERSION='".$version."'";
$cmdstr3 = "delete from REFERENCE_BIO where VERSION='".$version."'";
//echo $cmdstr;
$parsed = ociparse($db_conn, $cmdstr);
ociexecute($parsed);
$parsed = ociparse($db_conn, $cmdstr2);
ociexecute($parsed);
$parsed = ociparse($db_conn, $cmdstr3);
ociexecute($parsed);


?>

<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>

    <?php include("header.php"); ?>
    <form name="form1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      <fieldset>
	<b>(Select a Version to delete)</b><br>
 
      </fieldset>
    </form>
    <?php include("footer.php"); ?>
  </body>
</html>

<?php  oci_close($db_conn); ?>












