<?php

require_once("../templates/WebPage.php");

/**
 * Class UploadAgreementPage
 */
class UploadAgreementPage extends WebPage {
    const PG_TITLE =  "Upload Agreement";

    const AGREEMENT_RADIO_ID = "terms";
    const ERROR_MSG_ID = "mustAgreeMsg";
    const AGREE_VALUE = "Agree";
    const DISAGREE_VALUE = "Disagree";
    const AGREEMENT_FORM_ID = "UserAgreementForm";

    /**
     * Only Researchers and Administrators are allowed to Upload Experiments
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
        return $this->make_image_content_columns ($userid, $role, 'R', 3) ;
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
EOT;
        $actionUrl = "../webpages/upload_experiment.php";
        $returnString  .= WidgetMaker::errorMessage(self::ERROR_MSG_ID, "You must agree to the Terms in order to upload an experiment")
            . WidgetMaker::start_form($actionUrl, "POST", self::AGREEMENT_FORM_ID)
            . WidgetMaker::radio_input(self::AGREE_VALUE, self::AGREEMENT_RADIO_ID, self::AGREE_VALUE, '')
            . WidgetMaker::radio_input(self::DISAGREE_VALUE, self::AGREEMENT_RADIO_ID, self::DISAGREE_VALUE, "checked")
            . WidgetMaker::submit_button("submit", "I Agree")
            . WidgetMaker::end_form();

        return $returnString;
    }


    /**
     * Adds a jquery validation to the AgreementForm.
     * If the "AGREE" radio button is not clicked,
     *  an error message will be displayed and the form will not be submitted
     *
     */
    function make_js() {
        $returnString = parent::make_js();
        list ($agree_val, $error_msg, $agree_radio, $agreement_form) =
            array(self::AGREE_VALUE, self::ERROR_MSG_ID,
                self::AGREEMENT_RADIO_ID, self::AGREEMENT_FORM_ID);
        $returnString .= <<< EOT

<script>
    $(document).ready(function() {
        $('#$error_msg').hide();
        $('#$agreement_form').submit(function checkAgreement(event) {
            if ($('#$agree_radio:checked').val() !== '$agree_val') {
                $('#$error_msg').show();
                event.preventDefault();
            }
        });
    });
</script>

EOT;
        return $returnString;
    }
}








