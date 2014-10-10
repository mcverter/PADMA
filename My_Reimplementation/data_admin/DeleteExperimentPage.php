<?php

require_once(__DIR__ . "/../page_templates/DatabaseConnectionPage.php");

/**
 * Class DeleteExperimentPage
 */
class DeleteExperimentPage extends DatabaseConnectionPage
{

    const EXPERIMENT_LABEL = "Experiment to Delete";
    const EXPERIMENT_SELECT_NAME = "Experiment";
    const EXPERIMENT_KEYVAL = "EXP_NAME";
    const EXPNAME_POSTVAR = "expName";


    /**
     * @throws ErrorException
     */
    function make_experiment_select()
    {
        WidgetMaker::select_input(
            self::EXPERIMENT_LABEL,
            self::EXPERIMENT_SELECT_NAME,
            $this->showExperimentList(),
            self::EXPERIMENT_KEYVAL,
            false);
    }

    /**
     *
     */
    function make_submit_button()
    {
        WidgetMaker::submit_button('deleteBtn', 'Delete', '');
    }


    /**
     * @throws ErrorException
     */
    function showExperimentList()
    {
        $db_conn = $this->db_conn;
        $role = $this->role;
        $userid = $this->userid;

        if ($role == 'Administrator') {
            return DBFunctions::selectAllUnrestrictedExperimentList($db_conn, $userid);
        } else if ($role == 'Researcher') {
            return DBFunctions::selectUserRestrictedExperimentList($db_conn, $userid);
        } else {
            throw new ErrorException();
        }
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
    function print_content()
    {
        if (isset ($_POST[self::EXPNAME_POSTVAR]) &&
            !empty ($_POST[self::EXPNAME_POSTVAR])
        ) {
            $db_conn = $this->db_conn;
            $expName = $_POST[self::EXPNAME_POSTVAR];
            DBFunctions::deleteExperiment($db_conn, $expName);
            echo <<< EOT
            <h2> Experiment $expName has been deleted </h2>
EOT;
        }

        $actionUrl = $_SERVER['PHP_SELF'];

        echo<<< EOT

        <form name="form1" action="$actionUrl" method="post">
            <h2>Select an Experiment to delete</h2>
EOT;

        $this->make_experiment_select();

        $this->make_submit_button();


        echo<<< EOT
        </form>
EOT;
    }
}





