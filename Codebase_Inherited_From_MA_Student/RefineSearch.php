<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" type="text/css" href="modalPopup.css" />
<script language="javascript" src="prototype.js"></script>
<script language="javascript" src="modalPopup.js"></script>
 </head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">

<?php
//include the header page
include("header.php");
include("utility.php");

session_start();

$maxExecutionTime=6000;
set_time_limit ( $maxExecutionTime );

$role=$_SESSION['role'];
if($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
{
	
}
else
{
 	echo "Access Denied";
	return;
}

//get session variabe
$db_UN=$_SESSION['un'];
$db_PASS=$_SESSION['pass'];
$db_DB=$_SESSION['db'];
$userid=strtoupper($_SESSION['userid']);
  
//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
if (! $db_conn)
{
	$e = oci_error(); 		
	echo "<font color='red'>";
	print htmlentities($e['message']);
	echo "<br>ERROR: Connecting to Database, Please try back later<br>";
	echo "</font>";
	echo "<a title='logout' href='index.php'>Click Here</a> to go back to home page";
	exit;
}

?>


<table cellpadding="0" cellspacing="0" width="95%" align="center">
        <tr>
                <td align="left">&nbsp;</td>
                <td align="right">&nbsp;</td>
        </tr>
        <tr>
                <td align="left"><font color="#4682B4"><h5><a href='switchboard_ret.php'>&lt;&lt;Back to Switchboard</a> | <a title='logout' href='index.php'>Log Out</a></h5></font></td>
                <td align="right">&nbsp;</td>
        </tr>
        

</table>

<div id="GENENAME_bg" class="modalPopupTransparent" style="display: none;"></div>
<div id="GENENAME" class="modalPopupWindow" style="display: none; width: 600px;"> 
<table width="100%"><tr><td align="right"><a href="javascript:closeModalWindow(1);">X  Close</a></td></tr></table>

 <?php
	$GN="GENENAME";
	printList($GN,$db_conn);
?>
<br>
</div>


<table width="100%">
	<tr>
        <td style="width:20%">&nbsp;</td>
        <td style="width:60%">
        <table width="100%" border="1" style="border-collapse:collapse; border-color:#4682b4; border-style:solid">
    		<tr>
            	<td>
                    <table width="100%" style="background-image:url('images/Tblheader.png');color:#ffffff" cellpadding="4"cellspacing="0">
						<tr>
                            <td ><b>Refine Search...</b></td></tr></table><br><br><br>
                				<table cellpadding="5" cellspacing="0" width="100%"border="0" style="font-family:Verdana; font-size:medium">
                    				<tr>
                        				<td style="width:10%">&nbsp;</td>
                        				<td style="width:80%" align="left" >
                        					<form  action="RefineSearchResult.php" method="post" name="index">
                        					<fieldset style="width:100%;padding:2">
												<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    								<tr>
														<td width="40%" align ="right">															
															Prob ID: 
														</td>
														<td width="60%" align="left">
															<input name="PROBEID" type="text" style="width: 90%" />
														</td>
													</tr>
													<tr>
														<td width="40%" align ="right">															
															CG Number: 
														</td>
														<td width="60%" align="left">
															<input name="CGNUMBER" type="text" style="width: 90%" />
														</td>
													</tr>
													
													<tr>
														<td width="40%" align ="right">															
															FlyBase Number: 
														</td>
														<td width="60%" align="left">
															<input name="FBCGNUMBER" type="text" style="width: 90%" />
														</td>
													</tr>
													<tr>
														<td width="40%" align ="right">															
															Gene Name: &nbsp;(<a href="javascript:openModalWindow(1);">list</a>)
														</td>
														<td width="60%" align="left">
															<input name="GENENAME" type="text" style="width: 90%" />
														</td>
													</tr>
													<tr>
														<td width="40%" align ="right">															
															GO Number: 
														</td>
														<td width="60%" align="left">
															<input name="GONUMBER" type="text" style="width: 90%" />
														</td>
													</tr>
												</table>
											</fieldset>
											<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    							<tr>
													<td width="100%" align="Right">
														<input name="btn_submit" type="submit" value="Submit"/>
													</td>
												</tr>
											</table>											
											</form>
										</td>
                        				<td style="width:10%">&nbsp;</td>
                    				</tr>
								</table><br>
                				<table width="100%" style="background-image:url('images/Tblfooter.png');color:#ffffff" cellpadding="0"  cellspacing="0">
									<tr>
                                        <td>&nbsp;</td>
									</tr>
								</table>
            				</td>
         				</tr>
         			</table>
        		</td>
        		<td style="width:20%">&nbsp;</td>
     		</tr>
     	</table><br><br><br><br><br><br><br><br><br><br><br><br>
     	<?php
			//close database connection
			oci_close($db_conn);
			//include the header page
			include("footer.php");
		?> 
	</body>
</html>

