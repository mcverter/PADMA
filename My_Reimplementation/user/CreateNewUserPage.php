<?php

require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");
require_once(__DIR__ . "/../widgets/FormMaker.php");

class CreateNewUserPage extends  DatabaseConnectionPage {

    function __construct() {}
    function print_content() {
        $db_conn = $this->db_conn;
        FormMaker::make_new_user_form($db_conn);

}







}