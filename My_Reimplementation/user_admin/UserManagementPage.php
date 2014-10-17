<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/28/14
 * Time: 11:14 AM
 */

require_once(__DIR__ . '/../page_templates/DatabaseConnectionPage.php');
require_once(__DIR__ . '/UserManagementConstants.php');



class UserManagementPage extends DatabaseConnectionPage {

  function make_page_middle($title, $userid, $role){
    return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
      }
    function generatePassword($minlength, $maxlength) {

    }

    function resetPassword($cid) {
        $temppass=$this->generatePassword(6,8);
        dbFn::updateUserPassword($this->db_conn, $cid, sha1($temppass));
    }
    function viewUserDetail($clientid) {
        DBFUnctions::selectUserInfo($this->db_conn, $clientid);
    }


    function __construct() {
        parent::__construct();

    }

    function make_main_frame($title, $userid, $role) {
        $db_conn = $this->db_conn;

        $returnString = '';
        $returnString .=
            wMk::user_pick_widget('Existing Users', 'existingUsers', dbFn::selectExistingUserList($db_conn), UserManagementConstants::USER_PICKER_CLASS) .
            wMk::user_pick_widget('New Users', 'newUsers', dbFn::selectNewUserList($db_conn),  UserManagementConstants::USER_PICKER_CLASS) .
            "<div id='userResult'></div>";


        return $returnString;

    }
}


