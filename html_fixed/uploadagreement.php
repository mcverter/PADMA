<?php
include ("control_functions.php");
initialize_session();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>
    <?php include("header.php");  ?>

    <div class="instructions">
      PLEASE READ THE FOLLOWING TERMS OF USE BEFORE UPLOADING TO THE
      PATHOGEN ASSOCIATED DROSOPHILA  MICROARRAY (PADMA) DATABASE.
    </div>
    <div>
      <h2>Data Submission to PADMA Database</h2>
      <ol>
	<li>The dataset ("Dataset") I will upload for inclusion in the PADMA database is my work product.</li>
	<li>Incorporation of my Dataset into the
	  PADMA database will not violate any rights
	  of any kind or nature whatsoever of any
	  third party.</li>
	<li>I have the full right, power and
	  authority to make this submission to the
	  PADMA database maintained by The City
	  College of New York.</li>
	<li>My agreement to these terms of use is
	  in addition to the intellectual property
	  and ownership notice as wall as disclaimer
	  and limitation of liability agreed at
	  my user registration.</li>
      </ol>
      <h2>Instruction</h2>
      <p>If you have an administrative account, you may select either "local" or "global" option when you upload your Dataset. The local
	option will limit the access of the uploaded Dataset only to your account, whereas the global
	option will allow the access for anyone registered to and active in the PADMA system. </p>
    </div>


    <form class="central_widget"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

      <label> <input type="radio" name="terms" value="agree" />Agree</label>
      <label> <input type="radio" name="terms" value="disagree" checked />Disagree</label>
      <input type="submit" value="Submit" />

      <?php
      if (isset($_POST['terms'])) {
	if ($_POST['terms'] == "agree") header("Location: expLoaderStart.php");
	else header("Location: DataManagement.php");
	exit;
      }
      ?>
    </form>

    <?php
    //include the header page
    include("footer.php");
    ?>
  </body>
</html>








