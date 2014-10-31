<?php
require_once("../templates/WebPage.php");

/**
 * Class SearchMainPage
 */
class SearchMainPage extends WebPage{

    const PG_TITLE = "Search Main";

    /**
     * @param $userid
     * @param $role
     * @return string
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
        return $this->make_image_content_columns ($userid, $role, 'R', 8) ;
    }

}