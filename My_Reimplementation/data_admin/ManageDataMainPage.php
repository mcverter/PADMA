<?php
require_once(__DIR__ . "/../templates/WebPage.php");

class ManageDataMainPage extends WebPage
{
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctions::check_role(WebPage::SUPERVISING_ROLE);
    }

    function __construct() {
        parent::__construct();
    }

    function make_main_frame($title, $userid, $role)
    {
        $returnString = '';
        $returnString .= <<< EOT
        <ul class="nav nav-pills nav-stacked">
            <li> <a href="../webpages/edit_experiment.php">Edit Experiment</a></li>
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

    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }

    function get_title() {
        return "Manage Data";
    }
}


