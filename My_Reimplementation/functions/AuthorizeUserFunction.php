<?php

require_once( __DIR__ . "/../functions/DBFunctions.php");
require_once(__DIR__ . "/../templates/WebPage.php");

$userid = $_POST[WebPage::USERID_SESSVAR];
$password = $_POST[WebPage::PASSWORD_POSTVAR];
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


if ($role === WebPage::RESEARCHER_ROLE ||
    $role === WebPage::ADMINISTRATOR_ROLE ||
    $role === WebPage::USER_ROLE) {
    session_start();
    $_SESSION[WebPage::ROLE_SESSVAR]=$role;
    $_SESSION[WebPage::USERID_SESSVAR]=$userid;
}
else {
    $_SESSION[WebPage::ROLE_SESSVAR]=WebPage::NOTAUTHORIZED_ROLE;
}

header('Location: ../webpages/index.php');
