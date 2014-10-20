<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/28/14
 * Time: 11:14 AM
 */

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');
require_once(__DIR__ . '/UserManagementConstants.php');



class UserManagementPage extends DatabaseConnectionPage {

    protected  function isAuthorizedToViewPage() {
        return PageControlFunctions::check_role(WebPage::ADMINISTRATOR_ROLE);
    }



    function get_title() {
        return "User Management";
    }
    function make_js() {

        $returnString = parent::make_js();

        list($user_picker_class, $reactivate_button, $delete_button, $reset_pw_button, $hidden_cid_id,
            $reset_pw_command, $get_user_info_command, $reactivate_command, $delete_command) =
            array(UserManagementConstants::USER_PICKER_CLASS, UserManagementConstants::REACTIVATE_BUTTON_ID,
                UserManagementConstants::DELETE_BUTTON_ID, UserManagementConstants::RESET_PW_BUTTON_ID ,
                UserManagementConstants::CID_HIDDEN_ID, UserManagementConstants::RESET_USER_PW_COMMAND ,
                UserManagementConstants::GET_USER_INFO_COMMAND ,
                UserManagementConstants::REACTIVATE_USER_COMMAND , UserManagementConstants::DELETE_USER_COMMAND);
        $userid = $this->userid;


        $returnString .= <<< EOT

<script>
        $(document).ready( function () {
            $('.$user_picker_class').change(function() {
                var selected = this.value;
                $('#$hidden_cid_id').value(selected);
                $.ajax({
                url: '../user_admin/UserMgmtAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$get_user_info_command', adminID: "$userid"
                },
                success: function(userData) {
                    console.log(" Data", userData);
                    $('#userResult').html(userData);
                }
            });
        });
            $('.$reactivate_button').click(function() {

                var cid = $('.$hidden_cid_id').value;
                $.ajax({
                url: '../user_admin/UserMgmtAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$reactivate_command', adminID: "$userid}"
                },
                success: function(userData) {
                    console.log(" Data", userData);
                }
            });
        });
            $('.$delete_button').click(function() {
                var selected = this.value;
                var cid = $('.$hidden_cid_id').value;
                console.log(selected);
                $.ajax({
                url: '../user_admin/UserMgmtAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$delete_command', adminID: "$userid}"
                },
                success: function(userData) {
                    console.log(" Data", userData);
                    $('#userResult').html(userData);
                }
            });
        });
            $('$reset_pw_button').click(function() {
                var selected = this.value;
                console.log(selected);
                $.ajax({
                url: '../user_admin/UserMgmtAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$reset_pw_command', adminID: "$userid"
                },
                success: function(userData) {
                }
            });
        });
        });
</script>

EOT;
    return $returnString;
    }
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

    function make_main_frame($title, $userid, $role) {
        $db_conn = $this->db_conn;

        $returnString = '';
        $returnString .=
            wMk::user_pick_widget('Existing Users', 'existingUsers', $db_conn, UserManagementConstants::USER_PICKER_CLASS) .
            "<div id='userResult'></div>";


        return $returnString;

    }
}


