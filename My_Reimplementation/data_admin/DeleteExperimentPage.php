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
     * Only Researchers and Administrators are allowed to Delete Experiments
     *
     * @return bool:  Whether user is allowed to view page
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(PageControlFunctionsAndConsts::SUPERVISING_ROLE);
    }

    /**
     * @Override
     * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_page_middle($userid, $role)
    {
        return $this->make_image_content_columns($userid, $role, 'R', 4);
    }

    /**
     *
     * In comparison with an ADMINISTRATOR, a RESEARCHERS
     *    only has authority to delete a limited set of experiments
     *
     * This function returns the appropriate list according to
     *   the users ROLE.
     *
     */
    function selectExperimentList()
    {
        $db_conn = $this->db_conn;
        $role = $this->role;
        $userid = $this->userid;


        if ($role == PageControlFunctionsAndConsts::ADMINISTRATOR_ROLE) {
            return DBFunctionsAndConsts::selectAllUnrestrictedExperimentList($db_conn, $userid);
        } else if ($role == PageControlFunctionsAndConsts::RESEARCHER_ROLE) {
            return DBFunctionsAndConsts::selectUserRestrictedExperimentList($db_conn, $userid);
        } else {
            return PageControlFunctionsAndConsts::redirectDueToError("Page accessed by user who is neither Admin nor Researcher");
        }
    }

    /**
     * @Override
     *
     * Shows the main functional content block of the page
     * Shows list of Experiments which may be deleted.
     * If EXPERIMENT_POSTVAR is set, that experiment will be deleted
     *
     * @param $userid :  Logged in User
     * @param $role :  User's Role
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
            DBFunctionsAndConsts::deleteExperiment($db_conn, $expName);
            $returnString .= WidgetMaker::successMessage('success',
                "Experiment $expName has been deleted");
        }

        $returnString .= <<< EOT
            <h2>Select an Experiment to delete</h2>
EOT

            . WidgetMaker::start_form($_SERVER['PHP_SELF'])
            . WidgetMaker::select_input(
                "Experiment",
                DBFunctionsAndConsts::EXP_NAME_COL,
                $this->selectExperimentList(),
                DBFunctionsAndConsts::EXP_NAME_COL,
                DBFunctionsAndConsts::EXP_NAME_COL,
                false) .
            '<div id="' . self::DESCRIPTION_DIV . '"></div>'
            . WidgetMaker::submit_button('deleteBtn', 'Delete', '')
            . WidgetMaker::end_form();
        return $returnString;
    }

    /**
     * Creates the page's javascript
     *
     * Creates an AJAX callback for the description to
     *  show up in the Description DIV when an experiment
     *  is selected
     *
     * @return string:  Javascript for file
     */
    function make_js()
    {
        $returnString = parent::make_js();
        list ($description_div, $experiment_select) =
            array(self::DESCRIPTION_DIV,
                DBFunctionsAndConsts::EXP_NAME_COL);
        $returnString .= $returnString .= <<< EOT
<script>
    $(document).ready( function () {
        $(document).on("change", '#$experiment_select' ,function() {
            var selected = this.value;
            $.ajax({
                url: '../data_admin/ExperimentDescriptionAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    experimentid : selected
                },
                success: function(experimentDesc) {
                    console.log(experimentDesc);
                    var html_txt = "<br><br> <h4> Description of " +  selected + "</h4>" + "<div>" + experimentDesc + "</div>";
                    $('#$description_div').html(html_txt);
                }
            });
        });
    });
</script>
EOT;
        return $returnString;
    }
}







