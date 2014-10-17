<?php
class PageControlFunctions
{

    static function redirectDueToError($errorMsg)
    {

    }

    static function initialize_session()
    {
        if (session_id() == "") {
            session_start();
        }
    }

    static function escape_space($string)
    {
        return str_replace(' ', '^', $string);
    }

    static function unescape_space($string)
    {
        return str_replace('^', ' ', $string);
    }

    static function check_role($roletype)
    {
        $role = $_SESSION[wPg::ROLE_SESSVAR];
        if (!isset($_SESSION["role"])) {
            header("location: oniondex.php");
        } else {
            $role = $_SESSION[wPg::ROLE_SESSVAR];

            error_log("Role is " . $role);


            if ($roletype == 'a') {
                if ($role != "Administrator") {
                    header("location: oniondex.php");
                }
            } else if ($roletype == 'ar') {
                if (($role != "Researcher") && ($role != wPg::ADMINISTRATOR_ROLE)) {
                    header("location: oniondex.php");
                }
            } else if ($roletype == 'r') {
                if ($role != "Researcher") {
                    header("location: oniondex.php");
                }
            } else if ($roletype == 'any') {
                if (empty($role)) {
                    header("location: oniondex.php");
                }
            }
        }
    }


}
