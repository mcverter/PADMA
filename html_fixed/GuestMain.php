<?php
include ("control_functions.php");
initialize_session();
?>


<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <meta charset="UTF-8">
  </head>
  <body>
    <h2> Select One ... </h2>

    <?php
    include ("user_widgets.php");
    search_widgets();
    ?>

    <?php
    //include the header page
    include("footer.php");
    ?>
  </body>
</html>


