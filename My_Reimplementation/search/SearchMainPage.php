<?php
require_once(__DIR__ . "/../templates/WebPage.php");


class SearchMainPage extends WebPage{

    function make_main_frame($title, $userid, $role)
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
    function __construct() {
        parent::__construct();
    }


    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }

    function get_title() {
        return "Search";
    }
} 