<?php
require_once(__DIR__ . "/../templates/WebPage.php");
require_once(__DIR__ . "/../widgets/WidgetMaker.php");

class DataManagement extends WebPage {

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
          make_upload_experiment_widget();
          make_delete_experiment_widget();
          make_edit_experiment_widget();
      }

      if ($role=="Administrator")
      {
          make_upload_experiment_widget();
          make_delete_experiment_widget();
          make_edit_experiment_widget();

          make_upload_reference_data_widget();
          make_delete_reference_data_widget();
      }

        echo <<< EOT

    </fieldset>
    <table class="footerImage">
    </table>
EOT;
    }
}

$dm = new DataManagement();
$dm->display_page();







