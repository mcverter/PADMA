<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');
require_once(__DIR__ . '/UserManagementConstants.php');

/**
 * Class UserManagementPage
 */
class UserManagementPage extends DatabaseConnectionPage {


    const PG_TITLE = "User Management";

    /**
     * @return bool
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(pgFn::ADMINISTRATOR_ROLE);
    }

    /**
     * @return string
     */
    function make_js() {

        $returnString = parent::make_js();

        list($user_picker_id, $reactivate_button, $delete_button, $reset_pw_button, $access_right_button,
            $reset_pw_command, $get_user_info_command, $reactivate_command, $delete_command) =
            array(UserManagementConstants::USER_PICKER_ID, UserManagementConstants::REACTIVATE_BUTTON_ID,
                UserManagementConstants::DELETE_BUTTON_ID, UserManagementConstants::RESET_PW_BUTTON_ID ,
                UserManagementConstants::ACCESS_RIGHT_BUTTON_ID,
                UserManagementConstants::RESET_USER_PW_COMMAND , UserManagementConstants::GET_USER_INFO_COMMAND ,
                UserManagementConstants::REACTIVATE_USER_COMMAND , UserManagementConstants::DELETE_USER_COMMAND);
        $userid = $this->userid;


        $returnString .= <<< EOT

<script>
    $(document).ready( function () {
        $('#$user_picker_id').change(function() {
            var selected = this.value;
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
        $(document).on("click", '#$reactivate_button' ,function() {

            selected = $('#$user_picker_id').val();
            $.ajax({
                url: '../user_admin/UserMgmtAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$reactivate_command', adminID: "$userid}"
                },
                success: function(userData) {
                    console.log(" Data", userData);
                    $('#userResult').html(userData);
                }
            });
        });
        $(document).on("click", 'access_right_button' ,function() {

        });

        $(document).on("click", '#$delete_button' ,function() {
            selected = $('#$user_picker_id').val();
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
        $(document).on("click", '#$reset_pw_button' ,function() {
            selected = $('#$user_picker_id').val();
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

    /**
     * @Override
 * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
  function make_page_middle($userid, $role){
    return $this->make_image_content_columns ($userid, $role, 'R', 8) ;
      }

    /**
     * @param $minlength
     * @param $maxlength
     */
    function generatePassword($minlength, $maxlength) {

    }

    /**
     * @param $cid
     */
    function resetPassword($cid) {
        $temppass=$this->generatePassword(6,8);
        dbFn::updateUserPassword($this->db_conn, $cid, sha1($temppass));
    }

    /**
     * @param $userid
     * @param $role
     * @return string
     */
    function make_main_content($userid, $role) {
        $db_conn = $this->db_conn;

        $returnString = '';
        $returnString .=
            wMk::user_pick_widget('PADMA Users',
                UserManagementConstants::USER_PICKER_ID, $db_conn) .
            "<div id='userResult'></div>";


        return $returnString;

    }
}


