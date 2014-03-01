<?php

function initialize_session() {
    if (session_id() == "") session_start();
}

function connect_to_db() {
    $db_UN=$_SESSION['un'];
    $db_PASS=$_SESSION['pass'];
    $db_DB=$_SESSION['db'];

    set_time_limit(6000);
    $db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
    if (! $db_conn)
    {
        db_conn_failure( oci_error() );
    }
    return $db_conn;
}

function db_conn_failure($err) {
    $error_message = htmlentities($err['message']);
    echo <<<EOT
      echo "<font color='red'>";
      $error_message
    <br>ERROR: Connecting to Database, Please try back later<br>;
    <a title='logout' href='index.php'>Click Here</a> to go back to home page
EOT;
    exit;

}

function check_role($roletype)
{
    if (! isset($_SESSION["role"]))
    {
        header("location: index.php");
    }

    $role=$_SESSION['role'];

    if ($roletype=='a') {
        if($role !="Administrator")  {
            header("location: index.php");
        }
    }
    else if ($roletype=='ar') {
        if(($role !="Researcher") && ($role != 'Administrator')) {
            header("location: index.php");
        }
    }

    else if ($roletype=='r') {
        if($role !="Researcher")  {
            header("location: index.php");
        }
    }

    else if ($roletype=='any') {
        if(empty($role))  {
            header("location: index.php");
        }
    }
}




?>