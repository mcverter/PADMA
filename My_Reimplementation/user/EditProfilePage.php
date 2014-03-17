<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");



class EditProfilePage extends DatabaseConnectionPage {
    public function __construct() {
        parent::__construct();
        $this->title = "Edit Profile";
    }


    function print_content() {

        if (!isset($_SESSION['userid']) ||
            (empty ($_SESSION['userid']))) {
           header("Location :  index.php");
        }
        $userid = $_SESSION['userid'];
        $db_conn = $this->db_conn;

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
        <input name="btnSubmit" type="button" value="Submit" onClick="utility()"/>&nbsp;&nbsp;&nbsp;&nbsp;
EOT;

}

}

?>