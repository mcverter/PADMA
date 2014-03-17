<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");



class EditProfilePage extends DatabaseConnectionPage {
    public function __construct() {
        parent::__construct();
        $this->title = "Edit Profile";
    }


    function print_content() {

        if (!isset($_SESSION['userid']) ||
            (empty ($_SESSION['userid']))) {
           header("Location :  index.php");
        }
        $userid = $_SESSION['userid'];
        $db_conn = $this->db_conn;
        PanelMaker::panel_edit_profile();


}

}

?>