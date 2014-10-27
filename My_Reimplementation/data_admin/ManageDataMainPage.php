<?php
require_once(__DIR__ . "/../templates/WebPage.php");

/**
 * Class ManageDataMainPage
 */
class ManageDataMainPage extends WebPage
{

    const PG_TITLE = "Manage Data";

    /**
     * @return bool
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(pgFn::SUPERVISING_ROLE);
    }

    /**
     * @Override
     * Shows the main functional content block of the page
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_main_content($userid, $role)
    {
        $returnString = '';
        $returnString .= <<< EOT
        <ul class="nav nav-pills nav-stacked">
            <li> <a href="../webpages/experiment_list.php">Edit Experiment</a></li>
            <li> <a href="../webpages/upload_experiment.php">Upload Experiment</a></li>
            <li> <a href="../webpages/delete_experiment.php">Delete Experiment</a></li>
EOT;
        if ($role === pgFn::ADMINISTRATOR_ROLE) {
            $returnString .= <<< EOT
            <li> <a href="../webpages/upload_reference.php">Upload Reference</a></li>
            <li> <a href="../webpages/delete_reference.php">Delete Reference</a></li>
EOT;
            $returnString .= <<< EOT
        </ul>
EOT;
        }
        return $returnString;
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

    function make_page_middle($userid, $role) {
        return $this->make_image_content_columns ($userid, $role, 'R', 8) ;
    }


}


