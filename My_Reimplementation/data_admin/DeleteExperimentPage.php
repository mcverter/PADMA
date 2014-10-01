<?php

require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class DeleteExperimentPage extends DatabaseConnectionPage
{

    const EXPERIMENT_LABEL = "Experiment to Delete";
    const EXPERIMENT_SELECT_NAME = "Experiment";
    const EXPERIMENT_KEYVAL = "EXP_NAME";
    const EXPNAME_POSTVAR = "expName";


    function make_experiment_select()
    {
        WidgetMaker::form_select(
            self::EXPERIMENT_LABEL,
            self::EXPERIMENT_SELECT_NAME,
            $this->showExperimentList(),
            self::EXPERIMENT_KEYVAL,
            false);
    }

    function make_submit_button()
    {
        WidgetMaker::submit_button('deleteBtn', 'Delete', '');
    }


    function showExperimentList()
    {
        $db_conn = $this->db_conn;
        $role = $this->role;
        $userid = $this->userid;

        if ($role == 'Administrator') {
            return db_selectAllUnrestrictedExperimentList($db_conn, $userid);
        } else if ($role == 'Researcher') {
            return db_selectUserRestrictedExperimentList($db_conn, $userid);
        } else {
            throw new ErrorException();
        }
    }

    function exec_delete_experiment($name)
    {
        deleteExperiment($name);
    }

    function __construct()
    {
        $_SESSION['role'] = 'Administrator';
        check_role('ar');
        parent::__construct();
    }

    function print_content()
    {
        if (isset ($_POST[self::EXPNAME_POSTVAR]) &&
            !empty ($_POST[self::EXPNAME_POSTVAR])
        ) {
            $expName = $_POST[self::EXPNAME_POSTVAR];
            $this->exec_delete_experiment($expName);
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





