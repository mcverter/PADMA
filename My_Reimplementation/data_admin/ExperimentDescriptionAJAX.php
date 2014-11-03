<?php
/**
 *  Returns the Description of an Experiment in response to AJAX Call
 */


require_once("../functions/DBFunctionsAndConsts.php");

$db_conn = dbFn::connect_to_db();
$experimentid = $_POST['experimentid'];

$db_statement = dbFn::selectExperimentDescription($db_conn, $experimentid);
$row = oci_fetch_assoc($db_statement);
echo $description = $row['EXP_DESC'];


