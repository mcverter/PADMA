<?php

require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

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

    /**
     * @Override
     * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_page_middle($userid, $role){
        return $this->make_image_content_columns ($userid, $role, 'R', 8) ;
    }

    /**
     *
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
     * @Override
     *
     * Shows the main functional content block of the page
     * Shows list of Experiments which may be deleted.
     * If EXPERIMENT_POSTVAR is set, that experiment will be deleted
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */
    function make_main_content($userid, $role)
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
                dbFn::EXP_NAME_COL,
                dbFn::EXP_NAME_COL,
                false)

            .  wMk::submit_button('deleteBtn', 'Delete', '')
            . wMk::end_form();

        return $returnString;
    }
}





