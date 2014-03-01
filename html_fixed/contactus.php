<?php
include ("control_functions.php");
initialize_session();
?>


<!DOCTYPE html>
<html>
  <head>
    <title>PADMA: Contact Us</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta charset="utf-8" />
  </head>

  <body>

    <?php include("header.php"); ?>

    <div class="centered_form">
      <p class="instructions">&nbsp;&nbsp;Send your inquiry or problem &#8212; we will respond you!
      </p>
      <form action="FormToEmail.php" method="post">
	<fieldset>
	  <label for="name"> Your Name</label>
	  <input type="text" size="30" id="name"><br>
	  <label for="email">Email address</label>
	  <input type="text" size="30" id="email"><br>
	  <label for="comments"> Comments</label>
	  <textarea id="comments" rows="6" cols="50"></textarea><br>
	</fieldset>
	<input type="submit" value="Send">
      </form>
    </div>
    <?php
    include("footer.php");
    ?>
  </body>

</html>














