<?php
require_once(__DIR__ . "/../page_templates/DatabaseConnectionPage.php");

/**
 * Class EditExperimentPage
 */
class EditExperimentPage extends DatabaseConnectionPage
{
    const EXPERIMENT_LABEL = "Experiment Name";
    const EXPERIMENT_SELECT_NAME = "Experiment";
    const EXPERIMENT_KEYVAL = "EXP_NAME";
    const EXPNAME_POSTVAR = "expName";
    const DESCRIPTION_SCRIPT = "ReadExperimentDescription.php";

    /**
     * @throws ErrorException
     */
    function make_experiment_select()
    {
        WidgetMaker::select_input(
            self::EXPERIMENT_LABEL,
            self::EXPERIMENT_SELECT_NAME,
            $this->showExperimentMasterList(),
            self::EXPERIMENT_KEYVAL,
            false);
    }

    /**
     * @throws ErrorException
     */
    function showExperimentMasterList()
    {
        $role = $this->$role;

        if ($role == 'Administrator') {
            return DBFunctions::selectUnrestrictedExperimentListFromMaster($this->db_conn);
        } elseif ($role == 'Researcher') {
            return DBFunctions::selectRestrictedExperimentListFromMaster($this->db_conn, $this->userid);
        } else {
            throw new ErrorException();
        }
    }

    /**
     * @param $name
     */
    function showExperimentDescription($name)
    {
        DBFunctions::selectExperimentDescription($this->db_conn, $name);
    }

    /**
     * @param $name
     * @param $description
     */
    function changeExperimentDescription($name, $description)
    {
        DBFunctions::updateExperimentDescription($this->db_conn, $name, $description);
    }

    /**
     *
     */
    function __construct()
    {
        $_SESSION['role'] = 'Administrator';
        PageControlFunctions::check_role('ar');
        parent::__construct();
    }

    /**
     *
     */
    function print_js() {
        $experiment_select_name = self::EXPERIMENT_SELECT_NAME;
        $description_script = self::DESCRIPTION_SCRIPT;

        $innerHTML =
            WidgetMaker::start_form($_SERVER['PHP_SELF']) .
            WidgetMaker::text_area() .
            WidgetMaker::submit_button() .
            WidgetMaker::end_form();

        $descriptionScript = '';
        echo <<< EOT
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript">
        $(document).ready(function(event) {
            event.preventDefault();
            $('#{$experiment_select_name}').change(function() {
                var experimentData = {expName : $(this).name }
                $.post('{$descriptionScript}', experimentData, function(data) {
                    $('#description').innerHTML({$innerHTML});
                });
          });
        });
        </script>
EOT;

    }
    function print_content()
    {

        $actionUrl = $_SERVER['PHP_SELF'];

        echo <<< EOT
        <h2> Edit Description </h2>
        <form action=$actionUrl>
EOT;

        WidgetMaker::select_input(self::EXPERIMENT_LABEL, self::EXPERIMENT_SELECT_NAME,$this->showExperimentMasterList(), "EXP_NAME", false);

        WidgetMaker::submit_button('editDescription', 'Edit Description');

         echo <<< EOT
        </form>
        <div name="description"> </div>
EOT;

    }
}