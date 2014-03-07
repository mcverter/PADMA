<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");



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
                    if ($userid == "undefined") {}
                        echo <<< EOT
          <font color='red'>
          <b>ERROR: undefined user ID (internal logic error), please contact PADMA administrator.</b>
          </font>
          <br /><a title='logout' href='index.php'>Click Here</a> to go back to home page
        EOT;

         */

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

DB_Entity::make_user_info_panel($db_conn);
<div id="txtHintX">&nbsp;</div>
<input name="btnSubmit" type="button" value="Submit" onClick="utility()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<div id="txtHint">&nbsp;</div>
</form>
</fieldset>
EOT;

}

}

$ep = new EditProfile();
$ep->display_page();
