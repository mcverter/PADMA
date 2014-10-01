<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/28/14
 * Time: 11:14 AM
 */

class UserManagementPage {
    function getNewUser() {
        selectNewUserList();
    }
    function getExistingUser() {
        selectExistingUserList();
    }

    function getAccessRightList() {
        selectAccessRightList();
    }
    function assignUserRight($cid, $accessright, $createdby, $date){
        updateUserRight($cid, $accessright, $createdby, $date) ;
    }

    function exec_deleteUser($cid, $updatedby, $date)
    {
        deleteUser($cid, $updatedby, $date);
    }

    function reactivateUser($cid, $updatedby, $date) {
        updateUserActivation ($cid, $updatedby, $date);
    }

    function resetPassword($cid) {
        $temppass=generatePassword(6,8);
        update_password($cid, sha1($temppass));
    }
    function viewUserDetail($clientid) {
        selectUserInfo($clientid);
    }
}

