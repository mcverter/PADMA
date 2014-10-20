<?php

require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class ExperimentListPage extends DatabaseConnectionPage{

    const EXPERIMENT_SELECT_ID = 'experiments';
    const DESCRIPTION_TEXTAREA_ID = 'description';
    const SAVE_BUTTON_ID = 'saveBtn';

    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }

    function get_title() {

    }
    function make_main_frame($title, $userid, $role) {
        $db_conn = $this->db_conn;
        $userid = $this->userid;
        $returnString = '';
        $returnString .= WidgetMaker::select_input("Experiment List", self::EXPERIMENT_SELECT_ID,
            DBFunctions::selectAllUnrestrictedExperimentList($db_conn, $userid),
            'EXP_NAME', false);
        return $returnString;
    }

    function make_js() {
        $returnString = parent::make_js();
        list ($experiment_select, $description_area, $save_button) =
            array (ExperimentListPage::EXPERIMENT_SELECT_ID,
                ExperimentListPage::DESCRIPTION_TEXTAREA_ID,
                ExperimentListPage::SAVE_BUTTON_ID);


        $returnString .= <<< EOT

<script>
    $(document).ready( function () {
        $('#$experiment_select').change(function() {
            var selected = this.value;
            $.ajax({
                url: '../search/SearchAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    experimentid : selected, command: $showExperimentDescription
                 },
                success: function(experimentDesc) {
                    $('#$description_area').html(experimentDesc);
                }
            });
        });
        $('#{saveButton').click(function() {
            $.ajax({
                url: '../search/SearchAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    experimentid : selected, description: $newDescription, command: $saveExperimentDescription
                },
                success: function(userData) {
                    console.log(" Data", userData);
                }
            });
        });
    });
</script>

EOT;
    return $returnString;
    }
} 