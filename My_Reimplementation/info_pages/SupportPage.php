<?php
require_once("../templates/WebPage.php");

/**
 * Class SupportPage
 */
class SupportPage extends WebPage {

    const PG_TITLE = "Support";

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
        return $this->make_image_content_columns ($userid, $role, 'R', 4) ;
    }

    /**
     * @param $userid
     * @param $role
     * @return string
     */
    public function make_main_content($userid, $role) {
        $returnString = <<<EOT

    <div class="central_widget">
      <h2>PADMA Supporting Status</h2>
      <hr>

      <h3>Release History:</h3>
      <ul>
	<li>Release Candidate 1.0, November 1, 2010.</li>
      </ul>


      <h3>Reported Problems:</h3>
      <ul>
	<li>None.</li>
      </ul>

      <h3>Bug Fixes & Enhancement:</h3>
      <h4>Fixes applied to reported bugs and potential improvements: </h4>
      <ul>
	<li>Update inability of experiment description, November 9, 2010.</li>
	<li>User profile update with storing inconsistent default title and middle name to database, November 6, 2010.</li>
	<li>User profile update option to allow users to modify their profile data, October 31, 2010.</li>
	<li>Check on the maximum row count of experiment data download, October 28, 2010.</li>
	<li>Collapsed format in Excel downloaded data, October 28, 2010.</li>
	<li>Inability of sending out email message after resetting password by administrator, October 24, 2010.</li>
      </ul>
      <h3>Planned Enhancement</h3>
      <hr>
      <ul>
	<li>Comment at Data Upload &#8212; an
	  option to allow users to write a comment at
	  upload data process.</li>
      </ul>
    </div>
EOT;
        return $returnString;
    }
}
