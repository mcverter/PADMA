<?php
require_once("DatabaseConnectionPage.php");



class EditProfile extends DatabaseConnectionPage {
    public function __construct() {
        parent::__construct();
        $this->title = "Edit Profile";
    }
    function print_js() {
        echo <<< EOT

        <script LANGUAGE="JavaScript" type="text/javascript">
    var xmlHttp;
    function validate(form1) {
        str="Please Enter your ";
        str2="\nPlease...";
        youCount=0;
        idCount=0;
        if(""==document.forms.form1.lname.value) {
            str=str + "\n  * Last Name."
            youCount=youCount+1;
        }
        if(""==document.forms.form1.fname.value) {
            str=str + "\n  * First Name."
            youCount=youCount+1;
        }
        if(""==document.forms.form1.email.value)
        {
            str=str + "\n  * Email Address."
            youCount=youCount+1;
        }
        strstr="ERROR\n"
        if (youCount>0)
        {
            strstr=strstr+str
        }
        if(idCount>0)
        {
            strstr=strstr+str2
        }
        emailAddress=document.forms.form1.email.value
        reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
        if(reg.test(emailAddress) == false)
        {
            strstr=strstr + "\nInvalid Email Address"
        }
        if (strstr !="ERROR\n")
        {
            alert(strstr);
            return false;
        }
        return true;
    }

    function utility()
    {
        if (validate("form1") == false) return;

        xmlHttp=GetXmlHttpObject();
        if (xmlHttp==null){
            alert ("Browser does not support HTTP Request");
            return;
        }
        var url="newprofileSubmit.php";

        var params = "title=" + encodeURIComponent(document.getElementsByName("title")[0].value) + "&lname=" + encodeURIComponent(document.getElementsByName("lname")[0].value)
        + "&fname=" + encodeURIComponent(document.getElementsByName("fname")[0].value) + "&mname=" + encodeURIComponent(document.getElementsByName("mname")[0].value)
        + "&address=" + encodeURIComponent(document.getElementsByName("address")[0].value) +
        "&address2=" + encodeURIComponent(document.getElementsByName("address2")[0].value)
        + "&city=" + encodeURIComponent(document.getElementsByName("city")[0].value) + "&state=" + encodeURIComponent(document.getElementsByName("state")[0].value)
        + "&zip=" + encodeURIComponent(document.getElementsByName("zip")[0].value) + "&country=" + encodeURIComponent(document.getElementsByName("country")[0].value)
        + "&phone=" + encodeURIComponent(document.getElementsByName("phone")[0].value) + "&email=" + encodeURIComponent(document.getElementsByName("email")[0].value)
        + "&industry=" + encodeURIComponent(document.getElementsByName("industry")[0].value) + "&profession=" + encodeURIComponent(document.getElementsByName("profession")[0].value);

        try{
            xmlHttp.onreadystatechange=stateChanged;
            xmlHttp.open("POST",url,false);
            // send the propoer header information along with the request
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlHttp.setRequestHeader("Connection", "close");
            xmlHttp.send(params);
        } catch(e) {
            alert(e.toString()+" Please contact PADMA administrator");
        }

    }
    function stateChanged(){
        if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
            document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
            return;
        }
        else {
            document.getElementById("txtHint").innerHTML=
                "<font sie='+1' color='red'>ERROR:</font> inner logic never responded, contact administrator.";
        }
    }
    function GetXmlHttpObject(){
        var xmlHttp=null;
        try{
            // Firefox, Opera 8.0+, Safari
            xmlHttp=new XMLHttpRequest();
        }
        catch (e){
            //Internet Explorer
            try{
                xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e){
                xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
        return xmlHttp;
    }
</script>
EOT;
    }

    function print_content() {
        $db_conn = $this->db_conn;
        /*        if (!isset($_SESSION['userid'])) {}
                    $userid=strtoupper($_SESSION['userid']);
                    if ($userid == "undefined") {}
                        echo <<< EOT
          <font color='red'>
          <b>ERROR: undefined user ID (internal logic error), please contact PADMA administrator.</b>
          </font>
          <br /><a title='logout' href='index.php'>Click Here</a> to go back to home page
        EOT;

         */
        $userid = $_SESSION['userid'];
        $ud = DB_Entity::get_user_data($db_conn, $userid);
        $title = $ud['TITLE'];
        $fname = $ud['FNAME'];
        $lname = $ud['LNAME'];
        $mname = $ud['MNAME'];
        $address1 = $ud['ADD_1'];
        $address2 = $ud['ADD_2'];
        $city = $ud['CITY'];
        $state = $ud['STATE'];
        $zip = $ud['ZIP'];
        $country = $ud['COUNTRY'];
        $phone = $ud['PHONE'];
        $ind = $ud['IND'];
        $email = $ud['EMAIL'];
        $prof = $ud['PROF'];
        $updatedBy = $ud['UPDATED_BY'];
        $updatedOn = $ud['UPDATED_ON'];

echo <<< EOT
<fieldset>
    <h2>YOUR PROFILE</h2>

    <div class="instructions">
        <h5>Please reflect your up-to-date information to the system. This  profile data will be inspected by the PADMA system  administrator only at the selection of your account  type.
        The collected information will never be  disclosed.</h5>
    </div>

    <div>
        <h2><font color="#4682B4">Your registered user ID</font></h2>
        "{$userid}" &#8212; to change password, click <a href="PassChange.php">here</a>
</div>


<div id="txtHintX">&nbsp;</div>

<form class="central_widget" name="form1" method="post">
    <h2><font color="#4682B4">Your current profile in the system</font></h2>
    <fieldset>
        <legend>
            Last updated by {$updatedBy} on {$updatedOn}
        </legend>

        <label for="title"> Title:</label>
        <select name="title" style="width:46%">
            <option value="Mr."
EOT;
    if ($title == "MR"  || $title == "MR." || $title == "") echo " selected";


        echo <<< EOT

            >Mr.</option>
            <option value="Ms."
EOT;
        if ($title == "MS"  || $title == "MS.") echo " selected";

        echo <<< EOT
        >Ms.</option>
            <option value="Dr."
EOT;
        if ($title == "DR"  || $title == "DR.") echo " selected";

        echo <<< EOT
        >Dr.</option>
        </select>

        <label for="lname"> Last Name: </label>
        <input name="lname" type="text" value="{$lname}" style="width:90%" />

        <label for="fname"> First Name:<font color="red">*</font></label>
        <input name="fname" type="text" value="{$fname}" style="width:90%" />

        <label for="mname"> MI:</label>
        <input name="mname" type="text" value="{$mname}" style="width:90%" />

        <label for="address"> Address:</label>
        <input name="address" type="text" value="{$address1}" style="width:90%" />

        <label for="address2"> Address2:</label>
        <input name="address2" type="text" value="{$address2}" style="width:90%" />


        <label for="city"> City:</label>
        <input name="city" type="text" value="{$city}" style="width:90%" />

        <label for="state"> State:</label>
        <input name="state" type="text" value="{$state}" style="width:90%" />

        <label for="zip">Zip Code:</label>
        <input name="zip" type="text" value="{$zip}" style="width:90%" />
EOT;

        DB_Entity::make_countries_widget($db_conn, $country);

echo <<< EOT

<label for="phone"> Phone Number:</label>
<input name="phone" type="text" value="{$phone}" style="width:90%" />

<label for="email"> E-mail Address:<font color="red">*</font></label>
<input name="email" type="text" value="{$email}" style="width:90%" />

<label for="industry"> Industry:</label>
<input name="industry" type="text" value="{$ind}" style="width:90%" />

<label for="profession"> Profession:</label>
<input name="profession" type="text" value="{$prof}" style="width:90%" />

</fieldset>
<input name="btnSubmit" type="button" value="Submit" onClick="utility()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<div id="txtHint">&nbsp;</div>
</form>
</fieldset>
EOT;

}

}

$ep = new EditProfile();
$ep->display_page();
