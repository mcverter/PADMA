<?php
require_once("../functions/DBFunctionsAndConsts.php");
$db_conn = DBFunctionsAndConsts::connect_to_db();
$date = DBFunctionsAndConsts::now_applied();

DBFunctionsAndConsts::insertUserProfile(
    $db_conn,
    $_POST[DBFunctionsAndConsts::TITLE_COL],
    $_POST[DBFunctionsAndConsts::LNAME_COL],
    $_POST[DBFunctionsAndConsts::MNAME_COL],
    $_POST[DBFunctionsAndConsts::FNAME_COL],
    $_POST[DBFunctionsAndConsts::ADD_1_COL],
    $_POST[DBFunctionsAndConsts::ADD_2_COL],
    $_POST[DBFunctionsAndConsts::CITY_COL],
    $_POST[DBFunctionsAndConsts::STATE_COL],
    $_POST[DBFunctionsAndConsts::ZIP_COL],
    $_POST[DBFunctionsAndConsts::COUNTRYNAME_COL],
    $_POST[DBFunctionsAndConsts::PHONE_COL],
    $_POST[DBFunctionsAndConsts::EMAIL_COL],
    $_POST[DBFunctionsAndConsts::IND_COL],
    $_POST[DBFunctionsAndConsts::PROF_COL],
    strtoupper($_POST[DBFunctionsAndConsts::USER_ID_COL]),
    sha1($_POST[DBFunctionsAndConsts::PASSWORD_COL]),
    $date);

header('Location: ../webpages/index.php');
