<?php
require_once(__DIR__ . "/../templates/WebPage.php");

/**
 * Class SearchMainPage
 */
class SearchMainPage extends WebPage{

    const PG_TITLE = "Search Main";

    /**
     * @param $title
     * @param $userid
     * @param $role
     * @return string
     */
    function make_main_content($title, $userid, $role)
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
     * @param $title
     * @param $userid
     * @param $role
     * @return string
     */
    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }

}