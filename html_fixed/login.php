<?php 
include ("control_functions.php");
initialize_session();
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Log In</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>
    <?php

    include("header.php");

    //unathenticate user when log out
    endUserSession();
    ?>

    <form class="central_widget" action="switchboard.php" method="post">
	<h2> Log in </h2> 
	<hr>
        <fieldset>
	  <label for="userid"> User ID </label>
          <input name="userid" type="text" style="width:90%" />                             
	  <label for="Password1"> Password:</label>
          <input name="Password1" type="PASSWORD" style="width:90%" />          
	</fieldset>
   
          <input type="submit" style="width:65;height:65"  value="Login" />
    </form>
	  
    <div>
      <a title="passwordrecovery" href="PassRecovery.php">Forgot Password</a> 
      <br>
      <a title="newuser" href="terms.php">New User</a>
    </div>
     <?php
      include("footer.php");
      ?>
    </form>
  </body>
</html> 
 
 
 
 
 
 
 
