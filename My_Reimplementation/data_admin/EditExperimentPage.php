<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

/**
 * Class EditExperimentPage
 */
class EditExperimentPage extends DatabaseConnectionPage
{
    const PG_TITLE =  "Edit Experiment";

    const EXPERIMENT_LABEL = "Experiment Name";
    const EXPERIMENT_SELECT_NAME = "Experiment";
    const EXPERIMENT_KEYVAL = "EXP_NAME";
    const EXPNAME_POSTVAR = "expName";
    const DESCRIPTION_SCRIPT = "ReadExperimentDescription.php";

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
    function make_experiment_select()
    {
        wMk::select_input(
            self::EXPERIMENT_LABEL,
            self::EXPERIMENT_SELECT_NAME,
            $this->showExperimentMasterList(),
            self::EXPERIMENT_KEYVAL,
            self::EXPERIMENT_KEYVAL,
            false);
    }

    /**
     * @throws ErrorException
     */
    function showExperimentMasterList()
    {
        $role = $this->$role;

        if ($role == wPg::ADMINISTRATOR_ROLE) {
            return dbFn::selectUnrestrictedExperimentListFromMaster($this->db_conn);
        } elseif ($role == wPg::RESEARCHER_ROLE) {
            return dbFn::selectRestrictedExperimentListFromMaster($this->db_conn, $this->userid);
        } else {
            throw new ErrorException();
        }
    }

    /**
     * @param $name
     */
    function showExperimentDescription($name)
    {
        dbFn::selectExperimentDescription($this->db_conn, $name);
    }

    /**
     * @param $name
     * @param $description
     */
    function changeExperimentDescription($name, $description)
    {
        dbFn::updateExperimentDescription($this->db_conn, $name, $description);
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

        $actionUrl = $_SERVER['PHP_SELF'];

        $returnString = <<< EOT
        <h2> Edit Description </h2>
        <form action=$actionUrl>
EOT;

        wMk::select_input(self::EXPERIMENT_LABEL,
            self::EXPERIMENT_SELECT_NAME,
            $this->showExperimentMasterList(),
            "EXP_NAME",
            "EXP_NAME",
            false);

        wMk::submit_button('editDescription', 'Edit Description');

        $returnString .= <<< EOT
        </form>
        <div name="description"> </div>
EOT;

        return $returnString;
    }

    function make_js() {

        $returnString = parent::make_js();
        $experiment_select_name = self::EXPERIMENT_SELECT_NAME;
        $description_script = self::DESCRIPTION_SCRIPT;
        $description_area = '';

        $innerHTML =
            wMk::start_form($_SERVER['PHP_SELF']) .
            wMk::text_area() .
            wMk::submit_button() .
            wMk::end_form();

        $returnString .= <<< EOT

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function(event) {
        event.preventDefault();
        $('#$experiment_select_name').change(function() {
            var experimentData = {expName : $(this).name }
            $.post('$description_script', experimentData, function(data) {
                $('#$description_area').html($innerHTML});
            });
        });
    });
</script>
EOT;
        return $returnString;

    }
}