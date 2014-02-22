<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<script language="javascript" type="text/javascript">
<!-- hide script from older browsers

function validate(index)
{
 		//Check if a search criteria is selected
		var found_it=null 
		for (var i=0; i<document.forms.index.searchCriteria.length; i++)  {
			if (document.forms.index.searchCriteria[i].checked)  {
				found_it = document.forms.index.searchCriteria[i].value //set found_it equal to checked button's value

				}
			}  
		
		if(found_it != null){}

		else{ 
			alert("Please select a search criteria");
			return false;
		}
		
        //Check if the search field is empty
        if(""==document.forms.index.txt_searchToken.value)
        {
                alert("Please enter a Valid Search String.");
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
                            <td ><b>Refine Search...</b></td></tr></table><br><br><br>
                				<table cellpadding="5" cellspacing="0" width="100%"border="0" style="font-family:Verdana; font-size:medium">
                    				<tr>
                        				<td style="width:10%">&nbsp;</td>
                        				<td style="width:80%" align="left" >
                        					<form  action="RefineSearchResult.php" method="post" name="index" onsubmit="return validate(index);">
                        					<fieldset style="width:100%;padding:2">
												<table cellpadding="5" cellspacing="0" width="100%"border="0">
                    								<tr>
														<td width="50%">															
															<input type="radio" name="searchCriteria" value="CGNUMBER">CG Number<br>
															<input type="radio" name="searchCriteria" value="GENENAME">Gene Name<br>
															<input type="radio" name="searchCriteria" value="FBCGNUMBER">FBGN Number<br>
														</td>
														<td width="50%" align="left">
															<input name="txt_searchToken" type="text" style="width: 150px" />
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
			//include the header page
			include("footer.php");
			?> 
	</body>
</html>

