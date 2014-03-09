<?php
require_once (__DIR__ . "/../templates/DatabaseConnectionPage.php");
require_once (__DIR__ . "/../functions/db_UpdateFunctions.php");



class ConfirmEditDescriptionPage extends DatabaseConnectionPage {
    function __construct(){
      parent::__construct();
      $this->title = " Confirm Description ";
    }
    function print_content() {
        check_role('ar');
        initialize_session();
        $db_conn = $this->db_conn;
	confirm_edit_description($db_conn);
    }
}