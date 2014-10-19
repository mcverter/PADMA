<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

/**
 * Class EditExperimentPage
 */
class EditExperimentPage extends DatabaseConnectionPage
{
    const EXPERIMENT_LABEL = "Experiment Name";
    const EXPERIMENT_SELECT_NAME = "Experiment";
    const EXPERIMENT_KEYVAL = "EXP_NAME";
    const EXPNAME_POSTVAR = "expName";
    const DESCRIPTION_SCRIPT = "ReadExperimentDescription.php";

    function get_title() {
        return "Edit Experiment";
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
            $this->showExperimentMasterList(),
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


    function make_main_frame($title, $userid, $role)
    {

        $actionUrl = $_SERVER['PHP_SELF'];

        $returnString = <<< EOT
        <h2> Edit Description </h2>
        <form action=$actionUrl>
EOT;

        wMk::select_input(self::EXPERIMENT_LABEL, self::EXPERIMENT_SELECT_NAME,$this->showExperimentMasterList(), "EXP_NAME", false);

        wMk::submit_button('editDescription', 'Edit Description');

         $returnString .= <<< EOT
        </form>
        <div name="description"> </div>
EOT;

        return $returnString;
    }
}