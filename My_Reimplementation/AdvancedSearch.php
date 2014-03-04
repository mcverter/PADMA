<?php
require_once("SearchBase.php");
$select_input_widgets = Array($biofunction, $exp_name,$category, $species, $subject);
$text_input_widgets = Array($probeid, $cgnumber, $fbcgnumber, $genename, $gonumber);

class AdvancedSearch extends SearchBase {
    function __construct() {
      parent::__construct();
        global $select_input_widgets, $text_input_widgets;
        $this->title= "Advanced Search";
        $this->select_input_widgets = $select_input_widgets;
        $this->text_input_widgets = $text_input_widgets;

    }
}

$as = new AdvancedSearch();
$as->display_page();

?>