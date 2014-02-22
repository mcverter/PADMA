<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
//include the header page
include("header.php");
//start session
session_start();

//set maximum execution time
$maxExecutionTime=6000;
set_time_limit ( $maxExecutionTime );
?>

<head>

</head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">




   <table width="100%">
    <tr>
        <td style="width:20%">&nbsp;</td>
        <td style="width:60%">
        <table width="100%" border="1" style="border-collapse:collapse; border-color:#4682b4; border-style:solid">
        <tr>
            <td>
                    <table width="100%" style="background-image:url('Tblheader.png');color:#ffffff" cellpadding="4"  cellspacing="0"><tr>
                                        <td ><b>Uploaded File...</b></td></tr></table><br><br><br>
                                        

                <table cellpadding="5" cellspacing="0" width="100%">
                    <tr> <td style="width:20%" align="right" >&nbsp;</td>
                         <td style="width:80%" align="left" valign="bottom">
                         <?php
								//Get sesisson veriable to connect to database
                                $db_UN=$_SESSION['un'];
                                $db_PASS=$_SESSION['pass'];
                                $db_DB=$_SESSION['db'];

								//Directory location of the file that will be loaded
                                $directories="C:/inetpub/wwwroot/droso/";
                                $file = $_REQUEST['uploadedfile'] ;
                                $fileName=$directories . $file;   
								echo $fileName ."<br><br>";

								//---Veriable declaration to track the file that will be loaded
								$TotalRowToInsert =0;	
								$noError=true;
								$parts=array();

								//----Check how many rows are in the file
								$handle = fopen($fileName, "rb");
								while ((!feof($handle)) and ($noError)) {
									$line_of_text = fgets($handle);
									$parts = explode(',', $line_of_text);
									if(count($parts)< 5)
									{
										$noError=false;
									}
									//echo $line_of_text . "<br><br>";
									$TotalRowToInsert++;									
								}
								//close the file
								fclose($handle);
								if($noError)
								{
									echo "Total Record: " . $TotalRowToInsert;
								}
								else
								{
									echo "File is not in Right format <br> Check Row# " . $TotalRowToInsert++ . " PID: " .$parts[0]; 
								}
							?>                 

                     </TD>
                    </tr>

                     <tr>
                     <td style="width:20%" align="right">&nbsp;</td>
                     <td> <p><div id="txtHint"><b></b></div></p> </td>

                     </tr>
                    <tr>

                        <td style="width:20%" align="right">&nbsp;</td>
                        <td style="width:80%" align="center">

                    </tr>


                </table><br><br><br>


                <form   action="loaderStart.php" method="POST">
                <table cellpadding="5" cellspacing="0" width="100%">
                    <tr> <td style="width:20%" align="right" >&nbsp;</td>
                         <td style="width:80%" align="left" valign="bottom">



                           <input name="Button1" type="submit" value="Create Tableu" />
                           </form>


                     </TD>
                    </tr> </table>

        </td>
        <td style="width:20%">&nbsp;</td>
     </tr>
     </table>

</body>
</html>

