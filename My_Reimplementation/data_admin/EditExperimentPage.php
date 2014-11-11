<?php
require_once("../templates/DatabaseConnectionPage.php");

/**
 * Class EditExperimentPage
 *
 * Creates a page in which Administrators and Researchers
 *  may Edit the Descriptions of Experiments in the Database
 */
class EditExperimentPage extends DatabaseConnectionPage
{
    const PG_TITLE =  "Edit Experiment";
    const DESCRIPTION_DIV = "desc_div";

    /**
     * Only Researchers and Administrators are allowed to Edit Experiments
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

    function make_page_middle($userid, $role){
        return $this->make_image_content_columns ($userid, $role, 'R', 4) ;
    }

    /**
     *
     * In comparison with an ADMINISTRATOR, a RESEARCHERS
     *    only has authority to edit a limited set of experiments
     *
     * This function returns the appropriate list according to
     *   the users ROLE.
     *
     * @return resource
     */
    function selectExperimentMasterList()
    {
        $role = $this->role;

        if ($role == PageControlFunctionsAndConsts::ADMINISTRATOR_ROLE) {
            return DBFunctionsAndConsts::selectUnrestrictedExperimentListFromMaster($this->db_conn);
        } elseif ($role == PageControlFunctionsAndConsts::RESEARCHER_ROLE) {
            return DBFunctionsAndConsts::selectRestrictedExperimentListFromMaster($this->db_conn, $this->userid);
        } else {
             PageControlFunctionsAndConsts::redirectDueToError("Page accessed by user who is neither Admin nor Researcher");
            return;
        }
    }

    /**
     * @Override
     * Shows the main functional content block of the page
     *
     * If the form been posted, the description is updated
     *    and a confirmation message is printed
     *
     * A select widget displays the experiments
     * A div is used to present the descriptions
     *
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_main_content($userid, $role)
    {
        $db_conn = $this->db_conn;

        $returnString = '';

        if (isset($_POST[DBFunctionsAndConsts::EXP_NAME_COL]) &&
            isset($_POST[DBFunctionsAndConsts::EXP_DESC_COL])) {
            $exp_name = $_POST[DBFunctionsAndConsts::EXP_NAME_COL];
            $exp_desc = $_POST[DBFunctionsAndConsts::EXP_DESC_COL];
            DBFunctionsAndConsts::updateExperimentDescription($db_conn, $exp_name, $exp_desc);
            $returnString .= WidgetMaker::successMessage('success',
                "Description of $exp_name has been updated");
        }

        $returnString .= WidgetMaker::start_form($_SERVER['PHP_SELF'])
            . WidgetMaker::select_input("Experiment Name",
                DBFunctionsAndConsts::EXP_NAME_COL,
                $this->selectExperimentMasterList(),
                DBFunctionsAndConsts::EXP_NAME_COL,
                DBFunctionsAndConsts::EXP_NAME_COL,
                false)
        ;

        $desc_div = self::DESCRIPTION_DIV;

        $returnString .= <<< EOT

        <div id="$desc_div"></div>
EOT;

        $returnString .=  WidgetMaker::submit_button('editDescription', 'Edit Description') .
            WidgetMaker::end_form();
        return $returnString;
    }


    /**
     * Creates the page's javascript
     *
     * Creates an AJAX callback for the description to
     *  show up in a TEXTAREA within the Description DIV
     *  when an experiment is selected
     *
     * @return string:  Javascript for file
     */
    function make_js() {
        $returnString = parent::make_js();
        list ($description_div, $experiment_select,
            $description_textarea) =
            array(self::DESCRIPTION_DIV,
                DBFunctionsAndConsts::EXP_NAME_COL,
                DBFunctionsAndConsts::EXP_DESC_COL);
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
                    var html_txt = "<br><br><hr><br><br> <h5> Description of " +  selected + "</h5><br><textarea id='$description_textarea' cols=50 rows=5 name='$description_textarea'>" + experimentDesc + "</textarea>";
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


