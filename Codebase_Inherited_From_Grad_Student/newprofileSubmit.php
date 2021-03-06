<?php
if (session_id() == "") session_start();

//get connection string variable from session
$db_UN=$_SESSION['un'];
$db_PASS=$_SESSION['pass'];
$db_DB=$_SESSION['db'];

//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
if (! $db_conn) {
	$e = oci_error(); 		
	echo "<font color='red'>";
	print htmlentities($e['message']);
	echo "<br>ERROR: Connecting to Database, Please try back later<br>";
	echo "</font>";
	echo "<a title='logout' href='index.php'>Click Here</a> to go back to home page";
	exit;
}

$title = empty($_POST['title'])? "" : $_POST['title'];
$lname = $_POST['lname']; // mandatory
$fname = $_POST['fname']; // mandatory
$mname = empty($_POST['mname'])? "" : $_POST['mname'];
$address = empty($_POST['address'])? "": $_POST['address'];
$address2 = empty($_POST['address2'])? "" : $_POST['address2'];
$city = empty($_POST['city'])? "" : $_POST['city'];
$state = empty($_POST['state'])? "" : $_POST['state'];
$zip = empty($_POST['zip'])? "" : $_POST['zip'];
$phone = empty($_POST['phone'])? "" : $_POST['phone'];
$email = $_POST['email']; // mandatory
$industry = empty($_POST['industry'])? "" : $_POST['industry'];
$profession = empty($_POST['profession'])? "" : $_POST['profession'];
$userid = $_SESSION['userid']; // mandatory

//find the country
$countryID=intval($_POST['country']);
$cmdstr = "select country from country where countryid = $countryID";
$parsed0 = ociparse($db_conn, $cmdstr);
ociexecute($parsed0);
$nrow = ocifetchstatement($parsed0, $country);
oci_free_statement($parsed0);

//update user profile
$cmdstr = "update CLIENT set TITLE = '" . $title . "', LNAME = '" . $lname . "', FNAME = '" . $fname 
	. "', MNAME = '" . $mname . "', ADD_1 = '" . $address . "', ADD_2 = '" . $address2 . "', CITY = '" . $city 
	. "', STATE = '" . $state . "', ZIP = '" . $zip . "', COUNTRY = '" . $country["COUNTRY"][0] . "', PHONE = '" . $phone 
	. "', EMAIL = '" . strtoupper($email) . "', IND = '" . $industry . "', PROF = '" . $profession 
	. "', UPDATED_BY = '" . $userid . "', UPDATED_ON = SYSDATE WHERE USER_ID = '". $userid . "'";
//echo $cmdstr;	
$parsed = ociparse($db_conn, $cmdstr);
$execute = ociexecute($parsed);	
oci_free_statement($parsed);

//Check if the information is saved and show appropriate message
echo $execute? "<font color='#008000'>Your profile updated</font>" : "<font color='#008000'>Error! update failed</font>";

?>




