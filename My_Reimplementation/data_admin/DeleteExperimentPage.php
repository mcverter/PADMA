<?php

require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");
class_alias('DBFunctions', 'dbFn');
class_alias('WidgetMaker', 'wMk');

/**
 * Class DeleteExperimentPage
 */
class DeleteExperimentPage extends DatabaseConnectionPage
{

    const EXPERIMENT_LABEL = "Experiment to Delete";
    const EXPERIMENT_SELECT_NAME = "Experiment";
    const EXPERIMENT_KEYVAL = "EXP_NAME";
    const EXPNAME_POSTVAR = "expName";



    function get_title() {
        return "Delete Experiment";
    }


  function make_page_middle($title, $userid, $role){
    return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
      }

    /**
     * @throws ErrorException
     */
    function make_experiment_select()
    {
        wMk::select_input(
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
        wMk::submit_button('deleteBtn', 'Delete', '');
    }


    /**
     * @throws ErrorException
     */
    function showExperimentList()
    {
        $db_conn = $this->db_conn;
        $role = $this->role;
        $userid = $this->userid;

        if ($role == wPg::ADMINISTRATOR_ROLE) {
            return dbFn::selectAllUnrestrictedExperimentList($db_conn, $userid);
        } else if ($role == wPg::RESEARCHER_ROLE) {
            return dbFn::selectUserRestrictedExperimentList($db_conn, $userid);
        } else {
            throw new ErrorException();
        }
    }


    /**
     *
     */
    function __construct()
    {
        $_SESSION[wPg::ROLE_SESSVAR] = wPg::ADMINISTRATOR_ROLE;
        PageControlFunctions::check_role('ar');
        parent::__construct();
    }


    /**
     *
     */
    function make_main_frame($title, $userid, $role)
    {
        $returnString = '';
        if (isset ($_POST[self::EXPNAME_POSTVAR]) &&
            !empty ($_POST[self::EXPNAME_POSTVAR])
        ) {
            $db_conn = $this->db_conn;
            $expName = $_POST[self::EXPNAME_POSTVAR];
            dbFn::deleteExperiment($db_conn, $expName);
            $returnString .= <<< EOT
            <h2> Experiment $expName has been deleted </h2>
EOT;
        }

        $actionUrl = $_SERVER['PHP_SELF'];

        $returnString .=<<< EOT

        <form name="form1" action="$actionUrl" method="post">
            <h2>Select an Experiment to delete</h2>
EOT;

        $this->make_experiment_select();

        $this->make_submit_button();


        $returnString .=<<< EOT
        </form>
EOT;
        return $returnString;
    }
}





