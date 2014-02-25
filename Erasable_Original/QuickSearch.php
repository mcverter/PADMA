<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" type="text/css" href="modalPopup.css" />
<script language="javascript" src="prototype.js"></script>
<script language="javascript" src="modalPopup.js"></script>

<script language="javascript" type="text/javascript">
function validate(index)
{
	//Check if a search criteria is checked
	var found_it=null 
	for (var i=0; i<document.forms.index.searchCriteria.length; i++)  {
		if (document.forms.index.searchCriteria[i].checked)  {
			found_it = document.forms.index.searchCriteria[i].value //set found_it equal to checked button's value
		}
	}  
	if(found_it != null){}
	else{ 
		alert("Please select a search criteria.");
		return false;
	}  
        //Check if the search field is empty
        if(""==document.forms.index.txt_searchToken.value)
        {
                alert("Please enter a valid search string.");
                return false;
        }        

}
</script>

</head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">

<?php
//include the header page
include("header.php");
include("utility.php");
if (session_id() == "") session_start();

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
                            <td ><b>Quick Search...</b></td></tr></table><br><br><br>
                				<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    				<tr>
                        				<td style="width:10%">&nbsp;</td>
                        				<td style="width:80%" align="left" >
                        					<form  action="QuickSearchResult.php" method="post" name="index" onsubmit="return validate(index);">
                        					<fieldset style="width:100%;padding:2">
												<table cellpadding="5" cellspacing="0" width="100%"border="0">
										<tr><th align="center" width="40%"><small>Search Criteria</small></th><th align="center" width="60%"><small>Search String</small></th></tr>
                    								<tr>
														<td width="40%" align="left">
															<input type="radio" name="searchCriteria" value="PROBEID">Prob ID<br>

															<input type="radio" name="searchCriteria" value="CGNUMBER">CG Number<br>
															<input type="radio" name="searchCriteria" value="GENENAME">Gene Name&nbsp;&nbsp;(<a href="javascript:openModalWindow(1);">list</a>)<br>
														</td>														
														<td width="60%" align="center">
															<input name="txt_searchToken" type="text" style="width: 150px" />
															<br>(example: aaa,bbb,ccc)
														</td>
													</tr>
												</table>
											</fieldset><br>&nbsp;<br>
			
											<fieldset style="width:100%;padding:2">												
												<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    								<tr>
														<td width="50%" align ="right">															
															Experiment Name: 
														</td>
														<td width="50%" align="left">
															<?php                                                                            
																$cmdstr = "select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='0' UNION select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='1' AND CREATED_BY='".$userid."' order by 1";
																$parsed = ociparse($db_conn, $cmdstr);
																ociexecute($parsed);
																$total = ocifetchstatement($parsed, $results);
																$EXP_NAME[]="ALL";
																for ($i = 0; $i < $total; $i++ )
    																{
																		$EXP_NAME[]=$results["EXP_NAME"][$i];
																		
																	}																			
                                                                echo "<select name='EXP_NAME[]' multiple='multiple' style='width:90%; font-family:verdana'>";																				                         
                                								for ($i=0;$i<count($EXP_NAME);$i++)
                                								{                                     
                                       								echo "<option value=" . $i . ($i == 0? " selected": "") . ">" . $EXP_NAME[$i] . "</option>";
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
															<?php                                                                            $cmdstr = "select distinct CATG from EXPERIMENT where RESTRICTED ='0'		UNION select distinct CATG from EXPERIMENT where RESTRICTED ='1' AND		CREATED_BY='".$userid."' order by 1";
																$parsed = ociparse($db_conn, $cmdstr);
																ociexecute($parsed);
																$total = ocifetchstatement($parsed, $results);
																$CATG[]="ALL";
																for ($i = 0; $i < $total; $i++ )
    																{
																		$CATG[]=$results["CATG"][$i];
																		
																	}																			
                                                                echo "<select name='CATG[]' multiple='multiple' style='width:90%; font-family:verdana'>";																				                         
                                								for ($i=0;$i<count($CATG);$i++)
                                								{                                     
                                       								echo "<option value=" . $i . ($i == 0? " selected" : "") . ">" . $CATG[$i] . "</option>";
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
																$cmdstr = "select distinct SPEC from EXPERIMENT where RESTRICTED ='0'	UNION select distinct SPEC from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='".$userid."' order by 1";
																$parsed = ociparse($db_conn, $cmdstr);
																ociexecute($parsed);
																$total = ocifetchstatement($parsed, $results);
																$SPEC[]="ALL";
																for ($i = 0; $i < $total; $i++ )
    																{
																		$SPEC[]=$results["SPEC"][$i];
																		
																	}																			
                                                                echo "<select name='SPEC[]' multiple='multiple' style='width:90%; font-family:verdana'>";																				                         
                                								for ($i=0;$i<count($SPEC);$i++)
                                								{                                     
                                       								echo "<option value=" . $i . ($i == 0? " selected" : "") . ">" . $SPEC[$i] . "</option>";
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
																$cmdstr = "select distinct SUBJ from EXPERIMENT where RESTRICTED ='0'	UNION select distinct SUBJ from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='".$userid."' order by 1";
																$parsed = ociparse($db_conn, $cmdstr);
																ociexecute($parsed);
																$total = ocifetchstatement($parsed, $results);
																$SUBJ[]="ALL";
																for ($i = 0; $i < $total; $i++ )
    																{
																		$SUBJ[]=$results["SUBJ"][$i];
																		
																	}																			
                                                                echo "<select name='SUBJ[]' multiple='multiple' style='width:90%; font-family:verdana'>";																				                         
                                								for ($i=0;$i<count($SUBJ);$i++)
                                								{                                     
                                       								echo "<option value=" . $i . ($i == 0? " selected" : "") . ">" . $SUBJ[$i] . "</option>";
                                								}
															?>
                                							</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Regulation Value: 
														</td>
														<td width="50%" align="left">
															<?php
																$cmdstr = "select distinct REG_VAL from EXPERIMENT where RESTRICTED ='0'	UNION select distinct REG_VAL from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='".$userid."' order by 1";
																$parsed = ociparse($db_conn, $cmdstr);
																ociexecute($parsed);
																$total = ocifetchstatement($parsed, $results);
																$REG_VAL[]="ALL";
																for ($i = 0; $i < $total; $i++ )
    																{
																		$REG_VAL[]=$results["REG_VAL"][$i];
																		
																	}																			
                                                                echo "<select name='REG_VAL[]' multiple='multiple' style='width:90%; font-family:verdana'>";																				                         
                                								for ($i=0;$i<count($REG_VAL);$i++)
                                								{                                     
                                       								echo "<option value=" . $i . ($i == 0? " selected" : "") . ">" . $REG_VAL[$i] . "</option>";
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
     	$_SESSION['EXP_NAME_Q']=$EXP_NAME;
     	$_SESSION['CATG_Q']=$CATG;
     	$_SESSION['SPEC_Q']=$SPEC;
     	$_SESSION['SUBJ_Q']=$SUBJ;
     	$_SESSION['REG_VAL_Q']=$REG_VAL;
			//include the header page
			include("footer.php");
			?> 
	</body>
</html>

