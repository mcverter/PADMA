<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/17/14
 * Time: 11:30 AM
 */

class FormMaker {
static function make_create_profile_form($db_conn) {
    //obtain this user's profile
    $cmdName = "select title,fname,lname,mname,add_1,add_2,city,state,zip,country,phone,email,ind,prof,updated_by,updated_on from client where user_id = '".$userid."'";
    $parsed = ociparse($db_conn, $cmdName);
    ociexecute($parsed);
    $result = oci_fetch_array($parsed, OCI_ASSOC+OCI_RETURN_NULLS);
    if ($result == null) {
        echo "<font color='red'>";
        echo "<b>ERROR: invalid user ID (internal logic error), please contact PADMA administrator.</b>";
        echo "</font>";
        echo "<br /><a title='logout' href='index.php'>Click Here</a> to go back to home page";
        oci_free_statement($parsed);
        exit;
    }
    $Title= strtoupper($result["TITLE"]);
    $Lname= $result["LNAME"];
    $Fname= $result["FNAME"];
    $Mname= $result["MNAME"];
    $Address1=$result["ADD_1"];
    $Address2=$result["ADD_2"];
    $City=$result["CITY"];
    $State=$result["STATE"];
    $Zip=$result["ZIP"];
    $Country=$result["COUNTRY"];
    $Phone=$result["PHONE"];
    $Email=$result["EMAIL"];
    $Ind=$result["IND"];
    $Profession=$result["PROF"];
    $UpdatedBy=$result["UPDATED_BY"];
    $UpdatedOn=$result["UPDATED_ON"];
    oci_free_statement($parsed);

    echo<<<EOT
    //include the header page
    include("header.php");
    ?>

    <fieldset>
      <h2>YOUR PROFILE</h2>

      <div class="instructions">
	<h5>Please reflect your up-to-date information to the system. This  profile data will be inspected by the PADMA system  administrator only at the selection of your account  type. The collected information will never be  disclosed.</h5>
      </div>

      <div>
	<h2><font color="#4682B4">Your registered user ID</font></h2>
	<?php echo "\"$userid\""; ?> &#8212; to change password, click <a href="PassChange.php">here</a>
      </div>


      <div id="txtHintX">&nbsp;</div>

      <form class="central_widget" name="form1" method="post">
	<h2><font color="#4682B4">Your current profile in the system</font></h2>
	<fieldset>
	  <legend>
	    Last updated by <?php echo $UpdatedBy; ?> on <?php echo $UpdatedOn; ?>
	  </legend>

	  <label for="title"> Title:</label>
	  <select name="title" style="width:46%">
	    <option value="Mr." <?php if ($Title == "MR"  || $Title == "MR." || $Title == "") echo " selected" ?>>Mr.</option>
	      <option value="Ms." <?php if ($Title == "MS.") echo " selected" ?>>Ms.</option>
		<option value="Dr." <?php if ($Title == "DR.") echo " selected" ?>>Dr.</option>
	  </select>

	  <label for="lname"> Last Name: </label>
	  <input name="lname" type="text" value=<?php echo "\"$Lname\""; ?> style="width:90%" />

	  <label for="fname"> First Name:<font color="red">*</font></label>
	  <input name="fname" type="text" value=<?php echo "\"$Fname\""; ?> style="width:90%" />

	  <label for="mname"> MI:</label>
	  <input name="mname" type="text" value=<?php echo "\"$Mname\""; ?> style="width:90%" />

	  <label for="address"> Address:</label>
	  <input name="address" type="text" value=<?php echo "\"$Address1\""; ?> style="width:90%" />

	  <label for="address2"> Address2:</label>
	  <input name="address2" type="text" value=<?php echo "\"$Address2\""; ?> style="width:90%" />


	  <label for="city"> City:</label>
	  <input name="city" type="text" value=<?php echo "\"$City\""; ?> style="width:90%" />

	  <label for="state"> State:</label>
	  <input name="state" type="text" value=<?php echo "\"$State\""; ?> style="width:90%" />

	  <label for="zip">Zip Code:</label>
	  <input name="zip" type="text" value=<?php echo "\"$Zip\""; ?> style="width:90%" />

	  <label for="country">Country:</label>
	  <select name="country" style="width:92%">
EOT;
    $cmdCountry = "select country,countryid from country order by countryid";
    $parsed = ociparse($db_conn, $cmdCountry);
    ociexecute($parsed);
    $totalCountry = ocifetchstatement($parsed, $results);

    for ($i=0 ; $i < $totalCountry; $i++) {
        echo "<option value=" . $results["COUNTRYID"][$i] . ($Country == $results["COUNTRY"][$i]? " selected":"") . ">" . $results["COUNTRY"][$i] . "</option>";
    }
    oci_free_statement($parsed);
    echo <<< EOT
	  </select>

	  <label for="phone"> Phone Number:</label>
	  <input name="phone" type="text" value=<?php echo "\"$Phone\""; ?> style="width:90%" />

	  <label for="email"> E-mail Address:<font color="red">*</font></label>
	  <input name="email" type="text" value=<?php echo "\"$Email\""; ?> style="width:90%" />

	  <label for="industry"> Industry:</label>
	  <input name="industry" type="text" value=<?php echo "\"$Ind\""; ?> style="width:90%" />

	  <label for="profession"> Profession:</label>
	  <input name="profession" type="text" value=<?php echo "\"$Profession\""; ?> style="width:90%" />

	</fieldset>
	<input name="btnSubmit" type="button" value="Submit" onClick="utility()"/>&nbsp;&nbsp;&nbsp;&nbsp;
	<div id="txtHint">&nbsp;</div>
      </form>
    </fieldset>
    <?php
    //close database connection
    oci_close($db_conn);
    //include the header page
    include("footer.php");
    ?>
  </body>
</html>




EOT;

}


    static function make_new_user_form($db_conn)
{
    echo <<< EOT

    <h2>NEW USER</h2>
	<h5>Welcome to PADMA Database. Just select an UserID and Password, answer a few simple questions. We will <u>send you a e-mail</u> when your account setup is complete</h5>
	<form name="form2" method="post">
	  <p>1. Select a non-existing User ID</p>
User ID:
	  <input name="userid" type="text" style="width:90%" />
	</form>
	<button style="width:65;height:65" onClick="utility('verifyUserName')"><b>Check</b></button>
	<div id="txtHint"></div>
	<form name="form1" action="newuserSubmit.php" method="post" onsubmit="return validate(form1);">
	  <b>2. Select your initial password</b>
Password:
	  <input name="password" type="password" style="width:90%" />
	  Re-Type Password:
	  <input name="password2" type="password" style="width:90%" />
	  3. Please tell us about you</font></b><p></p>
Your Title:
	  <select name="title" style="width:46%">
	    <option>Mr.</option>
	    <option>Ms.</option>
	    <option>Dr.</option>
	  </select>
Last Name:
	  <input name="lname" type="text" style="width:90%" />
	  First Name:
	  <input name="fname" type="text" style="width:90%" />
	  MI:&nbsp;&nbsp;
	  <input name="MI" type="text" style="width:90%" />
	  Address:&nbsp;&nbsp;
	  <input name="address" type="text" style="width:90%" />
	  Address2:&nbsp;&nbsp;
	  <input name="address2" type="text" style="width:90%" />
	  City:&nbsp;&nbsp;
	  <input name="city" type="text" style="width:90%" />
	  State:&nbsp;&nbsp;
	  <input name="state" type="text" style="width:90%" />
	  Zip Code:&nbsp;&nbsp;
	  <input name="zip" type="text" style="width:90%" />
	  Country:&nbsp;&nbsp;
	  <select name='Country' style='width:92%'>
EOT;

       read_all_countries($db_conn);

    echo<<< EOT


	  </select>
	  Phone Number:&nbsp;&nbsp;
	  <input name="phone" type="text" style="width:90%" />
	  E-mail Address:<font color="red">*</font>&nbsp;&nbsp;
	  <input name="email" type="text" style="width:90%" />
	  Industry:&nbsp;&nbsp;
	  <input name="industry" type="text" style="width:90%" />
	  Profession:&nbsp;&nbsp;
	  <input name="profession" type="text" style="width:90%" />
      </fieldset>

      <input name="btnSubmit" type="submit" value="Submit" />&nbsp;&nbsp;&nbsp;&nbsp;
	</form>
EOT;

}
} 