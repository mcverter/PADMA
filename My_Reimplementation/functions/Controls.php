<?php


function initialize_session() {
    session_start();
}

function escape_space($string) {
    return str_replace(' ', '^', $string);
}

function unescape_space($string) {
    return str_replace('^', ' ', $string);
}

function connect_to_db() {
    $db_UN = "drosophilarc2";
    $db_PASS= "drosopivot";
    $db_DB= "//127.0.0.1/ORATIKI";

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
    $role=$_SESSION['role'];
    if (! isset($_SESSION["role"]))
    {
        header("location: index.php");
    }

    else {
        $role=$_SESSION['role'];

        error_log("Role is " . $role);


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
}




?>