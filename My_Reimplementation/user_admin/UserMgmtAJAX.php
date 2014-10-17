<?php

require_once(__DIR__ . "/../functions/DBFunctions.php");
require_once(__DIR__ . "/../components/WidgetMaker.php");
require_once(__DIR__ . "/UserManagementConstants.php");

$command = $_POST['command'];
$adminID = $_POST['adminID'];
$cid = $_POST['cid'];

$date = dbFn::now();
$db_conn = dbFn::connect_to_db();


switch($command) {
    case UserManagementConstants::GET_USER_INFO_COMMAND:
        $db_result = dbFn::selectProfileInfoByCID($db_conn, $cid);
        $row = oci_fetch_array($db_result);
        $returnString .= makeUserInfoWidget($row);
        break;
    case UserManagementConstants::CHANGE_RIGHT_COMMAND:
        $accessRight = $_POST['accessRight'];
        dbFn::updateUserRight($db_conn, $cid, $accessRight, $adminID, $date) ;
        break;
    case UserManagementConstants::DELETE_USER_COMMAND:
        dbFn::deleteUser($db_conn, $cid, $adminID, $date);
        break;
    case UserManagementConstants::REACTIVATE_USER_COMMAND:
        dbFn::updateUserActivation($db_conn, $cid, $adminID, $date);
         break;
}

/*
 * SELECT CLIENT.*, ACCESS_RIGHT.ACC_RIGHT_DESC as RIGHT FROM CLIENT INNER JOIN ACCESS_RIGHT ON CLIENT.ACC_RIGHT_ID = ACCESS_RIGHT.ACC_RIGHT_ID WHERE CLIENT.c_id = '2522'
 *
 *
 */

function makeUserInfoWidget($userRow) {
    list ($cid, $title, $lname, $fname, $mname,
        $add1, $add2, $city, $state, $zip,
        $phone, $email, $industry, $profession,
        $accessRight, $deleteflag) =
        array(
          $userRow['C_ID'], $userRow['TITLE'], $userRow['LNAME'], $userRow['FNAME'],  $userRow['MNAME'],
            $userRow['ADD_1'], $userRow['ADD_2'], $userRow['CITY'], $userRow['STATE'],$userRow['ZIP'],
            $userRow['PHONE'], $userRow['EMAIL'], $userRow['IND'], $userRow['PROF'],
            $userRow['ACC_RIGHT_ID'], $userRow['DEL_FLAG']
        );
    $returnString = "Title:  "  .  $title . " <br> \n" .
        "Last Name:  "  .  $lname . " <br> " .
        "First Name:  "  .  $fname . " <br> " .
        "Middle Initial:  "  .  $mname . " <br> " .
        "Address:  "  .  $add1 . " <br> " .
        "Address 2:  "  .  $add2 . " <br> " .
        "City:  "  .  $city . " <br> ".
        "State:  "  .  $state . " <br> ".
        "Zip Code:  "  .  $zip . " <br> ".
        "Phone:  "  .  $phone . " <br> ".
        "Email:  "  .  $email . " <br> ".
        "Company:  "  .  $industry . " <br> ".
        "Profession:  "  .  $profession . " <br> ".
        "Access Right:  "  .  $accessRight . " <br> ".
        "Delete Flag:  "  .  $deleteflag . " <br> ";
    $returnString .= wMk::AccessRightPanel() .
        wMk::button_ajax(UserManagementConstants::RESET_PW_BUTTON_ID , 'Reset Password') .
        wMk::button_ajax(UserManagementConstants::DELETE_BUTTON_ID, 'Delete User') .
        wMk::button_ajax(UserManagementConstants::REACTIVATE_BUTTON_ID, 'Reactivate User') ;

    return $returnString;

}

