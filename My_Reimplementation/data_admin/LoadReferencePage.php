<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');

class LoaderReferencePage extends DatabaseConnectionPage {
    function __construct() {
        check_role('a');
    }

    function print_js()
    {

        echo <<< EOT
       function validate(index)

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
  </script>

EOT;
    }
function print_content() {


echo <<< EOT
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

EOT;

}
}







