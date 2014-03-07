<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class LogInPage extends DatabaseConnectionPage {

    function __construct() {
        parent::__construct();
        $this->title = "Log In";
    }
    function print_content() {
        $db_conn = $this->db_conn;

        if (isset($_POST['userid']) &&
            isset($_POST['Password1'])) {

            $userid = $_POST['userid'];
            $password=$_POST['Password1'];
            $role="";

            // hash the password
            $hashedPassword = sha1($password);
            $modifiedUserID=strtoupper($userid);

            //insert all information to database
            $stmt = 'BEGIN LOGIN(:PARAM_USERNAME,:PARAM_PASSWORD,:PARAM_ROLE); END;';
            $stmt = oci_parse($db_conn,$stmt);
            //  Bind the input parameter
            oci_bind_by_name($stmt,":PARAM_USERNAME",$modifiedUserID,15);
            oci_bind_by_name($stmt,":PARAM_PASSWORD",$hashedPassword,250);
            oci_bind_by_name($stmt,":PARAM_ROLE",$role,30);

            $execute=oci_execute($stmt);

            $_SESSION['role']=$role;
            $_SESSION['userid']=$modifiedUserID;

            if ($role=="GeneralUser") {
                header('Location: UserMain.php');
            }
            else if ($role=="Administrator") {
                header('Location: AdminMain.php');
            }
            else if ($role == "Researcher") {
                header('Location: ResearcherMain.php');
            }
            else {
                header( 'Location: index.php' ) ;
            }

        }

        echo <<< EOT
    <form  action="login.php" method="post">
	<h2> Log in </h2> 
	<hr>
       <fieldset>
	    <label for="userid"> User ID </label>
          <input name="userid" type="text" />
	    <label for="Password1"> Password:</label>
          <input name="Password1" type="PASSWORD"  />
	</fieldset>
   
          <input type="submit"  value="Login" />
    </form>
	  
    <div>
      <a title="passwordrecovery" href="PassRecovery.php">Forgot Password</a> 
      <br>
      <a title="newuser" href="terms.php">New User</a>
    </div>
EOT;
    }
}

?>
 
