<?php
require_once (__DIR__ . "/../templates/DatabaseConnectionPage.php");
require_once (__DIR__ . "/../functions/db_DeleteFunctions.php");

class DeleteReferencePage extends DatabaseConnectionPage {
    function __construct() {check_role('a');
      parent::__construct();
      $this->title = " Delete Reference ";
    }
    function print_content() {
      $db_conn = $this->db_conn;
      delete_reference($db_conn);


echo <<< EOT

     <form name="form1" action="" method="post">
      <fieldset>
	<b>(Select a Version to delete)</b><br>
 
      </fieldset>
    </form>
EOT;
    }
}











