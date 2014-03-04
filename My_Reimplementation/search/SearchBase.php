<?php
require_once("DatabaseConnectionPage.php");
require_once("DB_Entity.php");

class SearchBase extends DatabaseConnectionPage {
    protected $db_conn;
    protected $text_input_widgets;
    protected $select_input_widgets;

    function __construct() {
      parent::__construct();
    }

    function __destruct() {
      parent::__destruct();
    }

    function print_text_input_widgets() {
        foreach ($this->text_input_widgets as $w) {
            $w->make_text_input_widget();
        }
    }


    function print_select_input_widgets($db_conn, $userid) {
        foreach ($this->select_input_widgets as $w) {
            $w->make_select_input_widget($db_conn, $userid);
        }
    }


    function print_content() {
        $title = $this->title;
        $db_conn = $this->db_conn;
        $userid = isset($_SESSION['userid']) ?
            $_SESSION['userid'] : "";
        $searchType = substr($title, strpos($title, ' ')-1);
        echo <<<EOT
    <h2>{$title}</h2>

    <form class="central_widget" action="SearchResult.php" method="post" name="index" onsubmit="return validate(index);">
    <input type="hidden" name="search_type" value="{$searchType}"
EOT;

        $this->print_text_input_widgets();
        $this->print_select_input_widgets($db_conn, $userid);
        echo <<<EOT

        <input name="btn_submit" type="submit" value="Submit"/>
</form>
EOT;


    }
}
