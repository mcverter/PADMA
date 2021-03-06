<?php
require_once("../templates/DatabaseConnectionPage.php");

/**
 * Class AdvancedSearchPage
 * Provides a FULL SEARCH of all the columns of the FULL_VIEW view.
 *
 * Note that certain search dimensions are implemented as
 *   SELECT INPUTs and others as TEXT INPUTs
 *
 * The previous iteration of PADMA offered three different
 *   versions of search.  It was unclear what the rationale was
 *   for making this decision.
 *
 * It would not be hard to replicate this design, but we will
 *   are holding off on this implementation until end users
 *   communicate their requirements better
 */
class AdvancedSearchPage extends  DatabaseConnectionPage
{
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
        return $this->make_image_content_columns ($userid, $role, 'R', 2) ;
    }
    /**
     * @Override
     *
     * Makes the main functional content block of the page
     *
     * Displays widgets for querying all of the relevant fields
     *   in the FULL_VIEW table.
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */

    function make_main_content($userid, $role) {
        $db_conn = $this->db_conn;
        $userid = $this->userid;

        $returnString = WidgetMaker::start_form('search_result.php', 'POST', '' , ' form-horizontal ') .
            WidgetMaker::text_input("Probe Id:", DBFunctionsAndConsts::PROB_ID_COL) .
            WidgetMaker::text_input("CG Number:", DBFunctionsAndConsts::CGNUMBER_COL) .
            WidgetMaker::text_input("Flybase Number:", DBFunctionsAndConsts::FBGNNUMBER_COL) .
            WidgetMaker::text_input("Gene Name:", DBFunctionsAndConsts::GENENAME_COL) .
            WidgetMaker::text_input("GO Number:", DBFunctionsAndConsts::GONUMBER_COL) .
            WidgetMaker::select_input(
                "Experiment Name:",
                DBFunctionsAndConsts::EXP_NAME_COL . DBFunctionsAndConsts::POST_MULTIPLE,
                DBFunctionsAndConsts::selectAllUnrestrictedExperimentList($db_conn, $userid),
                DBFunctionsAndConsts::EXP_NAME_COL,
                DBFunctionsAndConsts::EXP_NAME_COL) .
            WidgetMaker::select_input(
                "Category:",
                DBFunctionsAndConsts::CATG_COL . DBFunctionsAndConsts::POST_MULTIPLE,
                DBFunctionsAndConsts::selectCategoryList($db_conn, $userid),
                DBFunctionsAndConsts::CATG_COL,
                DBFunctionsAndConsts::CATG_COL) .
            WidgetMaker::select_input(
                "Species:",
                DBFunctionsAndConsts::SPEC_COL . DBFunctionsAndConsts::POST_MULTIPLE,
                DBFunctionsAndConsts::selectSpeciesList($db_conn, $userid),
                DBFunctionsAndConsts::SPEC_COL,
                DBFunctionsAndConsts::SPEC_COL) .
            WidgetMaker::select_input(
                "Subject:",
                DBFunctionsAndConsts::SUBJ_COL . DBFunctionsAndConsts::POST_MULTIPLE,
                DBFunctionsAndConsts::selectSubjectList($db_conn, $userid),
                DBFunctionsAndConsts::SUBJ_COL,
                DBFunctionsAndConsts::SUBJ_COL) .
            WidgetMaker::select_input(
                "BioFunction:",
                DBFunctionsAndConsts::BIOFUNCTION_COL . DBFunctionsAndConsts::POST_MULTIPLE,
                DBFunctionsAndConsts::selectBiofunctionList($db_conn, $userid),
                DBFunctionsAndConsts::BIOFUNCTION_COL,
                DBFunctionsAndConsts::BIOFUNCTION_COL) .
            WidgetMaker::select_input(
                "Regulation Value:",
                DBFunctionsAndConsts::REG_VAL_COL . DBFunctionsAndConsts::POST_MULTIPLE,
                DBFunctionsAndConsts::selectRegValList($db_conn, $userid),
                DBFunctionsAndConsts::REG_VAL_COL,
                DBFunctionsAndConsts::REG_VAL_COL) .
            WidgetMaker::submit_button('submit', 'Search') .
            WidgetMaker::end_form();

        return $returnString;
    }
}

