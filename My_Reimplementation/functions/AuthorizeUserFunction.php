<?php
/**
 * Script Used to verify Login
 *
 * If Username and Password match, SESSION $role and $userid are set
 * Otherwise, user is redirected to index.php and error message is displayed
 */
require_once("../functions/DBFunctionsAndConsts.php");
require_once("../templates/WebPage.php");

$userid = $_POST[pgFn::USERID_SESSVAR];
$password = $_POST[pgFn::PASSWORD_POSTVAR];
$role = '';

$db_conn = dbFn::connect_to_db();
$stored_proc_statement = 'BEGIN LOGIN(:PARAM_USERNAME,:PARAM_PASSWORD,:PARAM_ROLE); END;';
$stored_proc_statement = oci_parse($db_conn,$stored_proc_statement);

$userid = strtoupper($userid);
$password = sha1($password);
oci_bind_by_name($stored_proc_statement,":PARAM_USERNAME",$userid,15);
oci_bind_by_name($stored_proc_statement,":PARAM_PASSWORD",$password,250);
oci_bind_by_name($stored_proc_statement,":PARAM_ROLE",$role,30);
$execute=oci_execute($stored_proc_statement);


if ($role === pgFn::RESEARCHER_ROLE ||
    $role === pgFn::ADMINISTRATOR_ROLE ||
    $role === pgFn::USER_ROLE) {
    session_start();
    $_SESSION[pgFn::ROLE_SESSVAR]=$role;
    $_SESSION[pgFn::USERID_SESSVAR]=$userid;
}
else {
    $_SESSION[pgFn::ROLE_SESSVAR]=pgFn::NOTAUTHORIZED_ROLE;
}

header('Location: ../webpages/index.php');
