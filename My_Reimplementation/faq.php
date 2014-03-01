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
if (session_id() == "") session_start();
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
<form action="switchboard.php" method="post" name="index">        
	<table cellpadding="0" cellspacing="0" width="85%" align="center" bgcolor="#FFFAFA">
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0" width="100%" align="center" style="border-width:1px;border-collapse:collapse; border-style:solid; border-color:#4682B4">
					<tr>                                    
						<td>&nbsp;<br>&nbsp;<br>                       
							<table  cellpadding="0" align="center" cellspacing="0" width="80%">
								<tr>
									<td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
										<br><b>New User/Log-In</b><hr>										
											<table width="100%">
												<tr>
													<td valign="top" style="font-family:Verdana; font-size:small" align="left">
														<ul>
															<li><a href="faq.php#n1">What is involved in the Registration Process?</a></li>
															<li><a href="faq.php#n2">What information do I need to provide to register?</a></li>
															<li><a href="faq.php#n3">What is the “Check” button on part 2 of the registration process?</a></li>
															<li><a href="faq.php#n4">Is there a Password format requirement?</a></li>
															<li><a href="faq.php#n5">What if I can’t remember my password?</a></li>
														</ul>
													</td>
												</tr>
											</table>										
									</td>
								</tr>

								<tr>
									<td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
										<br><b>Query</b><hr>										
											<table width="100%">
												<tr>
													<td valign="top" style="font-family:Verdana; font-size:small" align="left">
														<ul>
															<li><a href="faq.php#q1">What is the difference between the three query types?</a></li>
															<li><a href="faq.php#q2">Can I search multiple entries (i.e. genes, GC Number, etc.)?</a></li>
															<li><a href="faq.php#q3">Where can I find a list of genes that’s in PADMA?</a></li>
															<li><a href="faq.php#q4">Is a Probe ID associated with only one gene?</a></li>
															<li><a href="faq.php#q5">Is a gene associated with only one Probe ID?</a></li>
														</ul>
													</td>
												</tr>
											</table>										
									</td>
								</tr>


								<tr>
									<td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
										<br><b>Export Files</b><hr>										
											<table width="100%">
												<tr>
													<td valign="top" style="font-family:Verdana; font-size:small" align="left">
														<ul>
															<li><a href="faq.php#e1">What format is the Query Result Table exported in?</a></li>
															<li><a href="faq.php#e2">Can I export a full dataset from an experiment?</a></li>
														</ul>
													</td>
												</tr>
											</table>										
									</td>
								</tr>
								
								<tr>
									<td valign="top" style="font-family:Verdana; font-size:Medium" align="left">
										<br><b>Upload Files</b><hr>										
											<table width="100%">
												<tr>
													<td valign="top" style="font-family:Verdana; font-size:small" align="left">
														<ul>
															<li><a href="faq.php#u1">Why do I get a “Invalid file type, file was not uploaded.” message?</a></li>
															<li><a href="faq.php#u2">Why do I get a “File is not in Right Format” message?</a></li>
															<li><a href="faq.php#u3">What is the Upload File format?</a></li>
															<li><a href="faq.php#u4">If my raw file is not in csv or excel, can I still use PADMA?</a></li>
															<li><a href="faq.php#u5">Does PADMA provide user/tech support for file upload?</a></li>
														</ul>
													</td>
												</tr>
												<tr><td>&nbsp;</td></tr>
											</table>										
									</td>
								</tr>								
							</table>
						</td>									
					</tr>
				</table>
			</td>
		</tr>
	</table>    
            
</form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<table  cellpadding="0" align="center" cellspacing="0" width="90%">
	<tr>
		<td valign="top" style="font-family:Verdana; font-size:Medium" align="right">
			<br><h3><b>New User/Log-In</b></h3><hr>			
		</td>
	</tr>
	<tr>
		<td valign="top" style="font-family:Verdana; font-size:Medium">

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="n1"><b><font color="#4682B4">What is involved in the Registration Process?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						You need to:
							<ol>
								<li>Click on “New User”
								<li>Complete and submit the registration form
								<li>PADMA Admin will contact you when your user set-up is complete
							</ol>
						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="n2"><b><font color="#4682B4">What information do I need to provide to register?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						Please fill out the registration form as complete as possible.  Please ensure to provide us with your most current email address, since we will communicate with you via email.  Please be assured that information you provide will not be shared to a third party. Please refer to the Terms of Use for details on privacy notice.  <br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>
			

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="n3"><b><font color="#4682B4">What is the “Check” button on part 2 of the registration process?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						The system will verify whether your name, email address, or User ID is already in the system to avoid duplicate entry.  If we already have your information, the system will automatically reject your registration.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="n4"><b><font color="#4682B4">Is there a Password format requirement?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						No.  You are free to choose any password you’d like.  However, we recommend that you choose a password that’s easy for you to remember has a combination of alpha numeric, and it’s difficult for others to guess.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="n5"><b><font color="#4682B4">What if I can’t remember my password?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						Contact PADMA Admin under “Contact Us” for password reset.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>			
		</td>
	</tr>
</table>


<table  cellpadding="0" align="center" cellspacing="0" width="90%">
	<tr>
		<td valign="top" style="font-family:Verdana; font-size:Medium" align="right">
			<br><h3><b>Query</b></h3><hr>			
		</td>
	</tr>
	<tr>
		<td valign="top" style="font-family:Verdana; font-size:Medium">

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="q1"><b><font color="#4682B4">What is the difference between the three query types?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						While all three query type will essentially give you the same gene profile results, each query is uniquely design to optimize your search based on information available to you (i.e. gene name, probe set ID, bio function etc.).  We recommend the following brief guidelines:
							<ul>
								<li><b>Quick Gene Search:</b> if you have a gene name/CG number/Probe ID/FlyBase number, but are not interested in/don’t know specific bio function associated with the genes.  Thus, the query result table will not show any bio functions associated with the gene you are querying.

								<li><b>Advanced Query:</b> it let you search ALL criteria in PADMA.  Thus, your query result table will contain all the information for that gene, including all the bio function associated.  So, if your gene of interest has 4 bio function associated, and your query is restricted to 4 experiments with 3 time points each, you will have a total of 48 results.

								<li><b>Refine Query:</b> unlike Quick Gene Search and Advanced Query, Refine Query is divided into two layers.  The first layer lets you search by either gene related info or bio function.  The second layer (a separate pop window when you submit the search criteria of the first layer) lets you search by experiment criteria like Category, Subject, Regulation Value, etc. 
							</ul>
						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="q2"><b><font color="#4682B4">Can I search multiple entries (i.e. genes, GC Number, etc.)?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						Yes! All you need to do is add a comma after each entry. Example: “IM2,Myd88,AttA”<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>
			

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="q3"><b><font color="#4682B4">Where can I find a list of genes that’s in PADMA?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						You can either click on the list next to “Gene Name” or go to the “Document” tab on the top of the website to download the list of all genes associated with a specific probe set and GO number.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="q4"><b><font color="#4682B4">Is a Probe ID associated with only one gene?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						For the most part, one probe set will have a oligonucleotides sequences that is associated with sequences for a particular gene.  However, there are many instances where genes share similar probe sequence.  You can find these associations by downloading the gene list found in the “Document” tab on the top of the website.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="q5"><b><font color="#4682B4">Is a gene associated with only one Probe ID?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						For the most part, one gene will only have one probe set that is associated.  However, alternative splicing, degenerative codes, and other biological complexity makes it possible for one gene to be picked-up by multiple probe set.  You can find these associations by downloading the gene list found in the “Document” tab on the top of the website.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>			
		</td>
	</tr>
</table>


<table  cellpadding="0" align="center" cellspacing="0" width="90%">
	<tr>
		<td valign="top" style="font-family:Verdana; font-size:Medium" align="right">
			<br><h3><b>Export Files</b></h3><hr>			
		</td>
	</tr>
	<tr>
		<td valign="top" style="font-family:Verdana; font-size:Medium">
			
			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="e1"><b><font color="#4682B4">What format is the Query Result Table exported in?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						PADMA only exports file in Excel.  You can later convert this file into any format you wish, if possible with your software application/operating system.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>
			

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="e2"><b><font color="#4682B4">Can I export a full dataset from an experiment?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						While this is possible, by specifying your query, it will take considerable about of time.  We suggest you query and search on PADMA and export specific results of interest.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>



<table  cellpadding="0" align="center" cellspacing="0" width="90%">
	<tr>
		<td valign="top" style="font-family:Verdana; font-size:Medium" align="right">
			<br><h3><b>Upload Files</b></h3><hr>			
		</td>
	</tr>
	<tr>
		<td valign="top" style="font-family:Verdana; font-size:Medium">

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="u1"><b><font color="#4682B4">Why do I get a “Invalid file type, file was not uploaded.” message?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						To upload file, you must use a Comma Separated Value (csv) format.  Any other format will be rejected.<br><br>
						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="u2"><b><font color="#4682B4">Why do I get a “File is not in Right Format” message?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						More than likely, this message was followed by a second message indicating to check a specific Row or Column.  Please open your load file and check the format of the row/column specified in the error message.  Sometimes, this results from skipped rows/columns, invalid text or special characters.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>
			

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="u3"><b><font color="#4682B4">What is the Upload File format?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						You need a total of 8 columns, with specific layout.  The file has to be saved as a Comma Separated Value (csv) file.  Please refer to the User Manual, Section 5.0 and 5.1 for specific details.  <br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="u4"><b><font color="#4682B4">If my raw file is not in csv or excel, can I still use PADMA?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						Absolutely.  While PADMA Format is restricted to csv file (and Excel file saved as csv), other file formats can be easily converted into a csv file.  Please refer to a computer guidebook or contact a data analyst for support.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%" align="left"> 
						<a name="u5"><b><font color="#4682B4">Does PADMA provide user/tech support for file upload?</font></b></a>
					</td>					
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="100%" align="left" style="font-family:Verdana; font-size:small"> 
						While we don’t have the resources to provide user/tech support, should you have any questions, don’t hesitate to email us.<br><br>

						<a href="faq.php">&lt;&lt;Back to FAQ</a><br><br>
					</td>
				</tr>
			</table>			
		</td>
	</tr>
</table>
<br>
<?php
	//include the header page
	include("footer.php");
	?> 
</body>
</html>
