<?php
require_once("WebPage.php");

$index_page= new WebPage();
$index_page->title = "Index";
$index_page->content =<<<EOT
    <div class="central_widget">
      <p>
	<img id="dropso" src="images/SDNA_tsmall.png" alt="drosophila">
	Welcome to PADMA Database!  We are a group of academic scientific researchers and computer scientists who want to bridge the gap in the abundance of microarray data from publications around the world and easy accessibility to those datasets to the fly immunity research community. We designed PADMA (Pathogen Associated Drosophila MicroArray) Database, for easy retrieval of genes whose expression is altered by infections (microbial or parasitoid). The database also houses gene expression datasets in larval blood cells after activation of immune pathways.   </p>
	<p>
          The PADMA database will allow a user to compare genes whose expression is altered after infection by a single or multiple pathogens. Query results are hyperlinked to FlyBase for further information of the gene as well as to facilitate navigation to other databases linked to FlyBase. The user is further able to drill and analyze pertinent data by refining and exporting the query results to a data analysis application.  In addition, users can upload their own experimental microarray data in confidence and compare result of their experiment against datasets available in PADMA.As more pathogen-related microarray experiments become available and are uploaded to the database, the scale and magnitude of PADMA will grow.  If you know of any published immunity-related microarray data not found in PADMA, please contact us so we can incorporate it into our data warehouse.
	</p>
    </div>

EOT;

$index_page->display_page();

?>





