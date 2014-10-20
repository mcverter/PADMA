<?php
class PageControlFunctions
{

    static function redirectDueToError($errorMsg)
    {

    }

    static function initialize_session()
    {
        //  if (session_id() == "") {
        session_start();
        // }
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
        if (!isset($_SESSION["role"])) {
            header("location: index.php");
            return false;
        }
        else {
            $role = $_SESSION[wPg::ROLE_SESSVAR];
            switch ($roletype) {
                case WebPage::ADMINISTRATOR_ROLE:
                    if ($role != WebPage::ADMINISTRATOR_ROLE) {
                        header("location: index.php");
                        return false;
                    }
                    break;
                case WebPage::SUPERVISING_ROLE:
                    if (($role !== WebPage::ADMINISTRATOR_ROLE) &&
                        ($role !== WebPage::RESEARCHER_ROLE)) {
                        header("location: index.php");
                        return false;
                    }
                    break;
                case WebPage::REGISTERED_ROLE:
                    if  (($role !== WebPage::ADMINISTRATOR_ROLE) &&
                        ($role !== WebPage::RESEARCHER_ROLE) &&
                        ($role !== WebPage::USER_ROLE)) {
                        header("location: index.php");
                        return false;
                    }
                    break;
            }
        }
        return true;
    }
}
