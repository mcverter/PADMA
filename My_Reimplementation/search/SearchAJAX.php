<?php

require_once(__DIR__ . "/../functions/DBFunctions.php");
require_once(__DIR__ . "/../components/WidgetMaker.php");
require_once(__DIR__ . "/ExperimentListPage.php");

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



function update_experiment_description($db_conn, $experimentid, $newDescription){
    DBFunctions::updateExperimentDescription($db_conn, $experimentid, $newDescription);
}
function get_experiment_description($db_conn, $experimentid, $role ){
    $returnString = '';
    $db_statement = DBFunctions::selectExperimentDescription($db_conn, $experimentid);
    $row = oci_fetch_array($db_statement);
    $description = $row['EXP_DESC'];
    if ($role === WebPage::ADMINISTRATOR_ROLE || $role === WebPage::RESEARCHER_ROLE) {
        $textarea_id = ExperimentListPage::DESCRIPTION_TEXTAREA;
        $returnString .= <<<EOT

        <h2> Description of $experimentid</h2>
        <textarea id='$textarea_id'>
            $description
        </textarea>
EOT
            . WidgetMaker::button_ajax(ExperimentListPage::SAVE_BUTTON_ID, "Update Description");

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