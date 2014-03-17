<?php
require_once(__DIR__ . "/../templates/WebPage.php");
require_once(__DIR__ . "/../widgets/WidgetMaker.php");

class DataManagementIndexPage extends WebPage {

    public function __construct() {
        parent::__construct();
        check_role('ar');
    }

    function print_content() {
        echo <<< EOT

        <table class="headerImage"></table>
    <h2>Select One...</h2>
    <fieldset>
EOT;
        $role = $_SESSION['role'];
      if ($role=="Researcher")
      {
       
	WidgetMaker::make_load_experiment_button() ;
	WidgetMaker::make_delete_experiment_button() ;
	WidgetMaker::make_edit_experiment_button() ;
      }

      if ($role=="Administrator")
      {
	WidgetMaker::make_load_experiment_button() ;
	WidgetMaker::make_delete_experiment_button() ;
	WidgetMaker::make_edit_experiment_button() ;

	WidgetMaker::make_load_reference_button();
	WidgetMaker::make_delete_reference_button();
      }

        echo <<< EOT

    </fieldset>
    <table class="footerImage">
    </table>
EOT;
    }
}






