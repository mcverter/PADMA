<?php
include ("control_functions.php");
initialize_session();

//unathenticate user when log out
$_SESSION['role']="NOTAUTHORIZED";
unset($_SESSION['userid']);

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Log Out</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>
  <?php  include("header.php");  ?>


    <fieldset>
      <h2> Log in </h2>
      <hr>
      You are now logged out.
    <?php
      //include the header page
      include("footer.php");
      ?>
  </body>
</html>







