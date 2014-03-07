<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class SubmitProfilePage extends DatabaseConnectionPage {


function __construct() {

}
function print_contents() {
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
}
}
?>




 
 
 
 
 
 
 
 
