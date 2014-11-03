<?php

require_once("../templates/DatabaseConnectionPage.php");

/**
 * Class ExperimentListPage
 */
class ExperimentListPage extends DatabaseConnectionPage{

    const PG_TITLE = 'Experiment List';
    const DESCRIPTION_DIV_ID = 'description';
    const EXPERIMENT_SELECT_ID = 'experiment';
    /**
     * @Override
     * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_page_middle($userid, $role) {
        return $this->make_image_content_columns ($userid, $role, 'L', 4) ;
    }

    /**
     * @Override
     *
     * Makes the main functional content block of the page
     *
     * Displays a SELECT widget for the user to choose an experiment
     *  and a DIV for the description to go into.
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */
    function make_main_content($userid, $role) {
        $db_conn = $this->db_conn;
        $userid = $this->userid;
        $description_div = self::DESCRIPTION_DIV_ID;

        $returnString = wMk::select_input("Experiment List",
                self::EXPERIMENT_SELECT_ID,
                dbFn::selectAllUnrestrictedExperimentList($db_conn, $userid),
                dbFn::EXP_NAME_COL,
                dbFn::EXP_NAME_COL,
                false)
            . <<< EOT

            <br>
            <br>
            <div id='$description_div'></div>
            <br>
EOT;
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
    function make_js() {
        $returnString = parent::make_js();

        list ($experiment_select, $description_div) =
            array (self::EXPERIMENT_SELECT_ID,
                self::DESCRIPTION_DIV_ID);
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