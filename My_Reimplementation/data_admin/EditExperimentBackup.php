<?php

require_once("../templates/DatabaseConnectionPage.php");

/**
 * Class ExperimentListPage
 */
class ExperimentListBackupPage extends DatabaseConnectionPage{

    const PG_TITLE = 'Experiment List';

    const DESCRIPTION_DIV_ID = 'description_div';
    const DESCRIPTION_TEXTAREA = 'description_ta';

    const SAVE_BUTTON_ID = 'saveBtn';
    const SHOW_EXPERIMENT_CMD = 'showExp';
    const SAVE_DESCRIPTION_CMD = 'saveDesc';

    /**
     * @Override
     * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_page_middle($userid, $role) {
        return $this->make_image_content_columns ($userid, $role, 'R', 8) ;
    }

    /**
     * @param $userid
     * @param $role
     * @return string
     */
    function make_main_content($userid, $role) {
        $db_conn = $this->db_conn;
        $userid = $this->userid;
        $returnString = '';
        $description_div = ExperimentListPage::DESCRIPTION_DIV_ID;
        $returnString .= wMk::select_input("Experiment List",
                self::EXPERIMENT_SELECT_ID,
                dbFn::selectAllUnrestrictedExperimentList($db_conn, $userid),
                dbFn::EXP_NAME_COL,
                dbFn::EXP_NAME_COL,
                false)
            . <<< EOT

            <br>
            <br>
            <div id='$description_div'></div>
            <br>
EOT;


        ;
        return $returnString;
    }

    /**
     * @return string
     */
    function make_js() {
        $returnString = parent::make_js();
        $role = $this->role;
        list ($experiment_select, $description_div, $description_textarea,
            $showExperimentDescription, $saveBtn, $saveExperimentDescription) =
            array (ExperimentListPage::EXPERIMENT_SELECT_ID,
                ExperimentListPage::DESCRIPTION_DIV_ID,
                ExperimentListPage::DESCRIPTION_TEXTAREA,
                ExperimentListPage::SHOW_EXPERIMENT_CMD,
                ExperimentListPage::SAVE_BUTTON_ID,
                ExperimentListPage::SAVE_DESCRIPTION_CMD);
        $returnString .= $returnString .= <<< EOT

<script>
    $(document).ready( function () {
    $(document).on("change", '#$experiment_select' ,function() {
        var selected = this.value;
            $.ajax({
                url: '../search/SearchAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    experimentid : selected, command: '$showExperimentDescription', role: '$role'
                 },
                success: function(experimentDesc) {
                console.log(experimentDesc);
                    $('#$description_div').html(experimentDesc);
                }
            });
        });
       $(document).on("click", '#$saveBtn' ,function() {
            var experiment = $('#$experiment_select').val();
            var newDescription = $('#$description_textarea').val();
            $.ajax({
                url: '../search/SearchAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    experimentid : experiment, description: newDescription, command: '$saveExperimentDescription'
                },
                success: function(userData) {
                    console.log(" Data", userData);
                }
            });
        });
    });
</script>

EOT
        ;
        return $returnString;
    }
}

/*
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


 * @param $db_conn
 * @param $experimentid
 * @param $newDescription
function update_experiment_description($db_conn, $experimentid, $newDescription){
    dbFn::updateExperimentDescription($db_conn, $experimentid, $newDescription);
}


 * @param $db_conn
 * @param $experimentid
 * @param $role
 * @return string

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
*/