<?php
include ("control_functions.php");
check_role('a');
initialize_session();
$db_conn = connect_to_db();
$userid=strtoupper($_SESSION['userid']);
?>


<!DOCTYPE html>
<head>
  <title>PADMA: Load Reference Data </title>
  <link rel="stylesheet" href="css/style.css" type="text/css" />


  <script  type="text/javascript">
   <!-- hide script from older browsers

   function validate(index)
   {
     //Check if the version field is empty
     if(""==document.forms.index.version.value)
     {
       alert("Please enter a Valid Version Number.");
       return false;
     }

     //Check if the file name field is empty
     if(""==document.forms.index.uploadedfile.value)
     {
       alert("Please enter a Valid File Name.");
       return false;
     }



   }
   stop hiding script -->
  </script>
</head>
<body>
  <?php
  //include the header page
  include("header.php");
  ?>
  <div class="nav_prev">
    <a title='back' href='DataManagement.php'>Back to Data Management</a> <br />
  </div>


  <form  class="central_widget"  action="uploader.php" method="POST" name="index" enctype="multipart/form-data" onsubmit="return validate(index);">
    <heading>Reference Data Loading...</heading>
    <fieldset>
      <div>
	<label for="version">Version Number:</label>
	<input name="version" type="text" />
      </div>
      <div>
	<label for="uploadedfile"> File Name:</label>
	<input name="uploadedfile" type="file" />
      </div>
    </fieldset>
    <input name="Button1" type="submit" value="Verify Data" />
    <p><div id="txtHint"><b></b></div>
  </form>
</body>
</html>









