<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!onMouseover Link CSS Script-©--><style><!--a:hover{color:gray;}--></style>
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
  <tr>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
</table>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">        
  <table cellpadding="0" cellspacing="0" width="85%" align="center" bgcolor="#FFFAFA">
    <tr>
      <td>
	<table cellpadding="0" cellspacing="0" width="100%" align="center" style="border-width:1px;border-collapse:collapse; border-style:solid; border-color:#4682B4">
	  <tr>                                    
	    <td>&nbsp;<br />&nbsp;<br />                       
	      <table  cellpadding="0" align="center" cellspacing="0" width="80%">
		<tr><td>PLEASE READ THE FOLLOWING TERMS OF USE BEFORE
		    UPLAODING TO THE PATHOGEN ASSOCIATED DROSOPHILA
		    MICROARRAY (PADMA) DATABASE.</td></tr>
		<tr><td valign="top" style="font-family:Verdana; font-size:Medium" align="center">
		    <p>
		      <table>
			<tr>
			  <td><INPUT TYPE=RADIO NAME="terms" VALUE="agree" CHECKED />Agree</td>
			  <td><INPUT TYPE=RADIO NAME="terms" VALUE="disagree"      />Disagree</td>
			  <td><INPUT TYPE=SUBMIT VALUE="submit"></td></tr></table>
		      </p>
		      <?php
			 if (isset($_POST['terms'])) {
			 if ($_POST['terms'] == "agree") header("Location: expLoaderStart.php");
			 else header("Location: DataManagement.php");
			 exit;
			 }
		       ?>
		  </td></tr>
		<tr>
		  <td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
		    <br /><b>Data Submission to PADMA Database</b><hr />										
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
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
			</td>
		      </tr>
		    </table>
		  </td>
		</tr>
		<tr>
		  <td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
		    <br /><b>Instruction</b><hr />										
		    <table width="100%">
		      <tr>
			<td valign="top" style="font-family:Verdana; font-size:small" align="left">
			  If you have an administrative account, you may select either "local" or "global" option when you upload your Dataset. The local
			  option will limit the access of the uploaded Dataset only to your account, whereas the global
			  option will allow the access for anyone registered to and active in the PADMA system. 
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
	
