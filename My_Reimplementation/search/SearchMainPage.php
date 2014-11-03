<?php
require_once("../templates/WebPage.php");

/**
 * Class SearchMainPage
 *
 * Displays a list of Search Options
 * Currently we are only supporting
 * (1) Advanced Search which allows for all the search options
 * (2) Experiment Detail
 *
 * The previous implementation also included
 * "Refined Search" and "Quick Search"
 *
 * These can be easily be added again.
 *
 * However, there is now too much confusion over the previous
 *   designer's work so they are not currently implememtned.
 *
 * At the customer's request, we can add searches with fewer options.
 *
 */
class SearchMainPage extends WebPage{

    const PG_TITLE = "Search Main";


    /**
     * @Override
     *
     * Makes the main functional content block of the page
     *
     * Displays a list of search options
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */

    function make_main_content($userid, $role)
    {
        $returnString = '';
        $returnString .= <<< EOT
        <ul class="nav nav-pills nav-stacked">
            <li> <a href="../webpages/advanced_search.php">Advanced Search</a></li>
            <li> <a href="../webpages/experiment_list.php">Experiment List</a></li>
        </ul>
EOT;
        return $returnString;
    }

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
        return $this->make_image_content_columns ($userid, $role, 'R', 4) ;
    }

}