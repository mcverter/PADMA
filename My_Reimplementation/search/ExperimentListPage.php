<?php

require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class ExperimentListPage extends DatabaseConnectionPage{

    const EXPERIMENT_SELECT_ID = 'experiments';
    const DESCRIPTION_DIV_ID = 'description_div';
    const DESCRIPTION_TEXTAREA = 'description_ta';

    const SAVE_BUTTON_ID = 'saveBtn';
    const SHOW_EXPERIMENT_CMD = 'showExp';
    const SAVE_DESCRIPTION_CMD = 'saveDesc';

    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }

    function get_title() {

    }
    function make_main_content($title, $userid, $role) {
        $db_conn = $this->db_conn;
        $userid = $this->userid;
        $returnString = '';
        $description_div = ExperimentListPage::DESCRIPTION_DIV_ID;
        $returnString .= WidgetMaker::select_input("Experiment List",
            self::EXPERIMENT_SELECT_ID,
            DBFunctions::selectAllUnrestrictedExperimentList($db_conn, $userid),
            'EXP_NAME',
            'EXP_NAME',
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