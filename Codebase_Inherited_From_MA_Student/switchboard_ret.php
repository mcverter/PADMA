<?php
		//include the header page
		include("header.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">

<?php
//include the header page
if (session_id() == "") session_start();

$role=$_SESSION['role'];
//REDIRECT THE USER TO LOGIN PAGE IF USER IS NOT AUTHENTICATED
if($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser") {}
else
{
 	header("location: index.php"); 
}
?>

<table cellpadding="0" cellspacing="0" width="95%" align="center">
        <tr>
                <td >&nbsp;</td>
                <td align="right">&nbsp;</td>
        </tr>
        <tr>
                <td >&nbsp;</td>
                <td align="right"></td>
        </tr>
        

</table>

<table width="100%">
	<tr>
        <td style="width:20%">&nbsp;</td>
        <td style="width:60%">
        <table width="100%" border="1" style="border-collapse:collapse; border-color:#4682b4; border-style:solid">
    		<tr>
            	<td>
                    <table width="100%" style="background-image:url('images/Tblheader.png');color:#ffffff" cellpadding="4"cellspacing="0">
						<tr>
                            <td ><b>Select One...</b></td></tr></table>
                				<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    				<tr>
                        				<td style="width:10%">
                        				<td style="width:80%" align="left" >  
                        				<?php
                        				if ($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
                        				{
											echo "<table width='100%' cellpadding='0'  cellspacing='0' style='font-family:Verdana; font-size:small; font-weight:bold'>";
											echo	"<tr>";
                                        	echo		"<td align='right' valign='center'>";
											echo			"<img src='images/j0432593SMALL.png' alt='logout'>";
											echo			"<a title='logout' href='index.php'>Log Out</a> |<a title='Change Password' href='PassChange.php'>Change Password</a><br />&nbsp;<br />";
											echo		"</td>";
											echo	"</tr>";
											echo "</table>";    
										}
										else
										{
											echo "&nbsp;<br>";											
										}
											?>
											<table cellpadding="0" cellspacing="0" width="100%" bgcolor="#F0FFF0">
                    						<tr><td>                 					
                        					<fieldset>&nbsp;<br />
                        					<?php
                        						if ($role=="NOTAUTHORIZED")
                        						{
													echo "<table cellpadding='5' cellspacing='0' width='100%' border='0'>";
                    								echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"Authentication failed <br><font color='#4682B4'><h5><a href='index.php'>Back to Homepage</a></h5></font>";	
													echo		"</td>";																										
													echo	"</tr>";
													echo "</table>";
														
												}
                        						if ($role=="GeneralUser")
                        						{
													echo "<table cellpadding='5' cellspacing='0' width='100%' border='0'>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='newprofile.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Your Profile Update' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='QuickSearch.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Quick Gene Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='AdvancedQuery.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Advanced Query' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";			
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='RefineSearch.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Refine Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='ListofExperiment.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='List of Experiment' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo "</table>";
														
												}
												
												if ($role=="Researcher")
                        						{
													echo "<table cellpadding='5' cellspacing='0' width='100%' border='0'>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='newprofile.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Your Profile Update' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='DataManagement.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Data Management' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
                    								echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='QuickSearch.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Quick Gene Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='AdvancedQuery.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Advanced Query' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='RefineSearch.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Refine Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='ListofExperiment.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='List of Experiment' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo "</table>";										
																											
												}
												
												if ($role=="Administrator")
                        						{
													echo "<table cellpadding='5' cellspacing='0' width='100%' border='0'>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='newprofile.php' method='post' name='usermanagement'>";													
													echo			"<input id='btnLogin' type='submit' value='Your Profile Update' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='usermanagement.php' method='post' name='usermanagement'>";													
													echo			"<input id='btnLogin' type='submit' value='User Setup' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='DataManagement.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Data Management' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
                    								echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='QuickSearch.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Quick Gene Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='AdvancedQuery.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Advanced Query' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='RefineSearch.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='Refine Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='ListofExperiment.php' method='post' name='index'>";													
													echo			"<input id='btnLogin' type='submit' value='List of Experiment' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";		
													echo		"</td>";																										
													echo	"</tr>";
													echo "</table>";										
																											
												}
												
											?>
         <br/>										</fieldset>
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
     	</table>
     	<?php     
		//unset session variable
		unset($_SESSION['totalSearchResult']);
		unset($_SESSION['searchResult']);
		unset($_SESSION['SearchCreiteria']);
		unset($_SESSION['SearchString']);
		unset($_SESSION['cmdStrRefinedAll']);
		unset($_SESSION['cmdStrCustom']);
		unset($_SESSION['cmdStrQuick']);	
		unset($_SESSION['cmdStrRefined']);	
		unset($_SESSION['S_UniqueBioFunction']);
        unset($_SESSION['S_UniqueExperimentSubject']);
        unset($_SESSION['S_UniqueActiveSpecies']);
        unset($_SESSION['S_UniqueActiveCategory']);
        unset($_SESSION['S_UniqueRegulationValue']);
        unset($_SESSION['EXP_NAME']);
     	unset($_SESSION['CATG']);
     	unset($_SESSION['SPEC']);
     	unset($_SESSION['SUBJ']);
     	unset($_SESSION['cmdStrCustom']);
     	unset($_SESSION['EXP_NAME_Q']);
     	unset($_SESSION['CATG_Q']);
     	unset($_SESSION['SPEC_Q']);
     	unset($_SESSION['SUBJ_Q']);
     	unset($_SESSION['REG_VAL_Q']);
     	unset($_SESSION['EXP_NAME_S']);
     	unset($_SESSION['CATG_S']);
     	unset($_SESSION['SPEC_S']);
     	unset($_SESSION['SUBJ_S']);
			//include the header page
			include("footer.php");
			?> 
	</body>
</html>

