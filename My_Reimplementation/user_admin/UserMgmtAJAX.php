<?php
/***
 *
 */
require_once(__DIR__ . "/../functions/DBFunctions.php");
require_once(__DIR__ . "/../components/WidgetMaker.php");
require_once(__DIR__ . "/UserManagementConstants.php");

$command = $_POST['command'];
$adminID = $_POST['adminID'];
$cid = $_POST['cid'];

$date = dbFn::now();
$db_conn = dbFn::connect_to_db();

/**
 * @param $db_conn
 * @param $cid
 */
function ajaxReturnUserInfo($db_conn, $cid) {
    $db_result = dbFn::selectProfileInfoByCID($db_conn, $cid);
    $row = oci_fetch_assoc($db_result);
    echo makeUserInfoWidget($row);
}

/**
 *
 */
switch($command) {
    case UserManagementConstants::GET_USER_INFO_COMMAND:
        ajaxReturnUserInfo($db_conn, $cid);
        break;
    case UserManagementConstants::CHANGE_RIGHT_COMMAND:
        $accessRight = $_POST['accessRight'];
        dbFn::updateUserRight($db_conn, $cid, $accessRight, $adminID, $date) ;
        ajaxReturnUserInfo($db_conn, $cid);
        break;
    case UserManagementConstants::DELETE_USER_COMMAND:
        dbFn::deleteUser($db_conn, $cid, $adminID, $date);
        ajaxReturnUserInfo($db_conn, $cid);
        break;
    case UserManagementConstants::REACTIVATE_USER_COMMAND:
        dbFn::updateUserActivation($db_conn, $cid, $adminID, $date);
        ajaxReturnUserInfo($db_conn, $cid);
        break;
}

/**
 * @param $userRow
 * @return string
 */
function makeUserInfoWidget($userRow) {

    global $db_conn;

    list ($cid, $padmaUserId, $title, $lname, $fname, $mname,
        $add1, $add2, $city, $state, $zip,
        $phone, $email, $industry, $profession,
        $accessRight, $deleteflag) =
        array(
            $userRow['C_ID'], $userRow['USER_ID'], $userRow['TITLE'], $userRow['LNAME'], $userRow['FNAME'],  $userRow['MNAME'],
            $userRow['ADD_1'], $userRow['ADD_2'], $userRow['CITY'], $userRow['STATE'],$userRow['ZIP'],
            $userRow['PHONE'], $userRow['EMAIL'], $userRow['IND'], $userRow['PROF'],
            $userRow['RIGHT'], $userRow['DEL_FLAG']
        );
    $deleteOutput = $deleteflag == 1 ? "0 - Inactive User" : "1 - Active User";
    $returnString = '';
    $returnString .= wMk::start_horizontal_d_list("User Information", "userinfo") .
        wMk::d_list_entry("User ID:", $padmaUserId) .
        wMk::d_list_entry("Title:",  $title) .
        wMk::d_list_entry("Last Name:", $lname) .
        wMk::d_list_entry("First Name:",  $fname) .
        wMk::d_list_entry("Middle Initial:", $mname) .
        wMk::d_list_entry("Address:", $add1) .
        wMk::d_list_entry("Address 2:",  $add2) .
        wMk::d_list_entry("City:", $city) .
        wMk::d_list_entry("State:",  $state) .
        wMk::d_list_entry("Zip Code:",  $zip) .
        wMk::d_list_entry("Phone:",  $phone) .
        wMk::d_list_entry("Email:",  $email ) .
        wMk::d_list_entry("Company:",  $industry ) .
        wMk::d_list_entry("Profession:",  $profession ) .
        wMk::d_list_entry("Access Right:",  $accessRight ) .
        wMk::d_list_entry("Delete Flag:",  $deleteOutput);
    $returnString .=  wMk::access_right_panel($db_conn, UserManagementConstants::ACCESS_RIGHT_BUTTON_ID) .
        '\n<br>\n' .
        wMk::button_ajax(UserManagementConstants::RESET_PW_BUTTON_ID , 'Reset Password') .
        '\n<br>\n' .
        wMk::button_ajax(UserManagementConstants::DELETE_BUTTON_ID, 'Delete User') .
        '\n<br>\n' .
        wMk::button_ajax(UserManagementConstants::REACTIVATE_BUTTON_ID, 'Reactivate User') ;

    return $returnString;

}

