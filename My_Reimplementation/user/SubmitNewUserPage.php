<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class SubmitNewUserPage extends DatabaseConnectionPage {

function __construct() {
    function print_content() {
    // get value of userid verification from session veriable

$uidVerified=$_SESSION['uidVerified'];

//Check if the user id was verified before submitting the form
if ($uidVerified=="false")
{
  echo "<font color='#FF0000'>Please, <u>Check UserID</u> before submitting the form</font>";
  echo "<br>Click <a href='newuser.php'>here</a> to go back to New User Registration page";
  unset($_SESSION['uidVerified']);
  return;
}

$token=1;


//Get all the value from the registration form
$title = empty($_POST['title'])? "" : $_POST['title'];
$lname = $_POST['lname']; // mandatory
$fname = $_POST['fname']; // mandatory
$MI = empty($_POST['MI'])? "" : $_POST['MI'];
$address = empty($_POST['address'])? "": $_POST['address'];
$address2 = empty($_POST['address2'])? "" : $_POST['address2'];
$city = empty($_POST['city'])? "" : $_POST['city'];
$state = empty($_POST['state'])? "" : $_POST['state'];
$zip = empty($_POST['zip'])? "" : $_POST['zip'];
$phone = empty($_POST['phone'])? "" : $_POST['phone'];
$email = $_POST['email']; // mandatory
$industry = empty($_POST['industry'])? "" : $_POST['industry'];
$profession = empty($_POST['profession'])? "" : $_POST['profession'];
$userid = $_SESSION['nUserID']; // mandatory
$password = $_POST['password']; // mandatory


//find the country
$countryID=intval($_POST['Country']);
$cmdstr = "select country from country  where countryid=$countryID";
$parsed0 = ociparse($db_conn, $cmdstr);
ociexecute($parsed0);
$Country = ocifetchstatement($parsed0, $country);


// hash the password
$hashedPassword = sha1($password);
$modifiedUserID=strtoupper($userid);
$modifiedEmail=strtoupper($email);

//Check if userid or email address already exist in the database
$cmdstr = "select USER_ID from CLIENT WHERE USER_ID = '".$modifiedUserID."'";
$parsed = ociparse($db_conn, $cmdstr);
ociexecute($parsed);
$numrows = ocifetchstatement($parsed, $results);
if ($numrows > 0)
{
  echo "<table><tr><td>";
  echo "<font color='#FF0000'>Sorry! $userid is already taken. Please, choose a different User ID</font>";
  echo "<br>Click <a href='newuser.php'>here</a> to go back to New User Registration page";
  echo "</td></tr></table>";
  $_SESSION['uidVerified']="false";
  exit;

}

//Check if email address already exist in the database
$cmdstr = "select USER_ID from CLIENT WHERE EMAIL='".$modifiedEmail."'";
$parsed = ociparse($db_conn, $cmdstr);
ociexecute($parsed);
$numrows = ocifetchstatement($parsed, $results);
if ($numrows > 0)
{
  echo "<table><tr><td>";
  echo "<font color='#FF0000'>Sorry! $email is already in use.</font>";
  echo "<br>Click <a href='newuser.php'>here</a> to go back to New User Registration page";
  echo "</td></tr></table>";
  $_SESSION['uidVerified']="false";
  exit;

}


//insert all information to database
$stmt = 'BEGIN USERMANAGEMENT(:PARAM_TITLE,:PARAM_LNAME,:PARAM_MNAME,:PARAM_FNAME,:PARAM_ADD_1,:PARAM_ADD_2,:PARAM_CITY,:PARAM_STATE,:PARAM_ZIP,:PARAM_COUNTRY,:PARAM_PHONE,:PARAM_EMAIL,:PARAM_IND,:PARAM_PROF,:PARAM_USER_ID,:PARAM_PASSWORD); END;';
$stmt = oci_parse($db_conn,$stmt);
//  Bind the input parameter
oci_bind_by_name($stmt,":param_title",$title,10);
oci_bind_by_name($stmt,":param_lname",$lname,60);
oci_bind_by_name($stmt,":PARAM_MNAME",$MI,1);
oci_bind_by_name($stmt,":PARAM_FNAME",$fname,20);
oci_bind_by_name($stmt,":PARAM_ADD_1",$address,40);
oci_bind_by_name($stmt,":PARAM_ADD_2",$address2,40);
oci_bind_by_name($stmt,":PARAM_CITY",$city,20);
oci_bind_by_name($stmt,":PARAM_STATE",$state,20);
oci_bind_by_name($stmt,":PARAM_ZIP",$zip,10);
oci_bind_by_name($stmt,":PARAM_COUNTRY",$country["COUNTRY"][0],50);
oci_bind_by_name($stmt,":PARAM_PHONE",$phone,15);
oci_bind_by_name($stmt,":PARAM_EMAIL",$modifiedEmail,30);
oci_bind_by_name($stmt,":PARAM_IND",$industry,100);
oci_bind_by_name($stmt,":PARAM_PROF",$profession,100);
oci_bind_by_name($stmt,":PARAM_USER_ID",$modifiedUserID,15);
oci_bind_by_name($stmt,":PARAM_PASSWORD",$hashedPassword,250);

//echo "$title,$lname,$MI,$fname," . $country["COUNTRY"][0] . ",$modifiedEmail,$modifiedUserID,$hashedPassword<br>";
$execute=oci_execute($stmt);

//echo $email . " " . $modifiedUserID . "<br>";

//Check if the information is saved and show appropriate message
if($execute)
{
  echo "Your information is submitted for approval from system administrator <br>You will receive a email when your account is setup";
  echo  "<br>Click <a href='index.php'>here</a> to go back to Homepage page";
}
else
{
  echo "There was a problem submitting your information<br>Please try again later";
  echo "<br>Click <a href='newuser.php'>here</a> to go back to Homepage page" ;
}

//unset the session variable that is saving the information about userid verification
unset($_SESSION['uidVerified']);
    }
}
 
 
 
 
 
 
 
 
