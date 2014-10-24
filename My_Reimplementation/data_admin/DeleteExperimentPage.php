<?php

require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");
class_alias('DBFunctions', 'dbFn');
class_alias('WidgetMaker', 'wMk');

/**
 * Class DeleteExperimentPage
 *
 * Used to Delete an Experiment from the Database
 *
 */
class DeleteExperimentPage extends DatabaseConnectionPage
{
    const PG_TITLE = "Delete Experiment";

    const EXPERIMENT_LABEL = "Experiment to Delete";
    const EXPERIMENT_POSTVAR = "Experiment";
    const EXPERIMENT_KEYVAL = "EXP_NAME";

    /**
     * @param $title
     * @param $userid
     * @param $role
     * @return string
     */
    function make_page_middle($title, $userid, $role){
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
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
     * @param $title
     * @param $userid
     * @param $role
     * @return string
     * @throws ErrorException
     */
    function make_main_content($title, $userid, $role)
    {
        $returnString = '';
        if (isset ($_POST[self::EXPERIMENT_POSTVAR]) &&
            !empty ($_POST[self::EXPERIMENT_POSTVAR])
        ) {
            $db_conn = $this->db_conn;
            $expName = $_POST[self::EXPERIMENT_POSTVAR];
            dbFn::deleteExperiment($db_conn, $expName);
            $message =  "Experiment $expName has been deleted";
            $returnString .= wMk::successMessage('success', $message);
        }

        $actionUrl = $_SERVER['PHP_SELF'];

        $returnString .=<<< EOT
            <h2>Select an Experiment to delete</h2>
EOT

            . wMk::start_form($actionUrl)

            . wMk::select_input(
                self::EXPERIMENT_LABEL,
                self::EXPERIMENT_POSTVAR,
                $this->showExperimentList(),
                self::EXPERIMENT_KEYVAL,
                self::EXPERIMENT_KEYVAL,
                false)

            .  wMk::submit_button('deleteBtn', 'Delete', '')
            . wMk::end_form();

        return $returnString;
    }
}





