<?php
require_once(__DIR__ . "/../templates/WebPage.php");

class AboutUsPage extends WebPage {

    function get_title() {
        return "About Us";
    }

    function make_page_middle($title, $userid, $role){
    return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
      }

    function __construct() {
        parent::__construct();
    }

    public function make_main_frame($title, $userid, $role) {
        $returnString = <<<EOT

    <div class="centered_exposition">
      <h2>About Us</h2>
      <p>
	We are a group of academic researchers and
	computer scientists looking to bridge the
	gap between the voluminous microarray data
	in the public domain and difficulties in
	accessing these datasets.  Specifically, we
	want provide a venue for immunity/parasitoid
	researchers in the fly community to mine
	valuable information from already published
	microarray data.  In addition, we want to
	provide a platform where researchers can
	process their own microarray data results
	into user-friendly formats without the need
	to buy special software or outsource the
	analysis portion to costly companies.
      </p>
      <hr>
      <hr>
      <div class="sublist">
	<h3>PADMA Project Members, alphabetically</h3>
	<hr />
	<dl>
	  <dt>Dr. Shubha Govind</dt>
	  <dd> Dr. Govind is a
	    Professor of Biology at The City
	    College of New York and has
	    published numerous publications
	    on Drosophila immunity,
	    hematopoeisis, and parasitology,
	    among others.  In addition,
	    Dr. Govind oversees several
	    grants as the Principal
	    Investigator, and is mentors
	    several graduate and
	    undergraduate students.  You can
	    find out more about Dr. Govind's
	    research interest
	    on <a href="http://www1.ccny.cuny.edu/prospective/science/biology/profiles/profile_govind.cfm">http://www1.ccny.cuny.edu/prospective/science/biology/profiles/profile_govind.cfm</a>.
	  </dd>
	  <dt>Prof. Akira
	    Kawaguchi</dt>
	  <dd>
	    Prof. Kawaguchi is an Associate
	    Professor in Computer Science at
	    The City College of New York. In
	    addition to numerous
	    publications in information
	    systems, databases, and
	    simulation models,
	    Prof. Kawaguchi is the Director
	    of the Masters in Information
	    Systems at CCNY.  You can find
	    our more about Prof. Kawaguchi
	    at <a href="http://www-cs.ccny.cuny.edu/~akira/">http://www-cs.ccny.cuny.edu/~akira</a>.
	  </dd>
	  <dt>
	    Mark J. Lee</dt>
	  <dd>Mark
	    graduated with a Master's in Biology at The
	    City College of New York. He is a co-author
	    in several publications and has studied
	    host/pathogen interactions, immunity, signal
	    networks, biostatistics, and
	    genomics/proteomics. He is interested in
	    further studying immunity, pharmacology, and
	    bioinformatics. He is also interested in
	    bridging the gap between academic science,
	    industry, and government, by focusing on
	    translational science.</dd>
	  <dt>Ariful Mondal</dt>
	  <dd>Ariful
	    graduated with a Master's in Computer
	    Science at The City College of New
	    York. He contributed to the pre-release
	    development of PADMA database system.  His
	    thesis was based on this development work.
	    He is interested in web-interface,
	    database design, and information
	    systems.
	  </dd>
	</dl>
      </div>
      <hr><hr>
      <div class="sublist">
	<h2>Special Thanks to</h2>
	<hr>
	<ul>
	  <li>   Elenny Duverges, for  PADMA's logo design;</li>
	  <li> Nelson Montesdeoca, M.S., for support with programming and design
	    architecture; </li>
	  <li> Maria Otazo, for researching, scrubbing, and formatting data; </li>
	  <li> Noelisa Montero, for
	    researching,
	    scrubbing, and
	    formatting data;</li>
	  <li> Indira Paddibhatla and
	    Chiyedza Small, for
	    contributing to the
	    publication;</li>
	  <li> Dr. Cathy
	    Faulk, for discussing
	    and providing valuable
	    feedback.</li>
	</ul>
      </div>
      <hr><hr>
      <div class="sublist">
	<h2> Acknowledgement</h2>
	Dr. Bredje Wertheim, Dr. Todd Schlenke, and Govind Lab Members.

      </div>
      <hr><hr>
      <div class="sublist">
	<h2> Support</h2>
	<hr />
	NIH, USDA, HHMI, and PSC-CUNY.
      </div>
    </div>
EOT;
        return $returnString;
    }
}















