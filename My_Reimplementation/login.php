<?php
require_once("DatabaseConnectionPage.php");

class LogIn extends DatabaseConnectionPage {

    function __construct() {
        parent::__construct();
        $this->title = "Log In";
    }
    function print_content() {

    echo <<< EOT
    <form class="central_widget" action="checkLogin.php" method="post">
	<h2> Log in </h2> 
	<hr>
        <fieldset>
	  <label for="userid"> User ID </label>
          <input name="userid" type="text" style="width:90%" />                             
	  <label for="Password1"> Password:</label>
          <input name="Password1" type="PASSWORD" style="width:90%" />          
	</fieldset>
   
          <input type="submit" style="width:65;height:65"  value="Login" />
    </form>
	  
    <div>
      <a title="passwordrecovery" href="PassRecovery.php">Forgot Password</a> 
      <br>
      <a title="newuser" href="terms.php">New User</a>
    </div>
EOT;
    }
}

$lp = new LogIn();
$lp->display_page();
 
 
 
 
 
