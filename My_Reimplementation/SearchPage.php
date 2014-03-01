<?php

class SearchPage extends WebPage {

    protected $db_conn;
    protected $search_type;
    protected $text_input_widgets;
    protected $select_widgets;

    public function __construct($title, $type) {
        parent::__construct($title);
        $this->db_conn = connect_to_db();
        $this->search_type = new SearchType($search_type);
    }


    function add_js() {
        echo "<script src='/js/loe_popup.js'></script>";
    }

    function start_form() {
    }

    function create_text_input_widgets(){
      $text_input_db_ent = $this->text_input_db_ent;

      for ($text_input_db_ent as $db_ent) {
	$db_ent->make_text_input_widget();
      } 
    }

    function create_select_widgets() {
      $select_db_ent = $this->select_db_ent;

      for ($select_db_ent as $db_ent) {
	$db_ent->make_text_input_widget();
      } 
    }

    function create_widgets() {
      create_text_input_widgets();
      create_select_widgets();
    }

    function content() {
      start_form();
      create_widgets();
      end_form();
    }

    function cleanup() {
      $conn = $this->db_conn;
      oci_close($conn);
    }
}




?>


