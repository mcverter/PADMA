<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
//include the header page
include("header.php");
//start session
session_start();

$maxExecutionTime=6000;
set_time_limit ( $maxExecutionTime );


$role=$_SESSION['role'];
//REDIRECT THE USER TO LOGIN PAGE IF USER IS NOT ADMINISTRATOR OR RESEARCHER
if($role == "Administrator"){}
else
{
 	header("location: index.php"); 
}
?>

<head>
<script language="javascript" type="text/javascript">
<!-- hide script from older browsers

function validate(index)
{
		 //Check if the version field is empty
        if(""==document.forms.index.version.value)
        {
                alert("Please enter a Valid Version Number.");
                return false;
        }   

		//Check if the file name field is empty
        if(""==document.forms.index.uploadedfile.value)
        {
                alert("Please enter a Valid File Name.");
                return false;
        }   
		
		  

}
 stop hiding script -->
</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">
<?php
	if ($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
		{
			echo "<table width='90%' align='center' cellpadding='0'  cellspacing='0' style='font-family:Verdana; font-size:small; font-weight:bold'>";
			echo	"<tr>";
            echo		"<td align='right' valign='center'>";
			echo			"<a title='back' href='DataManagement.php'>Back to Data Management</a> <br />";
			echo		"</td>";
			echo	"</tr>";
			echo "</table>";    
		}
	else
		{
			echo "&nbsp;<br>";											
		}
?>  
	<br><br><br>
	<form   action="uploader.php" method="POST" name="index" enctype="multipart/form-data" onsubmit="return validate(index);">
	<table width="100%">
		<tr>
			<td style="width:20%">&nbsp;</td>
			<td style="width:60%">
				<table width="100%" border="1" style="border-collapse:collapse; border-color:#4682b4; border-style:solid">
					<tr>
						<td>
							<table width="100%" style="background-image:url('images/Tblheader.png');color:#ffffff" cellpadding="4"  cellspacing="0">
								<tr>
									<td ><b><font color="#ffffff">Reference Data Loading...</font></b></td>								
								</tr>
							</table>
							
							<br><br><br>
							<table cellpadding="5" cellspacing="0" width="100%">
								<tr>
									<td style="width:20%" align="right" >&nbsp;</td>
									<td style="width:80%" align="left" valign="bottom">
										<table cellpadding="5" cellspacing="0" width="100%" align="center">
											<tr>
												<td style="width:40%" align="left">Version Number:</td>
												<td style="width:60%" align="left"><input name="version" type="text" /></td>
											</tr>
											<tr>
												<td style="width:40%" align="left">File Name:</td>
												<td style="width:60%" align="left">
													<input name="uploadedfile" type="file" />													
												</td>
											</tr>
											<tr>
												<td style="width:40%" align="left">&nbsp;</td>
												<td style="width:60%" align="left">
													<input name="Button1" type="submit" value="Verify Data" />
												</td>
											</tr>
										</table>										
									</TD>										
									<td style="width:20%" align="right">&nbsp;</td>
									<td> <p><div id="txtHint"><b></b></div></p> </td>
								</tr>
							</table>
							<br><br><br>
						</td>
					</tr>
				</table>
			<td style="width:20%">&nbsp;</td>
		</tr>
	</table>
</form>
</body>
</html>

