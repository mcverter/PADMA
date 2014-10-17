<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/24/14
 * Time: 8:49 AM
 */

require_once(__DIR__ . "/SearchBase.php");

class_alias("WidgetMaker", "wMk");

class QuickSearchPage extends SearchBase
{
  function make_page_middle($title, $userid, $role){
    return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
      }
    function make_quicksearch_widget() {
        wMk::quicksearch_widget();
    }

    function __construct()
    {
        parent::__construct();
        $this->title = "Quick Search";
    }

    function make_main_frame($title, $userid, $role)
    {
        $title = $this->title;
        $db_conn = $this->db_conn;
        $userid = $this->userid;
        $returnString = <<<EOT
    <h2>{$title}</h2>
    <br>
EOT;
        $returnString .= wMk::start_form('search_result.php', 'POST') .
        $this->make_quicksearch_widget() .
        $this->make_experiment_select($db_conn, $userid) .
        $this->make_category_select($db_conn, $userid) .
        $this->make_species_select($db_conn, $userid) .
        $this->make_subject_select($db_conn, $userid) .
        $this->make_regval_select($db_conn, $userid) .
            wMk::submit_button('submit', 'Search') .
            wMk::end_form(); ;


        return $returnString;
    }
}
