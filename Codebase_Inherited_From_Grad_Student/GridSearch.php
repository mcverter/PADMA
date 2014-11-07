<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<script language="javascript" type="text/javascript">
<!-- hide script from older browsers

function validate(index)
{
 		
        //Check if more than three box is selected
        var selected=0;
        if(document.index.PROBEID.checked==true)
			selected=selected+1;
		
		if(document.index.CGNUMBER.checked==true)
			selected=selected+1;
		
		if(document.index.FBCGNUMBER.checked==true)
			selected=selected+1;
		
		if(document.index.GENENAME.checked==true)
			selected=selected+1;
		
		if(document.index.GONUMBER.checked==true)
			selected=selected+1;
		
		if(document.index.BIOFUNCTION.checked==true)
			selected=selected+1;
		
		if(document.index.EXPERIMENTNAME.checked==true)
			selected=selected+1;
		
		if(document.index.ACTIVECATEGORY.checked==true)
			selected=selected+1;
		
		if(document.index.ACTIVESPECIES.checked==true)
			selected=selected+1;
		
		if(document.index.EXPERIMENTSUBJECT.checked==true)
			selected=selected+1;
		
		if(document.index.REGULATIONVALUE.checked==true)
			selected=selected+1;
		
		if(document.index.ADDITIONALINFO.checked==true)
			selected=selected+1;
		
		if(selected >3)
		{
			alert("Please select three or less checkbox.");
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

$role=$_SESSION['role'];
if($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
{
	
}
else
{
 	echo "Access Denied";
	return;
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


<table width="100%">
	<tr>
        <td style="width:20%">&nbsp;</td>
        <td style="width:60%">
        <table width="100%" border="1" style="border-collapse:collapse; border-color:#4682b4; border-style:solid">
    		<tr>
            	<td>
                    <table width="100%" style="background-image:url('images/Tblheader.png');color:#ffffff" cellpadding="4"cellspacing="0">
						<tr>
                            <td ><b>Grid Search...</b></td></tr></table><br><br><br>
                				<table cellpadding="5" cellspacing="0" width="100%"border="0" style="font-family:Verdana; font-size:medium">
                    				<tr>
                        				<td style="width:10%">&nbsp;</td>
                        				<td style="width:80%" align="left" >
                        					<form  action="QuickSearchResult.php" method="post" name="index" onsubmit="return validate(index);">
                        					<fieldset style="width:100%;padding:2">
												<table cellpadding="5" cellspacing="0" width="100%"border="0" style="font-family:Verdana; font-size:medium">
                    								<tr>
														<td width="50%" align ="right">															
															Prob ID: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															CG Number: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													
													<tr>
														<td width="50%" align ="right">															
															FBCG Number: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Gene Name: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															GO Number: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Bio Category: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Experiment Name: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Active Category: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Active Species: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Experiment Subject: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
                                                        	</select> 
														</td>
													</tr>
													<tr>
														<td width="50%" align ="right">															
															Regulation Value: 
														</td>
														<td width="50%" align="left">
															<select name="title" style="width:90%">
                                                            <option>All</option>                                                            
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
			
											<fieldset style="width:100%;padding:2">
												<legend style="color:#4682b4; font-weight:bold;font-family: Verdana; margin-bottom: 15">Search Result
                            					</legend>
												<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    								<tr>
														<td width="100%">
														
															<center><br><br><br>Result<br><br><br></center>
														</td>
													</tr>
												</table>
											</fieldset>
                        
											<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    							<tr>
													<td width="100%" align="Right">
														<input name="btn_submit" type="submit" value="Export"/>
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
			//include the header page
			include("footer.php");
			?> 
	</body>
</html>

