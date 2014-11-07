<?php
/**
Used by Registration Page to check that the Username is not already in use.
 */

require_once('../functions_and_consts/DBFunctionsAndConsts.php');
$db_conn = DBFunctionsAndConsts::connect_to_db();
$userid = $_GET[DBFunctionsAndConsts::USER_ID_COL];

if (DBFunctionsAndConsts::isUserInDB_byID($db_conn, $userid)) {
    header("HTTP/1.0 404 Not Found");
}