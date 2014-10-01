<?php

$userid = strtoupper($userID);
$password = sha1($password);
$newpass = sha1($newpass);

class ChangePasswordPage
{

    function checkPasswordMatch()
    {
        selectUserByIDAndPW($userid, $password);
    }

    function exec_update_password()
    {
        update_password($userid, $newpass)
    }

}
