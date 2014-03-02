<?php
require_once("WebPage.php");
require_once("WidgetMaker.php");

class DataManagement extends WebPage {
    public function prepare() {
        check_role('ar');
        parent::prepare();
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
          upload_experiment_widget();
          delete_experiment_widget();
          edit_experiment_widget();
      }

      if ($role=="Administrator")
      {
          upload_experiment_widget();
          delete_experiment_widget();
          edit_experiment_widget();

          upload_reference_data_widget();
          delete_reference_data_widget();
      }

        echo <<< EOT

    </fieldset>
    <table class="footerImage">
    </table>
EOT;
    }
}









