<div id="header">
    <div id="banner">
        <img alt="ccny" src="images/ccnylogo2.png"/>
        <img id="headertext" alt="Welcome to Padma!" src='images/headertext.png' />
    </div>
    <ul class="menu">
        <li><a href="index.php" title="PADMA Home Page">Home</a></li>
        <li><a href="Search.php" title="Quick Search"> Search </a></li>
        <li><a href="ListofExperiment.php" title="Experiment List"> Experiment List </a></li>
        <?php
        if (session_id() == "") session_start();

        $role = isset($_SESSION['role']) ? $_SESSION['role'] : "";

        if($role == "Administrator")
        {
            echo <<<EOT
     <li><a href="newprofile.php" title="Profile Management">Update Profile</a></li>
     <li><a href="usermanagement.php" title="User Management">User Setup</a></li>
     <li><a href="DataManagement.php" title="Data Management">Data Management</a></li>
     <li><a href="logout.php" title="Logout">Log Out</a></li>
EOT;
        }
        else if ($role =="Researcher")
        {
            echo <<<EOT
     <li><a href="newprofile.php" title="Profile Management">Update Profile</a></li>
     <li><a href="DataManagement.php" title="Data Management">Data Management</a></li>
     <li><a href="logout.php" title="Logout">Log Out</a></li>

EOT;

        }
        else if ($role=="GeneralUser")
        {
            echo <<<EOT
     <li><a href="newprofile.php" title="Profile Management">Update Profile</a></li>
     <li><a href="logout.php" title="Logout">Log Out</a></li>

EOT;

        }
        else if ($role=="NOTAUTHORIZED")
        {
            echo <<<EOT
	<li><a href="login.php" title="Log In">Log In</a></li>

EOT;
        }

        else  {
            echo <<<EOT
	<li><a href="login.php" title="Log In">Log In</a></li>

EOT;
        }
        ?>
    </ul>
</div>

