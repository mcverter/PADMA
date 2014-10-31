<?php
require_once("../templates/WebPage.php");

/**
 * Class DocumentPage
 */
class DocumentPage extends WebPage {
    const PG_TITLE =  "Documentation";

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
     * @param $userid
     * @param $role
     * @return string
     */
    public function make_main_content($userid, $role) {
        $returnString = <<<EOT

    <div class="centered_exposition">
      <h2>User Basics</h2>
      <hr />
      <dl>
	<dt>User Manual</dt>
	<dd>Detailed and comprehensive information on navigating and utilizing the PADMA Database</dd>
	<dd><a href="../webpages/documentation/USER_MANUAL_v1.0.pdf">Download User Manual</a>.</dd>
      </dl>
      <dl>
	<dt> Terms of Use</dt>
	<dd> Terms and conditions for using the PADMA Database and website </dd>
	<dd><a href="../webpages/documentation/Terms of Use v1.0.pdf">Download Terms of Use</a></dd>
      </dl>
      <dl>
	<dt>Upload Template</dt>
	<dd>Use the attached spreadsheet with pre-populated list of Affymetrix<sup>&reg;</sup> probe set ID(PID). </dd>
	<dd> There are 2 versions of the Drosophila genome: Genome v1 and Genome v2. Download and use the appropriate template.
	  <ul>
	    <li><a href="../webpages/documentation/Upload Template v1.0.xls">Download Version 1</a></li>
	    <li><a href="../webpages/documentation/Upload Template v2.0.xls">Download Version 2 </a></li>
	  </ul>
	</dd>
      </dl>
      <h2>Data Related Documents</h2>
      <hr />
      <dl>
	<dt> Affy Genome 2</dt>
	<dd> Due to multiple gene targets binding to a single specific probe (oligonucleotide sequence), a probe set ID may represent several genes. Thus, expression of a probe set ID	may be over/under stated, and non-specifc to a gene target. Refer to this spreadsheet from Affymetrix<sup>&reg;</sup> listing all the individual probe set ID in the Affymetrix<sup>&reg;</sup> Genome 2 associated with multiple possible gene targets</dd>
	<dd><a href="../webpages/documentation/Affy V1 Full PID for PADMA.csv">Download Affymetrix<sup>&reg;</sup> spreadsheet </a> </dd>
      </dl>
    </div>
EOT;
        return $returnString;
    }
}

