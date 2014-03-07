<?php
require_once(__DIR__ . "/../functions/PageControlFunctions.php");


//get connection string variable from session
$db_UN=0;
$db_PASS=0;
$db_DB=0;

//connection to the database
$db_conn = 0; if (! $db_conn)
{
	$e = oci_error(); 		
	echo "<font color='red'>";
	print htmlentities($e['message']);
	echo "<br>ERROR: Connecting to Database, Please try back later<br>";
	echo "</font>";
 	exit;
}
if ($param=="undefined") 
{
	//echo "<font color='#FF0000'>ERROR: undefined parameter sent to utility function (internal logic error)</font>";
}

else if ($param=="verifyUserName")
{
 	$userID=$_GET["UserID"];
 	
 	if(strlen(trim($userID," "))<1)
 	{
		echo "<table><tr><td>";
		echo "<font color='#FF0000'>Select a User ID</font>";
		echo "</td></tr></table>";	
		$_SESSION['uidVerified']="false";	
		return;
	}
	$modifiedUserID=strtoupper($userID);
	
 	//Check if userid already exist in the database
	$cmdstr = "select USER_ID from CLIENT WHERE USER_ID = '".$modifiedUserID."'";
	$parsed = ociparse($db_conn, $cmdstr);
	ociexecute($parsed);
	$numrows = ocifetchstatement($parsed, $results);
	if ($numrows > 0)
	{
		echo "<table><tr><td>";
		echo "<font color='#FF0000'>Sorry! $userID is already taken. Please, choose a different User ID</font>";
		echo "</td></tr></table>";	
		$_SESSION['uidVerified']="false";
		return;
		
	}
	else
	{
		echo "<table><tr><td>";
		echo "<font color='#008000'>User ID Checked</font>";
 		echo "</td></tr></table>";	
 		$_SESSION['uidVerified']="true";
		$_SESSION['nUserID']=$modifiedUserID;
	}	
}

else if ($param=="AssignRight")
{
 	$CreatedBy=$_SESSION['userid'];
 	$rightID=intval($_GET["rightID"]);
 	$userID=$_SESSION['user'];
 	$token=2;

 	//echo $userID . " " . $rightID ;
 	
 	//insert all information to database
	$stmt = 'BEGIN USERMANAGEMENT_STEP2(:PARAM_ACCRIGHTID,:PARAM_CREATED_BY,:PARAM_C_ID); END;';
        $stmt = oci_parse($db_conn,$stmt);
        //  Bind the input parameter
        oci_bind_by_name($stmt,":PARAM_ACCRIGHTID",$rightID,40);
        oci_bind_by_name($stmt,":PARAM_CREATED_BY",$CreatedBy,25);
        oci_bind_by_name($stmt,":PARAM_C_ID",$userID,25);   
        $execute=oci_execute($stmt);
        
        //Check if the information is saved and show appropriate message
        if($execute)
        {
			ECHO "<font color='#008000'>Access Right Assigned</font>";		
		}
		else
		{
			ECHO "<font color='#008000'>Error! Assigning Access Right</font>";
		}
}

else if ($param=="DeleteUser")
{
 	$updatedBy=$_SESSION['userid'];
 	$userID=$_SESSION['user'];
 	
 	$stmt = 'BEGIN DELETE_USER(:PARAM_UPDATED_BY,:PARAM_USER_ID); END;';
        $stmt = oci_parse($db_conn,$stmt);
        //  Bind the input parameter
        oci_bind_by_name($stmt,":PARAM_UPDATED_BY",$updatedBy,25);
        oci_bind_by_name($stmt,":PARAM_USER_ID",$userID,25);    
        $execute=oci_execute($stmt);
        
        //Check if the information is saved and show appropriate message
        if($execute)
        {
			ECHO "<font color='#008000'>Access Right Deleted</font>";		
		}
		else
		{
			ECHO "<font color='#008000'>Error! Deleting Access Right</font>";
		}

}

else if ($param=="ReActivate")
{
 	$updatedBy=$_SESSION['userid'];
 	$userID=$_SESSION['user'];
 	
 	$stmt = 'BEGIN REACTIVATE(:PARAM_UPDATED_BY,:PARAM_USER_ID); END;';
        $stmt = oci_parse($db_conn,$stmt);
        //  Bind the input parameter
        oci_bind_by_name($stmt,":PARAM_UPDATED_BY",$updatedBy,25);
        oci_bind_by_name($stmt,":PARAM_USER_ID",$userID,25);
        $execute=oci_execute($stmt);
        
        //Check if the information is saved and show appropriate message
        if($execute)
        {
			ECHO "<font color='#008000'>User Re-Activated</font>";		
		}
		else
		{
			ECHO "<font color='#008000'>Error! Re-Activating user</font>";
		}
}

else if ($param=="ResetPassword")
{
 	$userID=$_GET["UserID"];
 	$email=$_GET["Email"]; 	
 	
	$modifiedUserID=strtoupper($userID);
	$modifiedEmail=strtoupper($email);
	
 	//Check if userid already exist in the database
	$cmdstr = "select USER_ID from CLIENT WHERE USER_ID = '".$modifiedUserID."' and EMAIL='".$modifiedEmail."'";
	$parsed = ociparse($db_conn, $cmdstr);
	ociexecute($parsed);
	$numrows = ocifetchstatement($parsed, $results);
	if ($numrows <= 0)
	{
		echo "<table><tr><td>";
		echo "<font color='#FF0000'>Invalid UserID and/or Email Address</font>";
		;; echo "<br>$userID:$modifiedUserID $email:$modifiedEmail";
		echo "</td></tr></table>";	
		$_SESSION['uidVerified']="false";
		
	}
	else
	{
	 	$temppass=generatePassword(6,8);
		//echo "<br>$temppass";
	 	$HashedTempPass=sha1($temppass);
	 	
	 	//update password
		$cmdstr = "update CLIENT set PASSWORD= '".$HashedTempPass."' WHERE USER_ID = '".$modifiedUserID."' and EMAIL='".$modifiedEmail."'";
		$parsed = ociparse($db_conn, $cmdstr);
		ociexecute($parsed);	
		
		//send temp password to the user
		$to = $email;
		$subject = 'PADMA New Password'; 
		$message = "UserID: $userID\nPassword: $temppass"; 
		$headers = "From: padma.ccny@gmail.com";
		$mail_sent = @mail($to, $subject, $message, $headers);
		//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
		echo "<font color='#008000'>";
		echo $mail_sent ? "A new password has been sent to your account" : "Error: sending mail to the account $email";
		echo "</font>";	 		
	}
}

else if ($param=="ChangePassword")
{
 	$userID=$_SESSION['userid'];
 	$pass=$_GET["Pass"]; 	
 	$newPassword=$_GET["newPass"]; 
 	
	$modifiedUserID=strtoupper($userID);
	$modifiedPass=sha1($pass);
	$modifiedNewPass=sha1($newPassword);
	
 	//Check if userid already exist in the database
	$cmdstr = "select USER_ID from CLIENT WHERE USER_ID = '".$modifiedUserID."' and PASSWORD='".$modifiedPass."'";
	$parsed = ociparse($db_conn, $cmdstr);
	ociexecute($parsed);
	$numrows = ocifetchstatement($parsed, $results);
	if ($numrows <= 0)
	{
		echo "<table><tr><td>";
		echo "<font color='#FF0000'>Invalid UserID and/or Password</font>";
		echo "</td></tr></table>";	
		$_SESSION['uidVerified']="false";
		
	}
	else
	{
	 	//update password
		$cmdstr = "update CLIENT set PASSWORD= '".$modifiedNewPass."' WHERE USER_ID = '".$modifiedUserID."' and PASSWORD='".$modifiedPass."'";
		$parsed = ociparse($db_conn, $cmdstr);
		ociexecute($parsed);	
		
		echo "<font color='#008000'>";
		echo "Password updated";
		echo "</font>";	 		
	}
}

else {
	// preferrably the logic comes here!
}

//Function that generates random password
function generatePassword($length, $strength) {
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1) {
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength & 2) {
        $vowels .= "AEUY";
    }
    if ($strength & 4) {
        $consonants .= '23456789';
    }
    if ($strength & 8) {
        $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}

function printList($param,$db_conn)
{
	$cmdstr = "select distinct $param from FULL_VIEW where RESTRICTED ='0' order by $param";
	$parsed = ociparse($db_conn, $cmdstr);
	ociexecute($parsed);
	$total = ocifetchstatement($parsed, $results);
	echo "<font size=3pt face ='tahoma'>";
    echo "<center>";
	echo "<table border=0 cellspacing='0' >\n";
	echo "<tr>\n";
	for($i=0;$i<$total;$i++)
	{		
		echo "<td> " . $results[$param][$i]. "</td>";;
		if ($i%4==1)
			echo "</tr><tr>\n";
	}
	echo "</td></table></center>";
    echo "</font>";
}

oci_close($db_conn);
?>

