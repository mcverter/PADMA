<?php



function setDBVars() {
    //create connection string variable
    $db_UN = "drosophilarc2";         //username
    $db_PASS= "drosopivot";           //password
    $db_DB= "//127.0.0.1/ORATIKI";    //database name

    //save connection string variable to session
    $_SESSION['un']=$db_UN;
    $_SESSION['pass']=$db_PASS;
    $_SESSION['db']=$db_DB;
}




function endUserSession() {
  $_SESSION['role']="NOTAUTHORIZED";
  unset($_SESSION['userid']);
}
?>