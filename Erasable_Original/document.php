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
		    <br /><b>User Basics</b><hr />										
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
			  <div><b>User Manual</b> &#8212; detailed and
			  comprehensive information on navigating and
			  utilizing the PADMA Database
			  [<a href="documents/USER_MANUAL_v1.0.pdf">DOWNLOAD</a>].</div>
			  <p></p><div><b>Terms of Use</b> &#8212; terms and conditions for using the PADMA Database and website [<a href="documents/Terms of Use v1.0.pdf">DOWNLOAD</a>].</div>
			  <p></p><div><b>Upload Template</b> &#8212;
			  use the attached spreadsheet with
			  pre-populated list of
			  Affymetrix<sup>&reg;</sup> probe set ID
			  (PID). There are 2 versions of the
			  Drosophila genome: Genome v1 and Genome
			  v2. Download and use the pertinent template.
			    <ul><li>Version 1 [<a href="documents/Upload Template v1.0.xls">DOWNLOAD</a>]</li>
			      <li>Version 2 [<a href="documents/Upload Template v2.0.xls">DOWNLOAD</a>]</li></ul></div>
			</td>
		      </tr>
		    </table>										
		  </td>
		</tr>
		<tr>
		  <td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
		    <br /><b>Data Related Documents</b><hr />
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
			  <div><b>Affy Genome 2</b> &#8212; Due to
			    multiple gene targets binding to a single
			    specific probe (oligonucleotide sequence),
			    a probe set ID may represent several
			    genes. Thus, expression of a probe set ID
			    may be over/under stated, and non-specifc
			    to a gene target. Refer to this
			    spreadsheet from
			    Affymetrix<sup>&reg;</sup> listing all the
			    individual probe set ID in the
			    Affymetrix<sup>&reg;</sup> Genome 2
			    associated with multiple possible gene
			    targets [<a href="documents/Affy V1 Full
			    PID for PADMA.csv">DOWNLOAD</a>].</div>
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
