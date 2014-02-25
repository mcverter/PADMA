<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!onMouseover Link CSS Script-©--><style><!--a:hover{color:gray; }--></style>
<style>
<!--
a{text-decoration:none}
//-->
</style>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana" link="#4682B4" vlink="#4682B4" alink="#4682B4">
<?php
//include the header page
if (session_id() == "") session_start();
include("header.php");
?>

<table cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
</table>
<form action="switchboard.php" method="post" name="index">        
  <table cellpadding="0" cellspacing="0" width="85%" align="center" bgcolor="#FFFAFA">
    <tr>
      <td>
	<table cellpadding="0" cellspacing="0" width="100%" align="center" style="border-width:1px;border-collapse:collapse; border-style:solid; border-color:#4682B4">
	  <tr>                                    
	    <td>&nbsp;<br />&nbsp;<br />                       
	      <table  cellpadding="0" align="center" cellspacing="0" width="80%">
		<tr>
		  <td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
		    <br /><b>About Us</b><hr />										
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
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
			</td>
		      </tr>
		    </table>										
		  </td>
		</tr>
		<tr>
		  <td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
		    <br /><b>PADMA Project Members, alphabetically</b><hr />
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
			  <div><b>Dr. Shubha Govind</b>
			    &#8212; Dr. Govind is a
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
			    on <a href="http://www1.ccny.cuny.edu/prospective/science/biology/profiles/profile_govind.cfm">http://www1.ccny.cuny.edu/prospective/science/biology/profiles/profile_govind.cfm</a>.</div>
			  <p></p>
			  <div><b>Prof. Akira
			    Kawaguchi</b> &#8212;
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
			    at <a href="http://www-cs.ccny.cuny.edu/~akira/">http://www-cs.ccny.cuny.edu/~akira</a>.</div>
			  <p></p>
			  <div><b>Mark J. Lee</b> &#8212; Mark
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
			  translational science.</div>
			  <p></p>
			  <div><b>Ariful Mondal</b> &#8212; Ariful
			    graduated with a Master's in Computer
			    Science at The City College of New
			    York. He contributed to the pre-release
			    development of PADMA database system.  His
			    thesis was based on this development work.
			    He is interested in web-interface,
			    database design, and information
			    systems.</div>
			</td>
		      </tr>
		    </table>										
		  </td>
		</tr>
		<tr>
		  <td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
		    <br /><b>Special Thanks to</b><hr />										
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
			  Elenny Duverges, for
			  PADMA's logo design;
			  Nelson Montesdeoca,
			  M.S., for support with
			  programming and design
			  architecture; Maria
			  Otazo, for
			  researching,
			  scrubbing, and
			  formatting data;
			  Noelisa Montero, for
			  researching,
			  scrubbing, and
			  formatting data;
			  Indira Paddibhatla and
			  Chiyedza Small, for
			  contributing to the
			  publication; Dr. Cathy
			  Faulk, for discussing
			  and providing valuable
			  feedback.
			</td>
		      </tr>
		    </table>										
		  </td>
		</tr>
		<tr>
		  <td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
		    <br /><b>Acknowledgement</b><hr />										
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
			  Dr. Bredje Wertheim, Dr. Todd Schlenke, and Govind Lab Members.
			</td>
		      </tr>
		    </table>										
		  </td>
		</tr>								
		<tr>
		  <td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
		    <br /><b>Support</b><hr />										
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
			  NIH, USDA, HHMI, and PSC-CUNY.
			</td>
		      </tr>
		    </table>										
		  </td>
		</tr>								
		<tr><td>&nbsp;</td></tr>		
		<tr><td>&nbsp;</td></tr>		
	      </table>
	    </td>									
	  </tr>
	</table>
      </td>
    </tr>
  </table>    
</form>

<?php
   //include the header page
   include("footer.php");
   ?> 
</body>
</html>
