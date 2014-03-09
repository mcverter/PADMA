<?php
require_once (__DIR__ . "/../templates/DatabaseConnectionPage.php");
class ExploaderStartPage extends DatabaseConnectionPage {
  function __construct() {}
  function print_content() {
      $role=0;

    echo <<<EOT
<!DOCTYPE html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <script  type="text/javascript">
     <!-- hide script from older browsers

     function validate(index)
     {

       //Check if the file name field is empty
       if(""==document.forms.index.uploadedfile.value)
       {
         alert("Please Select a File.");
         return false;
       }
       if(""==document.forms.index.publish.value)
       {
         alert("Please enter Publish Status YES/NO .");
         return false;
       }


     }
     stop hiding script -->
    </script>
  </head>
  <body>
       
EOT;


    if ($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
    {
      echo "<table class='_90small_bold'>";
      echo	"<tr>";
      echo		"<td class='rc'>";
      echo			"<a title='back' href='DataManagement.php'>Back to Data Management</a> <br />";
      echo		"</td>";
      echo	"</tr>";
      echo "</table>";
    }
    else
    {
      echo "&nbsp;<br>";
    }

echo <<< EOT
    <br><br><br>
    <form   action="expUploader.php" method="POST" name="index" enctype="multipart/form-data" onsubmit="return validate(index);">
      <table class="_100">
	<tr>
	  <td class="_20">&nbsp;</td>
	  <td class="_60">
	    <table class="_100color_border">
	      <tr>
		<td>
		  <table class="headerImage">
		    <tr>
		      <td ><b><font color="#ffffff">Experiment Data Loading...</font></b></td>
		    </tr>
		  </table>

		  <br><br><br>
		  <table class="_100pad5">
		    <tr>
		      <td class="_20r">&nbsp;</td>
		      <td class="8lb">
			<table class="_100C_pad5">
			  <tr>
			    <td class="_40L">File Name:</td>
			    <td class="_60L">
			      <input name="uploadedfile" type="file" />
			    </td>
			  </tr>
			  <tr>
			    <?php
			    if($role=="Researcher")
			    {
			      echo "<td class='_30L'>&nbsp;</td>";
			      echo "<td class='_70L'><input name='publish' VALUE='NO' readonly='true' type='hidden' /></td>";
			    }
			    else if($role=="Administrator")
			    {
			      echo "<td class='_30L'>*Publish:</td>";
			      echo "<td class='_70L'><input name='publish' type='text' /><br>(YES,NO)</td>";
			    }
			    ?>
			  </tr>
			  <tr>
			    <td class="_30L">&nbsp;</td>
			    <td class="_70L">
			      <input name="Button1" type="submit" value="Verify Data" />
			    </td>
			  </tr>
			</table>
		      </TD>
		      <td class="_20r">&nbsp;</td>
		      <td> <p><div id="txtHint"><b></b></div></p> </td>
		    </tr>
		  </table>
		  <br><br><br>
		</td>
	      </tr>
	    </table>
	    <td class="_20">&nbsp;</td>
	</tr>
      </table>
    </form>
				      
EOT;
  }
} 
 
 
 
 
 
 
 
 
 
 
 
 
