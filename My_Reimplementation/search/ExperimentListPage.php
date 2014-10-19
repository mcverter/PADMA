<?php

require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class ExperimentListPage extends DatabaseConnectionPage{
    function __construct() {
        parent::__construct();
    }

    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }

    function __construct() {
        parent::__construct();
    }

    function get_title() {

    }
    function make_main_frame($title, $userid, $role) {
        $db_conn = $this->db_conn;
        $userid = $this->userid;
        $returnString = '';
        $returnString .= WidgetMaker::select_input("Experiment List", 'Experiments []',
            DBFunctions::selectAllUnrestrictedExperimentList($db_conn, $userid),
            'EXP_NAME', false);
        return $returnString;
    }
} 