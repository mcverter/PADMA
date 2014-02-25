<?php
		//include the header page
		include("header.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">
	<?php		
		session_start();

		//create connection string variable
		$db_UN = "drosophilarc2";         //username
		$db_PASS= "drosopivot";           //password
		$db_DB= "//127.0.0.1/ORATIKI";    //database name

		//save connection string variable to session
		$_SESSION['un']=$db_UN;
		$_SESSION['pass']=$db_PASS;
		$_SESSION['db']=$db_DB;

		//unathenticate user when log out
		$_SESSION['role']="NOTAUTHORIZED";
		unset($_SESSION['userid']);
	?>

	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td >&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br></td>		
		</tr>     
	</table>

    <form action="switchboard.php" method="post" name="index">        
		<table cellpadding="0" cellspacing="0" width="75%" align="center" bgcolor="#F0FFF0">
			<tr>
				<td>
					<fieldset >   
						<table cellpadding="0" cellspacing="0" width="100%" align="center">
							<tr>
								<td width="65%" valign="top" style="font-family:Verdana; font-size:medium" align="left">                 
									<img src="images/SDNA_tsmall.png" alt="drosophila" align ="left"> &nbsp;<br />
									Welcome to PADMA Database!  We are a group of academic scientific researchers and computer scientists who want to bridge the gap in the abundance of microarray data from publications around the world and easy accessibility to those datasets to the fly immunity research community. We designed PADMA (Pathogen Associated Drosophila MicroArray) Database, for easy retrieval of genes whose expression is altered by infections (microbial or parasitoid). The database also houses gene expression datasets in larval blood cells after activation of immune pathways.   <br>                       
								</td>
                                <td width="35%" align="left" valign="top">&nbsp;<br />
									<table width="90%">
										<tr>
											<td>
												<fieldset>
													<legend><font color="#4682B4">User Login </font></legend>
														<table cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td>
                                                                    <table cellpadding="2" cellspacing="2" width="100%" style="font-family:Verdana; font-size:small">
                                                                        <tr>
                                                                            <td align="right" width="50%">&nbsp;<br />
                                                                                User ID:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%">&nbsp;<br />
                                                                                <input name="userid" type="text" style="width:90%"/>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" width="50%"> 
                                                                                Password:&nbsp;&nbsp;
                                                                            </td>
                                                                            <td width="50%">
                                                                                <input name="Password1" type="password" style="width:90%" />
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <table cellpadding="0" width="100%" style="font-family:Verdana; font-size:small; font-weight:bold">
                                                                        <tr>
                                                                            <td align="right">
                                                                                <input id="btnLogin" type="submit" value="Login" />&nbsp;&nbsp;&nbsp;&nbsp;                                
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <table cellpadding="0" width="100%" style="font-family:Verdana; font-size:small; font-weight:bold">
                                                                        <tr>
                                                                            <td align="center">
                                                                                   <a title="passwordrecovery" href="PassRecovery.php">Forgot Password</a> |<a title="newuser" href="terms.php">New User</a>                             
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" width="100%"  style="font-family:Verdana; font-size:medium">
                                <tr>
                                    <td align="left">
                                       The PADMA database will allow a user to compare genes whose expression is altered after infection by a single or multiple pathogens. Query results are hyperlinked to FlyBase for further information of the gene as well as to facilitate navigation to other databases linked to FlyBase. The user is further able to drill and analyze pertinent data by refining and exporting the query results to a data analysis application.  In addition, users can upload their own experimental microarray data in confidence and compare result of their experiment against datasets available in PADMA.As more pathogen-related microarray experiments become available and are uploaded to the database, the scale and magnitude of PADMA will grow.  If you know of any published immunity-related microarray data not found in PADMA, please contact us so we can incorporate it into our data warehouse.
                                    </td>
                                </tr>
<tr><td><small>&nbsp;</small></td></tr>
                            </table>    
                        </fieldset>
                    </td>
                 </tr>
             </table>    
            <?php
			//include the header page
			include("footer.php");
			?>                    
        
    </form>
</body>
</html>