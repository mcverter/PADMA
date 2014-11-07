<?php

require_once('../templates/DatabaseConnectionPage.php');

/**
 * Class UserManagementPage
 *
 * This Page allows an Administrator to
 * Manage the PADMA Users by
 * (1) Reset Password
 * (2) Delete User [Set Delete Flag]
 * (3) Activate User [Unset Delete Flag]
 * (4) Change User's Password
 */
class UserManagementPage extends DatabaseConnectionPage {

    const PG_TITLE = "User Management";

    const AJAX_SCRIPT = '../user_admin/UserMgmtAJAX.php';

    // For communication with AJAX Script
    const RESET_USER_PW_COMMAND = 'reset_pw';
    const GET_USER_INFO_COMMAND = 'get_user_info';
    const REACTIVATE_USER_COMMAND = 'reactivate_user';
    const DELETE_USER_COMMAND = 'delete_user';
    const CHANGE_RIGHT_COMMAND = 'update_right';


    // IDs of Widgets which trigger AJAX Events
    const USER_PICKER_ID = "UserPicker";
    const RESET_PW_BUTTON_ID = 'resetBtn';
    const DELETE_BUTTON_ID = 'deleteBtn';
    const REACTIVATE_BUTTON_ID = 'reactivateBtn';
    const ACCESS_RIGHT_BUTTON_ID = 'accessRightBtn';


    // DIVs which change in response to AJAX events
    const FEEDBACK_DIV = 'feedbackMsg';
    const USER_RESULT_DIV = 'userResult';

    /**
     * Checks to make sure Administrator is accessing page
     *
     * @return bool: Whether user has rights to view page
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(PageControlFunctionsAndConsts::ADMINISTRATOR_ROLE);
    }

    /**
     * @Override
     * Prints the Javascript for this page
     *
     * All the activity in this page is run through AJAX transactions
     * (1) When Admin Selects a User, User data is printed
     * (2) When Admin Presses Delete Button, User's Delete Flag is Set
     * (3) When Admin Presses Reactivate Button, User's Delete Flag is unset
     * (4) When Admin Presses Change Passowrd Button, User's Password is Changed and is notified via email
     * (5) When Admin Presses Change Right Button, User's Access Level is altered
     *
     * All of these Changes are enacted by the UserManagementAJAX.php script
     *
     * @return string
     */
    function make_js() {

        $returnString = parent::make_js();

        // create local variables for the sake of easy string interpolation
        list($user_picker_id, $reactivate_button, $delete_button,
            $reset_pw_button, $access_right_button, $reset_pw_command,
            $change_right_select, $change_right_command,
            $get_user_info_command, $reactivate_command, $delete_command,
            $feedback_div, $user_result_div,
            $ajax_script) =
            array(self::USER_PICKER_ID, self::REACTIVATE_BUTTON_ID, self::DELETE_BUTTON_ID,
                self::RESET_PW_BUTTON_ID , self::ACCESS_RIGHT_BUTTON_ID, self::RESET_USER_PW_COMMAND ,
                DBFunctionsAndConsts::ACC_RIGHT_ID_COL, self::CHANGE_RIGHT_COMMAND,
                self::GET_USER_INFO_COMMAND , self::REACTIVATE_USER_COMMAND , self::DELETE_USER_COMMAND,
                self::FEEDBACK_DIV, self::USER_RESULT_DIV,
            self::AJAX_SCRIPT);

        $delete_message = preg_replace('/\n/',' ',WidgetMaker::successMessage('deleteSuccess', "You have successfully deleted this user"));
        $reactivate_message = preg_replace('/\n/',' ', WidgetMaker::successMessage('reactivateSuccess', "You have successfully reactivated this user"));
        $right_message = preg_replace('/\n/',' ', WidgetMaker::successMessage('rightSuccess', "You have successfully updated the access right of this user"));
        $password_message = preg_replace('/\n/',' ', WidgetMaker::successMessage('deleteSuccess', "You have successfully reset the password of this user and sent them an email notifying them of the change"));

        $adminid = $this->userid;

        $returnString .= <<< EOT

<script>
    $(document).ready( function () {
        $('#$user_picker_id').change(function() {
            var selected = this.value;
            $.ajax({
                url: $ajax_script,
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$get_user_info_command', adminID: "$adminid"
                },
                success: function(userData) {
                    $('#$user_result_div').html(userData);
                    $('#$feedback_div').html('');
                }
            });
        });
        $(document).on("click", '#$reactivate_button' ,function() {
            var selected = $('#$user_picker_id').val();
            $.ajax({
                url: $ajax_script,
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$reactivate_command', adminID: "$adminid"
                },
                success: function(userData) {
                    $('#$user_result_div').html(userData);
                    $('#$feedback_div').html('$reactivate_message');
                }
            });
        });
        $(document).on("click", '#$access_right_button' ,function() {
            var selected = $('#$user_picker_id').val();
            var rightLevel = $('#$change_right_select').val();
            if (rightlevel === null) {
                return;
            }
            $.ajax({
                url: $ajax_script,
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$change_right_command', adminID: "$adminid", accessRight: rightLevel
                },
                success: function(userData) {
                    $('#$user_result_div').html(userData);
                    $('#$feedback_div').html('$right_message');
                }
            });
        });
        $(document).on("click", '#$delete_button' ,function() {
            var selected = $('#$user_picker_id').val();
            $.ajax({
                url: $ajax_script,
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$delete_command', adminID: "$adminid"
                },
                success: function(userData) {
                    $('#$user_result_div').html(userData);
                    $('#$feedback_div').html('$delete_message');
                }
            });
        });
        $(document).on("click", '#$reset_pw_button' ,function() {
            var selected = $('#$user_picker_id').val();
            $.ajax({
                url: $ajax_script,
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '$reset_pw_command', adminID: "$adminid"
                },
                success: function(userData) {
                    $('#$user_result_div').html(userData);
                    $('#$feedback_div').html('$password_message');
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
        return $this->make_image_content_columns ($userid, $role, 'N', 8) ;
    }


    /**
     * @Override
     *
     * Makes the main functional content block of the page
     *
     * Shows the User Pick Widget and two empty DIVs for
     *   respeonding to AJAX events.
     *
     * All significant logical activity occurs through jquery
     * in function make_js(), above, and UserMgmtAjax.php
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */
    function make_main_content($userid, $role) {
        $db_conn = $this->db_conn;

        $returnString = '';
        $returnString .=
            WidgetMaker::user_pick_widget('PADMA Users',
                self::USER_PICKER_ID, $db_conn) .
            "<div id='" . self::USER_RESULT_DIV . "'></div>" .
            '<br><br>' .
            '<div id="'. self::FEEDBACK_DIV . '"></div>';
        return $returnString;

    }
}


