<?php

require_once("../templates/WebPage.php");

/**
 * Class UploadAgreementPage
 */
class UploadAgreementPage extends WebPage {
    const PG_TITLE =  "Upload Agreement";

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
     * @Override
     * Shows the main functional content block of the page
     * Shows the Agreement required to upload an Experiment.
     * If "AGREE" checkbox is not checked on submit, page can not advance
     * Otherwise, User can advance to UploadExperiment
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */

    public function make_main_content($userid, $role) {
        $returnString = <<<EOT

<div class="instructions">
    PLEASE READ THE FOLLOWING TERMS OF USE BEFORE UPLOADING TO THE
    PATHOGEN ASSOCIATED DROSOPHILA  MICROARRAY (PADMA) DATABASE.
</div>
<div>
    <h2>Data Submission to PADMA Database</h2>
    <ol>
        <li>The dataset ("Dataset") I will upload for inclusion in the PADMA database is my work product.</li>
        <li>Incorporation of my Dataset into the
            PADMA database will not violate any rights
            of any kind or nature whatsoever of any
            third party.</li>
        <li>I have the full right, power and
            authority to make this submission to the
            PADMA database maintained by The City
            College of New York.</li>
        <li>My agreement to these terms of use is
            in addition to the intellectual property
            and ownership notice as wall as disclaimer
            and limitation of liability agreed at
            my user registration.</li>
    </ol>
    <h2>Instruction</h2>
    <p>If you have an administrative account, you may select either "local" or "global" option when you upload your Dataset. The local
        option will limit the access of the uploaded Dataset only to your account, whereas the global
        option will allow the access for anyone registered to and active in the PADMA system. </p>
</div>


<form class="central_widget"  action="uploadagreement.php" method="post">

    <label> <input type="radio" name="terms" value="agree" />Agree</label>
    <label> <input type="radio" name="terms" value="disagree" checked />Disagree</label>
    <input type="submit" value="Submit" />
EOT;

        if (isset($_POST['terms'])) {
            if ($_POST['terms'] == "agree") header("Location: expLoaderStart.php");
            else header("Location: DataManagement.php");
            exit;
        }

        $returnString .=" </form>";
        return $returnString;

    }


}








