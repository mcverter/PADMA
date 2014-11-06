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


    const BASE_UPLOAD_DIR = "/var/www/html/";

    const MAX_FILE_SIZE = 5000000;

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
        if(!isset($_SESSION)) {
            session_start();
        }
    }

    static function exit_on_warning() {
        function errHandle($errNo, $errStr, $errFile, $errLine) {
            $msg = "$errStr in $errFile on line $errLine";
            if ($errNo == E_NOTICE || $errNo == E_WARNING) {
                throw new ErrorException($msg, $errNo);
            } else {
                echo $msg;
            }
        }
        set_error_handler('errHandle');
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
            if (isset($_SESSION[self::ROLE_SESSVAR])) {
                $role = $_SESSION[self::ROLE_SESSVAR];
            }
            else $role = '';
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

    static function openUploadedCSVFile($postvar, $destdir, &$errmsg) {
        $posted_file = $_FILES[$postvar];

        if($posted_file['error'] > 0){
            $errmsg = 'An error ocurred when uploading.';
            return null;
        }

        $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
        if(! in_array($posted_file['type'],$mimes)){
            $errmsg = 'Uploaded file must be in CSV format';
            return null;
        }
        if (strtolower(substr($posted_file['name'], -3, 3)) != "csv") {
            $errmsg = 'Uploaded file must be in CSV format';
            return null;
        }
        if($posted_file['size'] < 1){
            $errmsg = 'Emty file';
            return null;
        }

        if($posted_file['size'] > self::MAX_FILE_SIZE){
            $errmsg = 'File uploaded exceeds maximum upload size of ' . self::MAX_FILE_SIZE . ' bytes';
            return null;
        }


        $destinationFileName = $destdir . $posted_file['name'];

        if(file_exists($destinationFileName)){
            $errmsg = 'File with that name already exists.';
            return null;
        }
        if(!move_uploaded_file($posted_file['tmp_name'], $destinationFileName)){
            $errmsg = "File could not be uploaded to path {$destinationFileName}. Please check with PADMA support";
            return null;
        }
        if (!($filehandle = fopen($destinationFileName, "rb"))) {
            $errmsg = "Could not open uploaded file {$destinationFileName}.  Please report error to support";
            return null;
        } else {
            return $filehandle;
        }
    }
}

class_alias('PageControlFunctionsAndConsts', 'pgFn');