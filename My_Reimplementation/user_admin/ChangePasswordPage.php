<?php

require_once(__DIR__ . '/../page_templates/DatabaseConnectionPage.php');


class ChangePasswordPage extends DatabaseConnectionPage
{

    function print_js() {
        echo <<< EOT
        <script type="text/javascript" src="../js/gvalidator.js"></script>
EOT;

    }
    function checkPasswordMatch($password)
    {
        DBFunctions::selectUserByIDAndPW($this->db_conn,
            strtoupper($this->userid), sha1($password));
    }

    function __construct() {

    }
    function print_content() {
        $userid = $this->userid;
        $db_conn = $this->db_conn;

        if ($_POST['submitted']) {
            $newpass = $_POST['newpass'];
            DBFunctions::updateUserPassword($db_conn, strtoupper($userid), sha1($newpass));
        }
        else {
            $actionUrl = $_SERVER['PHP_SELF'];
            echo "User Id : $userid" .
                WidgetMaker::start_form($actionUrl, 'gform') .
                WidgetMaker::text_input('Old Password', 'oldpass', '') .
                WidgetMaker::text_input('New Password', 'newpass', '', 'password') .
                WidgetMaker::text_input('Confirm Password', 'confirmpass', '', 'confirmpass') .
                WidgetMaker::end_form();
        }
    }
}
