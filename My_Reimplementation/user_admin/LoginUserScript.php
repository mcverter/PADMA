<?php
/**
 * Script Used to verify Login
 *
 * If Username and Password match, SESSION $role and $userid are set
 * Otherwise, user is redirected to index.php and error message is displayed
 */
require_once("../functions_and_consts/DBFunctionsAndConsts.php");
require_once("../templates/WebPage.php");

$userid = $_POST[PageControlFunctionsAndConsts::USERID_SESSVAR];
$password = $_POST[PageControlFunctionsAndConsts::PASSWORD_POSTVAR];
$role = '';

$db_conn = DBFunctionsAndConsts::connect_to_db();
$stored_proc_statement = 'BEGIN LOGIN(:PARAM_USERNAME,:PARAM_PASSWORD,:PARAM_ROLE); END;';
$stored_proc_statement = oci_parse($db_conn,$stored_proc_statement);

$userid = strtoupper($userid);
$password = sha1($password);
oci_bind_by_name($stored_proc_statement,":PARAM_USERNAME",$userid,15);
oci_bind_by_name($stored_proc_statement,":PARAM_PASSWORD",$password,250);
oci_bind_by_name($stored_proc_statement,":PARAM_ROLE",$role,30);
$execute=oci_execute($stored_proc_statement);


if ($role === PageControlFunctionsAndConsts::RESEARCHER_ROLE ||
    $role === PageControlFunctionsAndConsts::ADMINISTRATOR_ROLE ||
    $role === PageControlFunctionsAndConsts::USER_ROLE) {
    session_start();
    $_SESSION[PageControlFunctionsAndConsts::ROLE_SESSVAR]=$role;
    $_SESSION[PageControlFunctionsAndConsts::USERID_SESSVAR]=$userid;
    header('Location: ../webpages/index.php');
}
else {
    $_SESSION[PageControlFunctionsAndConsts::ROLE_SESSVAR]= null;
    PageControlFunctionsAndConsts::redirectDueToError("We could not find your Username / Password combination in our records");
}

