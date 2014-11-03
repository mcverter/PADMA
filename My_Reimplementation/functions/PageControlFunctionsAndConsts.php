<?php

/**
 * Class PageControlFunctions
 */
class PageControlFunctionsAndConsts
{
    const PADMA_EMAIL = 'padma.ccny@gmail.com';
    const PADMA_URL = '';
    const USERID_SESSVAR = 'userid';
    const ROLE_SESSVAR = 'role';
    const PASSWORD_POSTVAR = 'password';

    const ADMINISTRATOR_ROLE = 'Administrator';
    const RESEARCHER_ROLE = 'Researcher';
    const USER_ROLE = 'GeneralUser';
    const NOTINITIALIZED_ROLE = 'NotInitialized';


    const NOTAUTHORIZED_ROLE = 'NOTAUTHORIZED';
    const SUPERVISING_ROLE = 'Supervising';
    const REGISTERED_ROLE = 'Registered';
    const NO_ROLE = '';

    const SHOW_DESCRIPTION_COMMAND = "showDescription";
    /**
     * @param $errorMsg
     */
    static function redirectDueToError($errorMsg)
    {
        require_once('../templates/ErrorPage.php');
        $errorPage = new ErrorPage($errorMsg);
        $errorPage->display_page();
    }

    static function randomPassword ($length=10) {
            return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*|"), 0, $length);
    }
    /**
     * @param $errorMsg
     */
    static function redirectDueToSuccess($successMsg)
    {
        require_once('../templates/SuccessPage.php');
        $successPage = new SuccessPage($successMsg);
        $successPage->display_page();
    }


    /**
     * @param $string
     * @return mixed
     */
    static function escape_space($string)
    {
        return str_replace(' ', '^', $string);
    }

    /**
     * @param $string
     * @return mixed
     */
    static function unescape_space($string)
    {
        return str_replace('^', ' ', $string);
    }

    /**
     *
     */
    static function initialize_session()
    {
        //  if (session_id() == "") {
        session_start();
        // }
    }

    /**
     * @param $roletype
     * @return bool
     */
    static function check_role($roletype)
    {
        if (!isset($_SESSION["role"]) &&
           $roletype !== self::NO_ROLE) {
            header("location: index.php");
            return false;
        }
        else {
            $role = $_SESSION[self::ROLE_SESSVAR];
            switch ($roletype) {
                case self::NO_ROLE:
                    if ($role ==self::ADMINISTRATOR_ROLE ||
                    $role === self::USER_ROLE ||
                    $role === self::RESEARCHER_ROLE ||
                    $role == self::NOTAUTHORIZED_ROLE){
                        header("location: index.php");
                        return false;
                    }
                    break;
                case self::ADMINISTRATOR_ROLE:
                    if ($role != self::ADMINISTRATOR_ROLE) {
                        header("location: index.php");
                        return false;
                    }
                    break;
                case self::SUPERVISING_ROLE:
                    if (($role !== self::ADMINISTRATOR_ROLE) &&
                        ($role !== self::RESEARCHER_ROLE)) {
                        header("location: index.php");
                        return false;
                    }
                    break;
                case self::REGISTERED_ROLE:
                    if  (($role !== self::ADMINISTRATOR_ROLE) &&
                        ($role !== self::RESEARCHER_ROLE) &&
                        ($role !== self::USER_ROLE)) {
                        header("location: index.php");
                        return false;
                    }
                    break;
            }
        }
        return true;
    }
}

class_alias('PageControlFunctionsAndConsts', 'pgFn');