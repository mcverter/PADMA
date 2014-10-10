<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/24/14
 * Time: 8:49 AM
 */

require_once(__DIR__ . "/SearchBase.php");

class QuickSearchPage extends SearchBase
{
    function make_quicksearch_widget() {
        WidgetMaker::quicksearch_widget();
    }

    function __construct()
    {
        parent::__construct();
        $this->title = "Quick Search";
    }

    function print_content()
    {
        $title = $this->title;
        $db_conn = $this->db_conn;
        $userid = $this->userid;
        echo <<<EOT
    <h2>{$title}</h2>
    <br>
EOT;
        echo WidgetMaker::start_form('search_result.php', 'POST') .
        $this->make_quicksearch_widget() .
        $this->make_experiment_select($db_conn, $userid) .
        $this->make_category_select($db_conn, $userid) .
        $this->make_species_select($db_conn, $userid) .
        $this->make_subject_select($db_conn, $userid) .
        $this->make_regval_select($db_conn, $userid) .
            WidgetMaker::submit_button('submit', 'Search') .
            WidgetMaker::end_form(); ;


    }
}
