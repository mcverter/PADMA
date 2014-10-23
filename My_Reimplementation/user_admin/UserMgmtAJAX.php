<?php

require_once(__DIR__ . "/../functions/DBFunctions.php");
require_once(__DIR__ . "/../components/WidgetMaker.php");
require_once(__DIR__ . "/UserManagementConstants.php");

$command = $_POST['command'];
$adminID = $_POST['adminID'];
$cid = $_POST['cid'];

$date = dbFn::now();
$db_conn = dbFn::connect_to_db();


function ajaxReturnUserInfo($db_conn, $cid) {
    $db_result = dbFn::selectProfileInfoByCID($db_conn, $cid);
    $row = oci_fetch_array($db_result);
    echo makeUserInfoWidget($row);
}

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
    $returnString .= WidgetMaker::start_horizontal_d_list("User Information", "userinfo") .
        WidgetMaker::d_list_entry("User ID:", $padmaUserId) .
        WidgetMaker::d_list_entry("Title:",  $title) .
        WidgetMaker::d_list_entry("Last Name:", $lname) .
        WidgetMaker::d_list_entry("First Name:",  $fname) .
        WidgetMaker::d_list_entry("Middle Initial:", $mname) .
        WidgetMaker::d_list_entry("Address:", $add1) .
        WidgetMaker::d_list_entry("Address 2:",  $add2) .
        WidgetMaker::d_list_entry("City:", $city) .
        WidgetMaker::d_list_entry("State:",  $state) .
        WidgetMaker::d_list_entry("Zip Code:",  $zip) .
        WidgetMaker::d_list_entry("Phone:",  $phone) .
        WidgetMaker::d_list_entry("Email:",  $email ) .
        WidgetMaker::d_list_entry("Company:",  $industry ) .
        WidgetMaker::d_list_entry("Profession:",  $profession ) .
        WidgetMaker::d_list_entry("Access Right:",  $accessRight ) .
        WidgetMaker::d_list_entry("Delete Flag:",  $deleteOutput);
    $returnString .=  wMk::access_right_panel($db_conn, UserManagementConstants::ACCESS_RIGHT_BUTTON_ID) .
        '\n<br>\n' .
        wMk::button_ajax(UserManagementConstants::RESET_PW_BUTTON_ID , 'Reset Password') .
        '\n<br>\n' .
        wMk::button_ajax(UserManagementConstants::DELETE_BUTTON_ID, 'Delete User') .
        '\n<br>\n' .
        wMk::button_ajax(UserManagementConstants::REACTIVATE_BUTTON_ID, 'Reactivate User') ;

    return $returnString;

}

