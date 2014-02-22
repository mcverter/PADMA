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
session_start();
include("header.php");
?>

<table cellpadding="0" cellspacing="0" width="100%">
  <tr><td >&nbsp;</td><td >&nbsp;</td></tr>
  <tr><td >&nbsp;</td><td >&nbsp;</td></tr>
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
		    <br /><b>PADMA Supporting Status</b><hr />										
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
			  <div><b>Release History:</b> 
			    <ul><li>Release Candidate 1.0, November 1, 2010.</div></li></ul></div>
			  <p></p>
			  <div><b>Reported Problems:</b> 
			    <ul><li>None.</div></li></ul></div>
			  <p></p>			    
			  <div><b>Bug Fixes & Enhancement:</b> Fixes applied to reported bugs and potential improvements:
			    <ul> 
			      <li>Update inability of experiment description, November 9, 2010.</li>    
	                      <li>User profile update with storing inconsistent default title and middle name to database, November 6, 2010.</li>    
			      <li>User profile update option to allow users to modify their profile data, October 31, 2010.</li>
			      <li>Check on the maximum row count of experiment data download, October 28, 2010.</li>
			      <li>Collapsed format in Excel downloaded data, October 28, 2010.</li>
			      <li>Inability of sending out email message after resetting password by administrator, October 24, 2010.</li>
			    </ul></div>
			</td>
		      </tr>
		    </table>										
		  </td>
		</tr>
		<tr>
		  <td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
		    <br /><b>Planned Enhancement</b><hr />
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
			  <div><b>Comment at Data Upload</b> &#8212; an
			  option to allow users to write a comment at
			  upload data process.</div>
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
