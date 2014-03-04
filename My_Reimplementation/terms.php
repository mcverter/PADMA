<?php

require_once("WebPage.php");

class termsOfUse extends WebPage {
    function __construct() {
        parent::__construct();
    }

    function print_content()  {
        echo <<< EOL
  <form class="central_widget" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <h2> PLEASE READ THESE TERMS OF USE CAREFULLY BEFORE USING <a href="http://padmadatabase.org">http://padmadatabase.org</a>, INCLUDING THE PATHOGEN ASSOCIATED DROSOPHILA MICROARRAY (PADMA) DATABASE (the "Site").</h2>
    <input type="radio" NAME="terms" VALUE="agree">Agree</input>
    <input type="radio" NAME="terms" VALUE="disagree" checked>Disagree</input>
    <input type="submit" value="submit">
  </form>
  <?php
  if (isset($_POST['terms'])) {
    if ($_POST['terms'] == "agree") header("Location: newuser.php");
    else header("Location: index.php");
    exit;
  }
  ?>

  <div class="central_widget">
  <h3>Terms of Use</h3>
  <p> Your use of the Site is subject to the following Terms of Use which include by reference the <a href="http://portal.cuny.edu/cms/id/cuny/documents/level_3_page/001171.htm">Computer Use Policy</a> and <a href="http://www.cuny.edu/website/privacy.html">Web Site Privacy Policy</a> of The City University of New York ("CUNY").</p>
  <p> If you do not agree with these Terms of Use, please do not use the Site.  Your use of the Site indicates your acceptance of these Terms of Use.  If we make any material changes to these Terms of Use, those changes will be posted here so that you are always aware of our Terms of Use.  Since these Terms of Use may change from time to time, you should check back periodically.  Your continued use of the Site following the posting of changes to the Terms of Use indicates your acceptance of such changes.</p>
  <h3>Registration</h3>
  <hr>
  <p>
    You must register in order to use the Site.  During the registration process, you will be asked to provide information about yourself.  We assume that the information you provide on your registration is accurate and complete, and it is your responsibility to promptly notify us of any changes.  When registering, you must select a USER ID and PASSWORD.  You are solely responsible for keeping your PASSWORD confidential.  You must notify us immediately of any known or suspected unauthorized use of your PASSWORD.</p>

  <h3>Approved Use</h3>
  <p> Subject to its acceptance of your registration and its written notice to you of such acceptance, CUNY hereby grants you a nonexclusive, nontransferable license to access and use the Site for personal, noncommercial, educational/research purposes in accordance with these Terms of Use.  Use of the Site for commercial purposes, including without limitation use in furtherance of research and development activities performed for a commercial entity, or use for unlawful, illegal, or otherwise unethical activity in any jurisdiction, is strictly prohibited.  You may not reverse engineer, deconstruct, or disassemble any components of the Site.  You may not copy any portion of the PADMA database for resale or publication of any kind in any media.</p>

  <ol>
    <li>Export of Query Results:  You may export search/query results obtained during the course of Approved Use of the Site by following the steps outlined in the PADMA User Manual.  Any other export or extraction of any component, data, or information of or from the Site is strictly prohibited.</li>

    <li>Data Upload:  You may upload microarray data onto the Site solely for purposes of an Approved Use, by following the steps outlined in the PADMA User Manual.  Any data you upload to the Site will be incorporated into the PADMA database, and will remain in the database until you delete the file.  Subject to these Terms of Use, you will have sole access to the data you upload.</li>

    <li>USE OF THE DATA UPLOAD FUNCTION IS AT YOUR OWN RISK.  While we will take reasonable precautions to ensure that the Site is secure, we cannot guarantee, or otherwise prevent, exposure, access, or hijack of your data by an unauthorized third-party during the loading process or while your uploaded data reside in the PADMA database.  Any loss, exposure, or damage of data is strictly at your own risk.</li>

    <li>Acknowledgement: If you use the Site in your research, you agree to acknowledge the contribution of the Site in any publication relating to the research.  Please refer to the PADMA User Manual for the proper method of acknowledgement and reference citation.</li>
  </ol>

  <h3>Intellectual Property and Ownership Notice</h3>
  <hr>
  <p> We assert no claim of copyright in, or other ownership rights to, individual datasets incorporated into or used in connection with the Site, or any publications from which such datasets may have been obtained.  Such rights remain with the respective authors or publishers of the datasets or, as the case may be, such datasets are in the public domain.  Except as specifically set forth in the previous sentence, the PADMA database and all materials published on the Site, including, but not limited to, images, logos, all Site software, text, graphic material, or other copyrightable elements, the selection and arrangements thereof, and trademarks, service marks, trade names and any other intellectual property related to PADMA or CUNY ("Content") are the property of CUNY or licensed by CUNY and are protected, without limitation, pursuant to U.S. and foreign copyright and trademark laws. Except for Approved Uses, you are prohibited from reproducing, modifying, or otherwise using any Content without the express written consent of CUNY.</p>
  <h3>Accuracy and Data Integrity</h3>
  <p>While we attempt to ensure the integrity and accuracy of the Site, we do not guarantee correctness or accuracy of such contents.  Inaccuracies may include, but are not limited to, typographical errors, inaccuracies in data presentation, additions or deletions, or Site alterations by an unauthorized third-party.  In the event that you become aware of any inaccuracy, please contact us.  Please be aware that the Site may change without notice.</p>
  <h3>Disclaimer and Limitation of Liability</h3>
  <hr>
  <p>You hereby agree not to hold CUNY, its affiliates, and their respective officers, directors, employees, agents, and representatives liable for any services delivered which originated through the Site or was otherwise provided by someone affiliated with the Site and you hereby release all such persons from claims, demands and damages (actual or consequential) of every kind and nature, known and unknown, disclosed and undisclosed, arising out of or in any way connected with such disputes.</p>
  <p>THE MATERIALS IN THE SITE, INCLUDING BUT NOT LIMITED TO THE DATABASE, ARE PROVIDED "AS IS" AND WITHOUT WARRANTIES OF ANY KIND EITHER EXPRESS OR IMPLIED.  TO THE FULLEST EXTENT PERMISSIBLE PURSUANT TO APPLICABLE LAW, CUNY DISCLAIMS ALL WARRANTIES, EXPRESS OR IMPLIED.  BY WAY OF EXAMPLE, BUT NOT LIMITATION, CUNY MAKES NO REPRESENTATIONS OR WARRANTIES (i) OF MERCHANTABILITY OR FITNESS FOR ANY PARTICULAR PURPOSE, (ii) THAT THE INFORMATION CONTAINED IN THE SITE IS ACCURATE, COMPLETE, CORRECTLY SEQUENCED, RELIABLE OR TIMELY, OR (iii) THAT THE SITE WILL BE UNINTERRUPTED OR FREE OF ERRORS AND/OR VIRUSES. YOU HEREBY SPECIFICALLY ACKNOWLEDGE THAT CUNY, ITS AFFILIATES, AND THEIR RESPECTIVE OFFICERS, DIRECTORS, EMPLOYEES, AGENTS, AND REPRESENTATIVES ARE NOT LIABLE FOR THE ILLEGAL CONDUCT OF OTHER USERS OF THE SITE OR THIRD-PARTIES AND THAT THE RISK OF INJURY FROM THE FOREGOING RESTS ENTIRELY WITH YOU. YOU USE THE SITE AT YOUR OWN RISK.</p>

  <p> UNDER NO CIRCUMSTANCES, INCLUDING BUT NOT LIMITED TO BREACH OF CONTRACT, TORT OR NEGLIGENCE, WILL CUNY, ITS AFFILIATES, OR THEIR RESPECTIVE OFFICERS, DIRECTORS, EMPLOYEES, AGENTS, AND REPRESENTATIVES BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL, PUNITIVE, OR CONSEQUENTIAL DAMAGES (INCLUDING LOST PROFITS) THAT ARISE OUT OF OR IN CONNECTION WITH ANY FAILURE OF PERFORMANCE, ERRORS, INACCURACIES, OMISSIONS, DEFECTS, UNTIMELINESS, INTERRUPTION, DELETION, DELAY IN OPERATION OR TRANSMISSION, COMPUTER VIRUS, COMMUNICATION LINE FAILURE, THEFT OR DESTRUCTION OR UNAUTHORIZED ACCESS TO, ALTERATION OF, OR USE OF RECORD, OR UNAUTHENTICITY OF ANY CONTENT IN THE SITE, OR THE USE OR INABILITY TO USE THIS SITE OR ANY CONTENT THEREIN. IN NO EVENT SHALL SUCH PARTIES' AGGREGATE LIABILITY TO YOU FOR ANY LOSS, DAMAGE OR CLAIM RELATED TO OR ARISING OUT OF THIS SITE EXCEED THE TOTAL AMOUNTS PAID BY YOU FOR ACCESSING THIS SITE, IF ANY.</p>
  <h3>Indemnification</h3>
  <p>You agree to indemnify, defend and hold harmless, CUNY its affiliates, and their respective officers, directors, employees, agents, and representatives from and against all claims, losses, expenses, liabilities, damages, and costs (including attorneys' fees) arising out of or relating to from your (a) use of the Site, (b) violation of any third party right, or (c) breach of any of these Terms of Use.  CUNY reserves the right to assume, at its own expense, the exclusive defense and control of any matter subject to indemnification by you, in which event you will fully cooperate with CUNY in asserting any available defenses.  In any event, you agree not to settle any such matter without the prior written consent from CUNY.</p>
  <h3>Jurisdiction</h3><hr>
    <hr>
    <p>These Terms of Use and all matters or issues collateral thereto will be governed by, construed and enforced in accordance with the laws of the State of New York applicable to contracts executed and performed entirely therein (without regard to any principles of conflict of laws), and jurisdiction for any court action in the State and County of New York.</p>
    <h3>Addressing Correspondence</h3>
    <p>Please send all notices and other correspondence required or permitted under these Terms of Use to the contact address found at the "Contact Use" link on the Site.  You can also send you correspondence to:</p>
    <div class="street_address">
      Department of Computer Science
      NAC 8/206
      The City College of New York
      138th Street and Convent Avenue
      New York, NY 10038
      United States of America
      Attn: PADMA Database
    </div>
    <p>
      OR
    </p>
    <div class="street_address">
      Department of Biology
      Marshak Hall J/526
      The City College of New York
      138th Street and Convent Avenue
      New York, NY 10038
      United States of America
      Attn: PADMA Database
    </div>											
  <?php
  //include the header page
  include("footer.php");
  ?>
  </div>
EOL;
    }
}
$toe = new termsOfUse();
$toe->display_page();

?>






