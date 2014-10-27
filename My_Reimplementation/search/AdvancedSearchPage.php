<?php
require_once(__DIR__ . "/SearchBase.php");

/**
 * Class AdvancedSearchPage
 */
class AdvancedSearchPage extends SearchBase {

    const PG_TITLE = "Advanced Search";

    /**
     * @Override
 * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_page_middle($userid, $role){
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
        $title = static::PG_TITLE;
        $returnString = <<<EOT
    <h2>{$title}</h2>
    <br>
EOT;


        $returnString .= wMk::start_form('search_result.php', 'POST') .
            $this->make_probeid_text_input() .
            $this->make_cgnumber_text_input() .
            $this->make_flybasenumber_text_input() .
            $this->make_genename_text_input()  .
            $this->make_gonumber_text_input() .
            $this->make_biofunction_select($db_conn, $userid) .
            $this->make_experiment_select($db_conn, $userid) .
            $this->make_category_select($db_conn, $userid) .
            $this->make_species_select($db_conn, $userid) .
            $this->make_subject_select($db_conn, $userid) .
            wMk::submit_button('submit', 'Search') .
            wMk::end_form();

        return $returnString;

    }
}

