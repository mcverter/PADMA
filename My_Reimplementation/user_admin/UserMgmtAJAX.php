<?php
/***
 * This scripts responds to all of the AJAX events that
 *  occur in the UserManagement.php page
 *
 * These calls enable an Administrator to do the following to a User:
 * (1) Reset Password
 * (2) Delete User [Set Delete Flag]
 * (3) Activate User [Unset Delete Flag]
 * (4) Change User's Password

 */
require_once("UserManagementPage.php");
$command = $_POST['command'];
$adminID = $_POST['adminID'];
$cid = $_POST['cid'];

$date = DBFunctionsAndConsts::now_applied();
$db_conn = dbFn::connect_to_db();


/**
 *  Main Switch Command
 *
 * Checks the type of user management action being requested,
 *   implements the appropriate Database changes,
 *   and refreshes the USER_INFO and FEEDBACK divs
 *
 */
switch($command) {
    case UserManagementPage::GET_USER_INFO_COMMAND:
        ajaxReturnUserInfo($db_conn, $cid);
        break;
    case UserManagementPage::CHANGE_RIGHT_COMMAND:
        $accessRight = $_POST['accessRight'];
        dbFn::updateUserRight($db_conn, $cid, $accessRight, $adminID, $date);
        ajaxReturnUserInfo($db_conn, $cid);
        break;
    case UserManagementPage::DELETE_USER_COMMAND:
        dbFn::deleteUser($db_conn, $cid, $adminID, $date);
        ajaxReturnUserInfo($db_conn, $cid);
        break;
    case UserManagementPage::REACTIVATE_USER_COMMAND:
        dbFn::updateUserActivation($db_conn, $cid, $adminID, $date);
        ajaxReturnUserInfo($db_conn, $cid);
        break;
    case UserManagementPage::RESET_USER_PW_COMMAND:
        $randomPassword = PageControlFunctionsAndConsts::randomPassword();
        $row = oci_fetch_assoc(DBFunctionsAndConsts::selectEmailFromCID($db_conn, $cid));
        $email = $row[DBFunctionsAndConsts::EMAIL_COL];
        if ($email) {
            $from_header = 'From: PADMA Administrator <' . PageControlFunctionsAndConsts::PADMA_EMAIL . '>\r\n';
            mail($email, "Your new PADMA Password", "Your password for PADMA " . PageControlFunctionsAndConsts::PADMA_URL .
                "has been changed to " . $randomPassword . "\n Please log in and change it as soon as possible.", $from_header);
            DBFunctionsAndConsts::updatePasswordByCID($db_conn, $cid, $randomPassword);
        }
}


/**
 * Text returned from the AJAX Call.
 * Prints out the UserInformation Widget,
 *  containing data about currently selected user
 *
 * @param $db_conn:  Database connection
 * @param $cid:  Currently selected user
 */
function ajaxReturnUserInfo($db_conn, $cid) {
    $db_result = dbFn::selectProfileInfoByCID($db_conn, $cid);
    $row = oci_fetch_assoc($db_result);
    echo makeUserInfoWidget($row);
}



/**
 * Creates string containing User information as well as
 *   Action buttons for changing user information
 *
 * @param $userRow : Database row containing User information
 * @return string:  HTML for User Widget
 */
function makeUserInfoWidget($userRow) {

    global $db_conn;


    list ($cid, $padmaUserId, $title, $lname, $fname, $mname,
        $add1, $add2, $city, $state, $zip,
        $phone, $email, $industry, $profession,
        $accessRight, $deleteflag) =
        array(
            $userRow[DBFunctionsAndConsts::C_ID_COL], $userRow[DBFunctionsAndConsts::USER_ID_COL],
            $userRow[DBFunctionsAndConsts::TITLE_COL], $userRow[DBFunctionsAndConsts::LNAME_COL],
            $userRow[DBFunctionsAndConsts::FNAME_COL],  $userRow[DBFunctionsAndConsts::MNAME_COL],
            $userRow[DBFunctionsAndConsts::ADD_1_COL], $userRow[DBFunctionsAndConsts::ADD_2_COL],
            $userRow[DBFunctionsAndConsts::CITY_COL], $userRow[DBFunctionsAndConsts::STATE_COL],
            $userRow[DBFunctionsAndConsts::ZIP_COL],
            $userRow[DBFunctionsAndConsts::PHONE_COL], $userRow[DBFunctionsAndConsts::EMAIL_COL],
            $userRow[DBFunctionsAndConsts::IND_COL], $userRow[DBFunctionsAndConsts::PROF_COL],
            $userRow[DBFunctionsAndConsts::RIGHT_ALIAS], $userRow[DBFunctionsAndConsts::DEL_FLAG_COL]
        );
    $deleteOutput = $deleteflag == 1 ? "Inactive User" : "Active User";
    $returnString = '';

    // User Information
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
        wMk::d_list_entry("Delete Flag:",  $deleteOutput) .

    "<br><br>";

    // Buttons for Modifying Users
    $returnString .=
        WidgetMaker::start_fieldset("Modify Access Right") .
        WidgetMaker::select_input('Access Right', DBFunctionsAndConsts::ACC_RIGHT_ID_COL, dbFn::selectAccessRightList($db_conn),
            'ACC_RIGHT_ID', 'ACC_RIGHT_DESC', false) .
        WidgetMaker::button_ajax(UserManagementPage::ACCESS_RIGHT_BUTTON_ID, "Update Access Right") .
        WidgetMaker::end_fieldset();

    // Delete and Reactivate are opposites
    if ($deleteflag) {
        $returnString .= WidgetMaker::start_fieldset("Reactivate User") .
            wMk::button_ajax(UserManagementPage::REACTIVATE_BUTTON_ID, 'Reactivate '. $padmaUserId) .
            WidgetMaker::end_fieldset();
    }
    else {
        $returnString .= WidgetMaker::start_fieldset("Delete User") .
            wMk::button_ajax(UserManagementPage::DELETE_BUTTON_ID, 'Delete ' . $padmaUserId) .
            WidgetMaker::end_fieldset();
    }

    // Add last Button
    $returnString .= WidgetMaker::start_fieldset("Reset Password") .
        wMk::button_ajax(UserManagementPage::RESET_PW_BUTTON_ID , 'Reset Password for '. $padmaUserId ) .
        WidgetMaker::end_fieldset();

    return $returnString;

}

