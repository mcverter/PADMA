<?php

/**
 * Class PageControlFunctions
 */
class PageControlFunctionsAndConsts
{
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
    
    /**
     * @param $errorMsg
     */
    static function redirectDueToError($errorMsg)
    {

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
        if (!isset($_SESSION["role"])) {
            header("location: index.php");
            return false;
        }
        else {
            $role = $_SESSION[self::ROLE_SESSVAR];
            switch ($roletype) {
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