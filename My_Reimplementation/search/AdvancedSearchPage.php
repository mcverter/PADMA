<?php
require_once(__DIR__ . "/SearchBase.php");

class AdvancedSearchPage extends SearchBase {
    function __construct() {
      parent::__construct();
        $this->title= "Advanced Search";
        $this->searchType = "advanced";

        $this->select_input_func = Array
	  ( "DB_WidgetMaker::make_exp_name_select",
	    "DB_WidgetMaker::make_category_select",
	    "DB_WidgetMaker::make_species_select",
	    "DB_WidgetMaker::make_subject_select",
	    "DB_WidgetMaker::make_biofunction_select");
 

	$this->text_input_func = Array
	  (  "DB_WidgetMaker::make_cgnumber_input", 
	     "DB_WidgetMaker::make_probeid_input", 
	     "DB_WidgetMaker::make_genename_input",
	     "DB_WidgetMaker::make_flybase_input",
	     "DB_WidgetMaker::make_gonumber_input");
    }
}

?>