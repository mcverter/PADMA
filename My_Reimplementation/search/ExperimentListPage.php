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
} 