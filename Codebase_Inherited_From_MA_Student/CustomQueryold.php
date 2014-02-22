<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<script language="javascript" type="text/javascript">
<!-- hide script from older browsers

function validate(index)
{
 		//Check if a search criteria is selected
		var found_it=null 
		for (var i=0; i<document.forms.index.searchFrom.length; i++)  {
			if (document.forms.index.searchFrom[i].checked)  {
				found_it = document.forms.index.searchFrom[i].value //set found_it equal to checked button's value

				}
			}  
		
		if(found_it != null){}

		else{ 
			alert("Please select a Search Criteria");
			return false;
		}

}
 stop hiding script -->
</script>
 </head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">

<?php
//include the header page
include("header.php");
session_start();
$maxExecutionTime=6000;

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
  
//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
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


<table width="100%">
	<tr>
        <td style="width:20%">&nbsp;</td>
        <td style="width:60%">
        <table width="100%" border="1" style="border-collapse:collapse; border-color:#4682b4; border-style:solid">
    		<tr>
            	<td>
                    <table width="100%" style="background-image:url('images/Tblheader.png');color:#ffffff" cellpadding="4"cellspacing="0">
						<tr>
                            <td ><b>Custom Query...</b></td></tr></table><br><br><br>
                				<table cellpadding="5" cellspacing="0" width="100%"border="0" style="font-family:Verdana; font-size:medium">
                    				<tr>
                        				<td style="width:10%">&nbsp;</td>
                        				<td style="width:80%" align="left" >
                        				
                        					<form  action="CustomQueryResult.php" method="post" name="index" onsubmit="return validate(index);">
                        					<table cellpadding="5" cellspacing="0" width="100%"border="0" style="font-family:Verdana; font-size:medium">
                    						<tr>
												<td align="center"> <b>Search:&nbsp;&nbsp;&nbsp; </b>
												<input type="radio" name="searchFrom" value="ExpData">Experiment Data &nbsp;&nbsp;&nbsp;
												<input type="radio" name="searchFrom" value="RefData">Reference Data<br>
												</td>
											</tr>
										</table>
                        					<fieldset style="width:100%;padding:2">
												<table cellpadding="5" cellspacing="0" width="100%"border="0" style="font-family:Verdana; font-size:medium">
                    								<tr>
														<td width="50%" align ="right">															
															Prob ID: 
														</td>
														<td width="50%" align="left">
															<input name="PROBEID" type="text" style="width: 90%" />
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															CG Number: 
														</td>
														<td width="50%" align="left">
															<input name="CGNUMBER" type="text" style="width: 90%" />
														</td>
													</tr>
													
													<tr>
														<td width="50%" align ="right">															
															FBCG Number: 
														</td>
														<td width="50%" align="left">
															<input name="FBCGNUMBER" type="text" style="width: 90%" />
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Gene Name: 
														</td>
														<td width="50%" align="left">
															<input name="GENENAME" type="text" style="width: 90%" />
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															GO Number: 
														</td>
														<td width="50%" align="left">
															<input name="GONUMBER" type="text" style="width: 90%" />
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Bio Function: 
														</td>
														<td width="50%" align="left">
															<input name="BIOFUNCTION" type="text" style="width: 90%" />
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Experiment Name: 
														</td>
														<td width="50%" align="left">
															<?php                                                                            
																$cmdstr = "select distinct EXP_NAME from EXPERIMENT order by EXP_NAME";
																$parsed = ociparse($db_conn, $cmdstr);
																ociexecute($parsed);
																$total = ocifetchstatement($parsed, $results);
																$EXP_NAME[]="ALL";
																for ($i = 0; $i < $total; $i++ )
    																{
																		$EXP_NAME[]=$results["EXP_NAME"][$i];
																		
																	}																			
                                                                echo "<select name='EXP_NAME[]' multiple='multiple' style='width:90%; font-family:verdana'>";																				                         
                                								for ($i=0;$i<=count($EXP_NAME);$i++)
                                								{                                     
                                       								echo "<option value=" . $i . ">" . $EXP_NAME[$i] . "</option>";
                                								}
															?>
                                							</select>
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Active Category: 
														</td>
														<td width="50%" align="left">
															<?php                                                                            
																$cmdstr = "select distinct CATG from EXPERIMENT order by CATG";
																$parsed = ociparse($db_conn, $cmdstr);
																ociexecute($parsed);
																$total = ocifetchstatement($parsed, $results);
																$CATG[]="ALL";
																for ($i = 0; $i < $total; $i++ )
    																{
																		$CATG[]=$results["CATG"][$i];
																		
																	}																			
                                                                echo "<select name='CATG[]' multiple='multiple' style='width:90%; font-family:verdana'>";																				                         
                                								for ($i=0;$i<=count($CATG);$i++)
                                								{                                     
                                       								echo "<option value=" . $i . ">" . $CATG[$i] . "</option>";
                                								}
															?>
                                							</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Active Species: 
														</td>
														<td width="50%" align="left">
															<?php                                                                            
																$cmdstr = "select distinct SPEC from EXPERIMENT order by SPEC";
																$parsed = ociparse($db_conn, $cmdstr);
																ociexecute($parsed);
																$total = ocifetchstatement($parsed, $results);
																$SPEC[]="ALL";
																for ($i = 0; $i < $total; $i++ )
    																{
																		$SPEC[]=$results["SPEC"][$i];
																		
																	}																			
                                                                echo "<select name='SPEC[]' multiple='multiple' style='width:90%; font-family:verdana'>";																				                         
                                								for ($i=0;$i<=count($SPEC);$i++)
                                								{                                     
                                       								echo "<option value=" . $i . ">" . $SPEC[$i] . "</option>";
                                								}
															?>
                                							</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Experiment Subject: 
														</td>
														<td width="50%" align="left">
															<?php                                                                            
																$cmdstr = "select distinct SUBJ from EXPERIMENT order by SUBJ";
																$parsed = ociparse($db_conn, $cmdstr);
																ociexecute($parsed);
																$total = ocifetchstatement($parsed, $results);
																$SUBJ[]="ALL";
																for ($i = 0; $i < $total; $i++ )
    																{
																		$SUBJ[]=$results["SUBJ"][$i];
																		
																	}																			
                                                                echo "<select name='SUBJ[]' multiple='multiple' style='width:90%; font-family:verdana'>";																				                         
                                								for ($i=0;$i<=count($SUBJ);$i++)
                                								{                                     
                                       								echo "<option value=" . $i . ">" . $SUBJ[$i] . "</option>";
                                								}
															?>
                                							</select> 
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
     	</table>
     	<?php
     	//save values of dropdown fields into session variable
     	$_SESSION['EXP_NAME_S']=$EXP_NAME;
     	$_SESSION['CATG_S']=$CATG;
     	$_SESSION['SPEC_S']=$SPEC;
     	$_SESSION['SUBJ_S']=$SUBJ;
     	//close database connection
			oci_close($db_conn);
			//include the header page
			include("footer.php");
			?> 
	</body>
</html>

