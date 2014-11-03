<?php

require_once("../templates/DatabaseConnectionPage.php");

/**
 * Class DeleteExperimentPage
 *
 * Used to Delete an Experiment from the Database
 *
 */
class DeleteExperimentPage extends DatabaseConnectionPage
{
    const PG_TITLE = "Delete Experiment";
    const DESCRIPTION_DIV = 'expDesc';

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


        if ($role == PageControlFunctionsAndConsts::ADMINISTRATOR_ROLE) {
            return dbFn::selectAllUnrestrictedExperimentList($db_conn, $userid);
        } else if ($role == PageControlFunctionsAndConsts::RESEARCHER_ROLE) {
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
        if (isset ($_POST[DBFunctionsAndConsts::EXP_NAME_COL]) &&
            !empty ($_POST[DBFunctionsAndConsts::EXP_NAME_COL])
        ) {
            $db_conn = $this->db_conn;
            $expName = $_POST[DBFunctionsAndConsts::EXP_NAME_COL];
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
                "Experiment to Delete",
                DBFunctionsAndConsts::EXP_NAME_COL,
                $this->showExperimentList(),
                dbFn::EXP_NAME_COL,
                dbFn::EXP_NAME_COL,
                false).
                '<div> '. self::DESCRIPTION_DIV . '</div>'

            .  wMk::submit_button('deleteBtn', 'Delete', '')
                . wMk::end_form();

        return $returnString;
    }


    function make_js() {
        $returnString = parent::make_js();
        $role = $this->role;
        list ($description_div, $experiment_select, $show_experiment_cmd) =
            array (self::DESCRIPTION_DIV,
                DBFunctionsAndConsts::EXP_NAME_COL,
            PageControlFunctionsAndConsts::SHOW_DESCRIPTION_COMMAND);
        $returnString .= $returnString .= <<< EOT
        <script>
        $(document).ready( function () {
            $(document).on("change", '#$experiment_select' ,function() {
                var selected = this.value;
                $.ajax({
                url: '../search/SearchAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    experimentid : selected, command: '$show_experiment_cmd', role: '$role'
                 },
                success: function(experimentDesc) {
                    console.log(experimentDesc);
                    $('#$description_div').html(experimentDesc);
                }
            });
        });
    }
EOT;

}







