<?php


list($user_picker_class, $reactivate_button, $delete_button, $reset_pw_button, $hidden_cid_id,
    $reset_pw_command, $get_user_info_command, $reactivate_command, $delete_command) =
    array(UserManagementConstants::USER_PICKER_CLASS, UserManagementConstants::REACTIVATE_BUTTON_ID,
        UserManagementConstants::DELETE_BUTTON_ID, UserManagementConstants::RESET_PW_BUTTON_ID ,
        UserManagementConstants::CID_HIDDEN_ID, UserManagementConstants::RESET_USER_PW_COMMAND ,
        UserManagementConstants::GET_USER_INFO_COMMAND ,
        UserManagementConstants::REACTIVATE_USER_COMMAND , UserManagementConstants::DELETE_USER_COMMAND);
$userid = $this->userid;


?>


<script>
    $(document).ready( function () {
        $('.{$user_picker_class}').change(function() {
            var selected = this.value;
            $('#{$hidden_cid_id}').value(selected);
            $.ajax({
                url: '../user_admin/UserMgmtAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '{$get_user_info_command}', adminID: "$userid"
                },
                success: function(userData) {
                    console.log(" Data", userData);
                    $('#userResult').html(userData);
                }
            });
        });
        $('.{$reactivate_button}').click(function() {

            var cid = $('.{$hidden_cid_id}').value;
            $.ajax({
                url: '../user_admin/UserMgmtAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '{$reactivate_command}', adminID: "{$userid}"
                },
                success: function(userData) {
                    console.log(" Data", userData);
                }
            });
        });
        $('.{$delete_button}').click(function() {
            var selected = this.value;
            var cid = $('.{$hidden_cid_id}').value;
            console.log(selected);
            $.ajax({
                url: '../user_admin/UserMgmtAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '{$delete_command}', adminID: "{$userid}"
                },
                success: function(userData) {
                    console.log(" Data", userData);
                    $('#userResult').html(userData);
                }
            });
        });
        $('{$reset_pw_button}').click(function() {
            var selected = this.value;
            console.log(selected);
            $.ajax({
                url: '../user_admin/UserMgmtAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    cid: selected, command: '{$reset_pw_command}', adminID: "$userid"
                },
                success: function(userData) {
                }
            });
        });
    });
</script>
