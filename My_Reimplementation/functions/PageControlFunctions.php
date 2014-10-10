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
        $role = $_SESSION['role'];
        if (!isset($_SESSION["role"])) {
            header("location: index.php");
        } else {
            $role = $_SESSION['role'];

            error_log("Role is " . $role);


            if ($roletype == 'a') {
                if ($role != "Administrator") {
                    header("location: index.php");
                }
            } else if ($roletype == 'ar') {
                if (($role != "Researcher") && ($role != 'Administrator')) {
                    header("location: index.php");
                }
            } else if ($roletype == 'r') {
                if ($role != "Researcher") {
                    header("location: index.php");
                }
            } else if ($roletype == 'any') {
                if (empty($role)) {
                    header("location: index.php");
                }
            }
        }
    }


}
