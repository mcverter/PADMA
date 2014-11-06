<?php
require_once("../templates/WebPage.php");

/**
 * Class ManageDataMainPage
 *
 * Shows the Menu for managing data
 */
class ManageDataMainPage extends WebPage
{

    const PG_TITLE = "Manage Data";

    /**
     * Only Researchers and Administrators are allowed to Edit Experiments
     *
     * @return bool:  Whether user is allowed to view page
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(pgFn::SUPERVISING_ROLE);
    }

    /**
     * @Override
     * Shows the main functional content block of the page
     *
     * Researchers and Admins can Edit, Delete, and Upload Experiments
     * Only Admins can Upload or Delete Reference Versions
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
            <li> <a href="../webpages/edit_experiment.php">Edit Experiment</a></li>
            <li> <a href="../webpages/upload_agreement.php">Upload Experiment</a></li>
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
        return $this->make_image_content_columns ($userid, $role, 'R', 4) ;
    }
}


