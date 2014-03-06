<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");
require_once(__DIR__ . "/../templates/DB_WidgetMaker.php");

class SearchBase extends DatabaseConnectionPage {
    protected $db_conn;
    protected $searchType;
    protected $text_input_func;
    protected $select_input_func;

    function __construct() {
      parent::__construct();
    }

    function __destruct() {
      parent::__destruct();
    }

    function print_text_input_widgets() {
        foreach ($this->text_input_func as $w) {
	  call_user_func($w);
        }
    }

    function print_select_input_widgets($db_conn, $userid) {
      foreach ($this->select_input_func as $w) {
	call_user_func($w, $db_conn, $userid);
      }
    }


    function print_content() {
        $title = $this->title;
        $db_conn = $this->db_conn;
        $userid = isset($_SESSION['userid']) ?  $_SESSION['userid'] : "";
        $searchType = $this->searchType;
        echo <<<EOT
    <h2>{$title}</h2>

    <form class="central_widget" action="search_result.php"
    method="post" name="index" onsubmit="return validate(index);">
    <input type="hidden" name="search_type" value="{$searchType}" />
EOT;

        $this->print_text_input_widgets();
        $this->print_select_input_widgets($db_conn, $userid);
        echo <<<EOT

        <input name="btn_submit" type="submit" value="Submit"/>
</form>
EOT;


    }
}
