<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");


class DeleteExperiment extends DatabaseConnectionPage {

  function __construct() {
        check_role('ar');
	parent::__construct();
  }

    function print_content() {
        $db_conn = $this->db_conn;
//        $expName;
        if (isset ($_POST['exp_name']) &&
            !empty ($_POST['exp_name'])) {
            $expName=$_POST['exp_name'];
            DB_ENTITY::delete_Experiment($db_conn, $expName);
        }
        else {
            echo<<< EOT
     <form name="form1" action="deleteExperiment.php" method="post">
      <fieldset>
 	    <h2>Select an Experiment to delete</h2>
EOT;
            $exp_Name->make_select_widget();

            echo<<< EOT
        </fieldset>
        <input type="submit" value="Submit">
        </form>
EOT;
        }
    }
}












