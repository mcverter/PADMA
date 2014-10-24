<?php
require_once(__DIR__ . "/../templates/WebPage.php");

class ManageDataMainPage extends WebPage
{

    const PG_TITLE = "Manage Data";

    /**
     * @return bool
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctions::check_role(WebPage::SUPERVISING_ROLE);
    }

    /**
     * @param $title
     * @param $userid
     * @param $role
     * @return string
     */
    function make_main_content($title, $userid, $role)
    {
        $returnString = '';
        $returnString .= <<< EOT
        <ul class="nav nav-pills nav-stacked">
            <li> <a href="../webpages/experiment_list.php">Edit Experiment</a></li>
            <li> <a href="../webpages/upload_experiment.php">Upload Experiment</a></li>
            <li> <a href="../webpages/delete_experiment.php">Delete Experiment</a></li>

EOT;
        if ($role === WebPage::ADMINISTRATOR_ROLE) {
            $returnString .= <<< EOT
            <li> <a href="../webpages/upload_reference.php">Upload Reference</a></li>
            <li> <a href="../webpages/delete_reference.php">Delete Reference</a></li>
EOT;

            $returnString .= <<< EOT
        </ul>
EOT;
        return $returnString;

        }


    }

    /**
     * @param $title
     * @param $userid
     * @param $role
     * @return string
     */
    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }


}


