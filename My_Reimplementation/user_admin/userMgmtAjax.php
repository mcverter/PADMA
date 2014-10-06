<?php
$command = $_POST['command'];
$adminID = $_POST['adminid'];
$cid = $_POST['cid'];
$date = DBFunctions::now();
$db_conn = $_POST['db_conn'];



switch($command) {
    case 'assignRight':
        $accessRight = $_POST['accessRight'];
        DBFunctions::updateUserRight($db_conn, $cid, $accessRight, $adminID, $date) ;
        break;
    case 'deleteUser':
        DBFunctions::deleteUser($db_conn, $cid, $adminID, $date);
        break;
    case 'reactivate':
        DBFunctions::updateUserActivation($db_conn, $cid, $adminID, $date);
         break;
}





/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/4/14
 * Time: 4:45 PM

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

function resetPassword($cid) {
$temppass=generatePassword(6,8);
update_password($cid, sha1($temppass));
}
function viewUserDetail($clientid) {
selectUserInfo($clientid);
}


function __construct() {

}

function print_content() {
}
}



 */


