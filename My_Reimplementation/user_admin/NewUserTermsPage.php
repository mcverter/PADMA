<?php
require_once("../templates/WebPage.php");

/**
 * Class NewUserTermsPage
 *
 * Presents the Terms of Agreement Page for a user wishing to
 * regsiter as a member of the PADMA community
 */
class NewUserTermsPage extends WebPage{
    const PG_TITLE = "New User Terms of Agreement";
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
        return PageControlFunctionsAndConsts::check_role(pgFn::SUPERVISING_ROLE);
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
        return $this->make_image_content_columns ($userid, $role,'N') ;

    }
    /**
     * @Override
     *
     * Shows the terms of Usage and a radio button box
     *  for the user to register her agreement
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */
    function make_main_content($userid, $role) {

        $returnString = '';
        $returnString .= <<<EOT
<p>
    PLEASE READ THESE TERMS OF USE CAREFULLY BEFORE USING
    <a href="http://padmadatabase.org">http://padmadatabase.org</a>,
    INCLUDING THE PATHOGEN ASSOCIATED DROSOPHILA MICROARRAY (PADMA) DATABASE (the "Site").
</p>
<hr>
<h2>Terms of Use</h2>
<hr>

<p>
    Your use of the Site is subject to the following Terms of Use which include by reference the
    <a href="http://portal.cuny.edu/cms/id/cuny/documents/level_3_page/001171.htm">Computer Use Policy</a>
    and <a href="http://www.cuny.edu/website/privacy.html">Web Site Privacy Policy</a>
    of The City University of New York ("CUNY").
</p>

<p>
    If you do not agree with these Terms of Use, please do not use the Site.
    Your use of the Site indicates your acceptance of these Terms of Use.
    If we make any material changes to these Terms of Use, those changes will be posted here
    so that you are always aware of our Terms of Use.
    Since these Terms of Use may change from time to time, you should check back periodically.
    Your continued use of the Site following the posting of changes to the Terms of Use
    indicates your acceptance of such changes.
</p>
<hr>
<h2>Registration</h2>

<p>
    You must register in order to use the Site.  During the registration
    process, you will be asked to provide information about yourself.  We
    assume that the information you provide on your registration is
    accurate and complete, and it is your responsibility to promptly
    notify us of any changes.  When registering, you must select a <em>USER ID</em>
    and <em>PASSWORD</em>.  You are solely responsible for keeping your PASSWORD
    confidential.  You must notify us immediately of any known or
    suspected unauthorized use of your PASSWORD.
</p>
<hr>
<h2>Approved Use</h2>
<p>
    Subject to its acceptance of your registration and its written notice to you
    of such acceptance, CUNY hereby grants you a nonexclusive,
    nontransferable license to access and use the Site for personal, noncommercial,
    educational/research purposes in accordance with these Terms of Use.
    Use of the Site for commercial purposes, including without limitation use in
    furtherance of research and development activities performed for a commercial entity,
    or use for unlawful, illegal, or otherwise unethical activity in any jurisdiction,
    is strictly prohibited.  You may not reverse engineer, deconstruct, or disassemble
    any components of the Site.
    You may not copy any portion of the PADMA database for resale or publication of any kind in any media.
</p>
<ol>
    <li>Export of Query Results:  You may export search/query results obtained during the course of Approved Use of the Site by following the steps outlined in the PADMA User Manual.  Any other export or extraction of any component, data, or information of or from the Site is strictly prohibited.

    <li>Data Upload:  You may upload microarray data onto the Site solely for purposes of an Approved Use, by following the steps outlined in the PADMA User Manual.  Any data you upload to the Site will be incorporated into the PADMA database, and will remain in the database until you delete the file.  Subject to these Terms of Use, you will have sole access to the data you upload.

        USE OF THE DATA UPLOAD FUNCTION IS AT YOUR OWN RISK.  While we will take reasonable precautions to ensure that the Site is secure, we cannot guarantee, or otherwise prevent, exposure, access, or hijack of your data by an unauthorized third-party during the loading process or while your uploaded data reside in the PADMA database.  Any loss, exposure, or damage of data is strictly at your own risk.

    <li>Acknowledgement: If you use the Site in your research, you agree to acknowledge the contribution of the Site in any publication relating to the research.  Please refer to the PADMA User Manual for the proper method of acknowledgement and reference citation.
</ol>

<hr>
<h2>Intellectual Property and Ownership Notice</h2>
<p>
    We assert no claim of copyright in, or other ownership rights to,
    individual datasets incorporated into or used in connection with the Site,
    or any publications from which such datasets may have been obtained.
    Such rights remain with the respective authors or publishers of the datasets or,
    as the case may be, such datasets are in the public domain.
    Except as specifically set forth in the previous sentence, the PADMA database and
    all materials published on the Site, including, but not limited to, images, logos,
    all Site software, text, graphic material, or other copyrightable elements,
    the selection and arrangements thereof, and trademarks, service marks, trade names
    and any other intellectual property related to PADMA or CUNY ("Content") are
    the property of CUNY or licensed by CUNY and are protected, without limitation,
    pursuant to U.S. and foreign copyright and trademark laws. Except for Approved Uses,
    you are prohibited from reproducing, modifying,
    or otherwise using any Content without the express written consent of CUNY.
</p>
<hr>
<h2>Accuracy and Data Integrity</h2>
<p>
    While we attempt to ensure the integrity and accuracy of the Site,
    we do not guarantee correctness or accuracy of such contents.
    Inaccuracies may include, but are not limited to, typographical errors,
    inaccuracies in data presentation, additions or deletions,
    or Site alterations by an unauthorized third-party.
    In the event that you become aware of any inaccuracy, please contact us.
    Please be aware that the Site may change without notice.
</p>

<hr>


<h2>Disclaimer and Limitation of Liability</h2><hr>
<p>
    You hereby agree not to hold CUNY, its affiliates, and their respective officers,
    directors, employees, agents, and representatives liable for any services delivered
    which originated through the Site or was otherwise provided by someone affiliated
    with the Site and you hereby release all such persons from claims, demands and damages
    (actual or consequential) of every kind and nature, known and unknown,
    disclosed and undisclosed, arising out of or in any way connected with such disputes.
</p>

<p>
    THE MATERIALS IN THE SITE, INCLUDING BUT NOT LIMITED TO THE DATABASE, ARE PROVIDED "AS IS"
    AND WITHOUT WARRANTIES OF ANY KIND EITHER EXPRESS OR IMPLIED.
    TO THE FULLEST EXTENT PERMISSIBLE PURSUANT TO APPLICABLE LAW, CUNY DISCLAIMS ALL WARRANTIES,
    EXPRESS OR IMPLIED.  BY WAY OF EXAMPLE, BUT NOT LIMITATION,
    CUNY MAKES NO REPRESENTATIONS OR WARRANTIES (i) OF MERCHANTABILITY OR FITNESS FOR ANY PARTICULAR PURPOSE,
    (ii) THAT THE INFORMATION CONTAINED IN THE SITE IS ACCURATE, COMPLETE, CORRECTLY SEQUENCED,
    RELIABLE OR TIMELY, OR (iii) THAT THE SITE WILL BE UNINTERRUPTED OR FREE OF ERRORS AND/OR VIRUSES.
    YOU HEREBY SPECIFICALLY ACKNOWLEDGE THAT CUNY, ITS AFFILIATES, AND THEIR RESPECTIVE OFFICERS, DIRECTORS,
    EMPLOYEES, AGENTS, AND REPRESENTATIVES ARE NOT LIABLE FOR THE ILLEGAL CONDUCT OF OTHER USERS OF THE SITE
    OR THIRD-PARTIES AND THAT THE RISK OF INJURY FROM THE FOREGOING RESTS ENTIRELY WITH YOU.
    YOU USE THE SITE AT YOUR OWN RISK.</p>
<hr>
<p>
    UNDER NO CIRCUMSTANCES, INCLUDING BUT NOT LIMITED TO BREACH OF CONTRACT, TORT OR NEGLIGENCE,
    WILL CUNY, ITS AFFILIATES, OR THEIR RESPECTIVE OFFICERS, DIRECTORS, EMPLOYEES, AGENTS,
    AND REPRESENTATIVES BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL, PUNITIVE, OR CONSEQUENTIAL DAMAGES
    (INCLUDING LOST PROFITS) THAT ARISE OUT OF OR IN CONNECTION WITH ANY FAILURE OF PERFORMANCE,
    ERRORS, INACCURACIES, OMISSIONS, DEFECTS, UNTIMELINESS, INTERRUPTION, DELETION,
    DELAY IN OPERATION OR TRANSMISSION, COMPUTER VIRUS, COMMUNICATION LINE FAILURE,
    THEFT OR DESTRUCTION OR UNAUTHORIZED ACCESS TO, ALTERATION OF, OR USE OF RECORD,
    OR UNAUTHENTICITY OF ANY CONTENT IN THE SITE, OR THE USE OR INABILITY TO USE THIS SITE
    OR ANY CONTENT THEREIN. IN NO EVENT SHALL SUCH PARTIES' AGGREGATE LIABILITY TO YOU FOR ANY LOSS,
    DAMAGE OR CLAIM RELATED TO OR ARISING OUT OF THIS SITE EXCEED THE TOTAL AMOUNTS PAID BY YOU
    FOR ACCESSING THIS SITE, IF ANY.
</p>
<hr>
<h2>Indemnification</h2>
<hr>
<p>
    You agree to indemnify, defend and hold harmless, CUNY its affiliates,
    and their respective officers, directors, employees, agents,
    and representatives from and against all claims, losses, expenses,
    liabilities, damages, and costs (including attorneys' fees) arising out of
    or relating to from your (a) use of the Site, (b) violation of any
    third party right, or (c) breach of any of these Terms of Use.
    CUNY reserves the right to assume, at its own expense, the exclusive defense
    and control of any matter subject to indemnification by you, in which event
    you will fully cooperate with CUNY in asserting any available defenses.
    In any event, you agree not to settle any such matter without the prior written consent from CUNY.
</p>
<hr>
<h2>Jurisdiction</h2><hr>
<p>
    These Terms of Use and all matters or issues collateral
    thereto will be governed by, construed and enforced
    in accordance with the laws of the State of New York applicable to contracts executed and performed entirely therein (without regard to any principles of conflict of laws), and jurisdiction for any court action in the State and County of New York.
</p>

<hr>
<h2>Addressing Correspondence</h2>
<hr>
<p>
    Please send all notices and other correspondence
    required or permitted under these Terms of Use
    to the contact address found at the "Contact Use" link on the Site.
    You can also send you correspondence to:
<address>
    <strong> Department of Computer Science </strong><br>
    NAC 8/206<br>
    The City College of New York<br>
    138th Street and Convent Avenue<br>
    New York, NY 10038<br>
    United States of America<br>
    Attn: PADMA Database<br>
</address>
        <p>
OR
        </p>
<address>
    <strong> Department of Biology </strong><br>
    Marshak Hall J/526<br>
    The City College of New York<br>
    138th Street and Convent Avenue<br>
    New York, NY 10038<br>
    United States of America<br>
    Attn: PADMA Database<br>
</address>
EOT;
        $actionUrl = "../webpages/registration.php";
        $returnString  .= WidgetMaker::errorMessage(self::ERROR_MSG_ID, "You must agree to the Terms in order to become a PADMA User")
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

