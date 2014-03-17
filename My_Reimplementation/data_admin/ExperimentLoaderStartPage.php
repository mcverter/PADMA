<?php
require_once (__DIR__ . "/../templates/DatabaseConnectionPage.php");
class ExperimentLoaderStartPage extends DatabaseConnectionPage {
  function __construct() {}
  function print_js() {
    echo <<<EOT
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

EOT;

}
function print_content() {
  $role = 0;
  echo <<< EOT
  <form   action="expUploader.php" method="POST" name="index" enctype="multipart/form-data" onsubmit="return validate(index);">
  <td ><b><font color="#ffffff">Experiment Data Loading...</font></b></td>
  <td class="_40L">File Name:</td>
  <input name="uploadedfile" type="file" />
  EOT;


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
  echo <<< EOT


			      <input name="Button1" type="submit" value="Verify Data" />
  <td> <p><div id="txtHint"><b></b></div></p> </td>
EOT;
    }
    }












