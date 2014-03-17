<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class CreateProfilePage extends DatabaseConnectionPage {

    function print_content() {
        $userid=strtoupper($_SESSION['userid']);

        if ($userid == "undefined") {
            echo <<< EOT
  <font color='red'>
  <b>ERROR: undefined user ID (internal logic error), please contact PADMA administrator.</b>
  </font>
  <br /><a title='logout' href='index.php'>Click Here</a> to go back to home page
EOT;
            $db_conn = $this->db_conn;
            FormMaker::make_create_profile_form($db_conn);

}




    }
}