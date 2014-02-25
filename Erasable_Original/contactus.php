<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
.style1 {
        border-collapse: collapse; font-family: Tahoma; font-weight: bold;
        font-size: medium; background-color: #F0F8FF; color: #6CA6CD;
        }


</style>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">

<?php
//include the header page
session_start();
include("header.php");
?>

<table width="100%" style="font-family: Tahoma" cellpadding="0" >
        <tr>
                <td align="left"><br><br>                
                </td>
        </tr>
</table>

<table width="100%" style="font-family: Tahoma" cellpadding="0" >
        <tr>
                <td align="left"><br><br>                
                </td>
        </tr>
</table>

<table width="50%" align="center"><tr><td>
<fieldset>
<table width="100%" align="center" style="font-family: Tahoma" cellpadding="0" style="border-width:1px;border-collapse:collapse; border-style:solid; border-color:#4682B4">
        <tr>
                <td align="left">
					<table width="100%" style="font-family: Tahoma" cellpadding="0" bgcolor="#A5D7E7">
						<tr>
							<td>
							<font color="#4682b4"><h3>&nbsp;&nbsp;Send your inquiry or problem &#8212; we will respond you!</h3></font>
							</td>
						</tr>
					</table>
                </td>
        </tr>
		<tr>
			<td>			
				<table width="90%" style="border-collapse:collapse" cellpadding="0" align="center">
					<tr>
						<td align ="left">
							<form action="FormToEmail.php" method="post">
								<table border="0" cellspacing="5" style="font-family: Tahoma">
									<tr>
										<td><br></td>
										<td><br></td>
									</tr>
									<tr>
										<td>Your Name</td>
										<td><input type="text" size="30" name="name"></td>
									</tr>
									<tr>
										<td>Email address</td>
										<td><input type="text" size="30" name="email"></td>
									</tr>
									<tr>
										<td valign="top">Comments</td>
										<td><textarea name="comments" rows="6" cols="50"></textarea></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><input type="submit" value="Send"></td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
					<tr>
						<td><br></td>
					</tr>       
				</table>
			</td>
		</tr>
</table>
</fieldset>
</table></tr></td>

<?php
//include the footer page
include("footer.php");
?>


</body>

</html>
