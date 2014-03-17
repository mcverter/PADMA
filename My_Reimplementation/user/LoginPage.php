<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class LogInPage extends DatabaseConnectionPage {

    function __construct() {
        parent::__construct();
        $this->title = "Log In";
    }
    function print_content() {
        $db_conn = $this->db_conn;
        $role = read_login_user($db_conn);

            if ($role=="GeneralUser") {
                header('Location: user_main.php');
            }
            else if ($role=="Administrator") {
                header('Location: admin_main.php');
            }
            else if ($role == "Researcher") {
                header('Location: researcher_main.php');
            }
            else {
                header( 'Location: index.php' ) ;
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
 
