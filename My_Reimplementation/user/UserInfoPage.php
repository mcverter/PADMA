<?php

require_once (__DIR__ . "/../DatabaseConnectionPage.php");

class GetUserInfoPage extends DatabaseConnectionPage {
    function __construct() {
    }
    function print_content() {

        $q=$_GET["q"];

//store USER id into a session variable
        $_SESSION['user']=$q;

//get user information from database
//$str = "select * from client WHERE c_id = '".$q."'";
        $str ="SELECT CLIENT.*, ACCESS_RIGHT.ACC_RIGHT_DESC as RIGHT FROM CLIENT INNER JOIN ACCESS_RIGHT ON CLIENT.ACC_RIGHT_ID = ACCESS_RIGHT.ACC_RIGHT_ID WHERE CLIENT.c_id = '".$q."'";
        $parsed = ociparse($db_conn, $str);
        ociexecute($parsed);
        $numrows = ocifetchstatement($parsed, $results);

        $Title= $results["TITLE"][0];
        $Lname= $results["LNAME"][0];
        $Fname= $results["FNAME"][0];
        $Mname= $results["MNAME"][0];
        $Address1=$results["ADD_1"][0];
        $Address2=$results["ADD_2"][0];
        $City=$results["CITY"][0];
        $State=$results["STATE"][0];
        $Zip=$results["ZIP"][0];
        $Country=$results["COUNTRY"][0];
        $Phone=$results["PHONE"][0];
        $Email=$results["EMAIL"][0];
        $Ind=$results["IND"][0];
        $Profession=$results["PROF"][0];

        echo <<<EOT
        <table class='_95small_pad'>
	<tr>
        <td class='_50r'>&nbsp;<br />
        	Title:&nbsp;&nbsp;
        </td>
        <td class='_50L'>&nbsp;<br />
        	 <b>  strtoupper([0])  </b>                                                                                                                                     </td>
    </tr>
    <tr>
        <td class='_50r'>
        Last Name:&nbsp;&nbsp;
    	</td>
    	<td class='_50L'>
            <b>  strtoupper($results["LNAME"][0])  </b>
        </td>
    </tr>
    <tr>
    	<td class='_50r'>
        First Name:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["FNAME"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        MI:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["MNAME"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        User ID:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b><div id='got_userid'> strtoupper($results["USER_ID"][0])  </div></b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        Adress:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b>  strtoupper($results["ADD_1"][0]) </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        Adress2:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["ADD_2"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        City:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["CITY"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        State:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["STATE"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        Zip:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["ZIP"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        Country:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["COUNTRY"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        Phone:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["PHONE"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        E-Mail:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b><div id='got_email'> strtoupper($results["EMAIL"][0])  </div></b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        Agency/Company:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["IND"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        Profession:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["PROF"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        Access Right:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper($results["RIGHT"][0])  </b>
        </td>
    </tr>
	<tr>
    	<td class='_50r'>
        Delete Flag:&nbsp;&nbsp;
        </td>
        <td class='_50L'>
            <b> strtoupper(($results["DEL_FLAG"][0] == "1"? "0 - inactive user" : "1 - active user"))  </b>
        </td>
    </tr>
EOT;
}
}





 
 
 
 
