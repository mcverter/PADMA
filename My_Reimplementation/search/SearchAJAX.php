<?php
/**
 *
 */


require_once("../functions/DBFunctionsAndConsts.php");
require_once("../components/WidgetMaker.php");

$date = dbFn::now();
$db_conn = dbFn::connect_to_db();

$experimentid = $_POST['experimentid'];
$command = $_POST['command'];
$role = $_POST['role'];


switch($command) {
    case ExperimentListPage::SHOW_EXPERIMENT_CMD:
        echo get_experiment_description($db_conn, $experimentid, $role);
        break;
    case ExperimentListPage::SAVE_DESCRIPTION_CMD:
        $newDescription = $_POST['description'];
        echo update_experiment_description($db_conn, $experimentid, $newDescription);
        break;
}


/**
 * @param $db_conn
 * @param $experimentid
 * @param $newDescription
 */
function update_experiment_description($db_conn, $experimentid, $newDescription){
    dbFn::updateExperimentDescription($db_conn, $experimentid, $newDescription);
}

/**
 * @param $db_conn
 * @param $experimentid
 * @param $role
 * @return string
 */
function get_experiment_description($db_conn, $experimentid, $role ){
    $returnString = '';
    $db_statement = dbFn::selectExperimentDescription($db_conn, $experimentid);
    $row = oci_fetch_assoc($db_statement);
    $description = $row['EXP_DESC'];
    if ($role === pgFn::ADMINISTRATOR_ROLE || $role === pgFn::RESEARCHER_ROLE) {
        $textarea_id = ExperimentListPage::DESCRIPTION_TEXTAREA;
        $returnString .= <<<EOT

        <h2> Description of $experimentid</h2>
        <textarea id='$textarea_id'>
            $description
        </textarea>
EOT
            . wMk::button_ajax(ExperimentListPage::SAVE_BUTTON_ID, "Update Description");

    }
    else {
        $returnString .= <<<EOT
        <h2> Description of $experimentid</h2>
        <div>
            $description
        </div>

EOT;
    }

    return $returnString;
}