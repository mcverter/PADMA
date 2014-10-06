<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/28/14
 * Time: 11:14 AM
 */

require_once(__DIR__ . '/../page_templates/DatabaseConnectionPage.php');

class UserManagementPage extends DatabaseConnectionPage {

    function generatePassword($minlength, $maxlength) {

    }

    function resetPassword($cid) {
        $temppass=$this->generatePassword(6,8);
        DBFunctions::updateUserPassword($this->db_conn, $cid, sha1($temppass));
    }
    function viewUserDetail($clientid) {
        DBFUnctions::selectUserInfo($this->db_conn, $clientid);
    }


    function __construct() {

    }

    function print_js () {
        echo <<< EOT
        $('#existingUsers').change(function() {

        });
EOT;

    }
    function print_content() {
        $db_conn = $this->db_conn;
        echo WidgetMaker::select_input('Existing Users', 'existingUsers', DBFunctions::selectExistingUserList($db_conn),
            'C_ID') .
            WidgetMaker::select_input('New Users', 'newUsers', DBFunctions::selectNewUserList($db_conn), 'C_ID') .
            WidgetMaker::select_input('New Users', 'newUsers', DBFunctions::selectNewUserList($db_conn), 'C_ID') ;

;

    }
}

