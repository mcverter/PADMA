<?php

/**
 * Class PageControlFunctions
 *
 * This class contains functions and constants that
 *    are used throughout throughout the application
 *    Rather than spreading constants throughout the various
 *    subdirectories, they are being centralized in this
 *    directory.
 *
 * The functions and constants here are those needed for
 *    non-database work.
 *
 * This class is aliased as "pgFn"
 */
class PageControlFunctionsAndConsts
{
    const PADMA_EMAIL = 'padma.ccny@gmail.com';
    const PADMA_URL = 'http://padmadatabase.org';

    // for storing userid and role across session
    const USERID_SESSVAR = 'userid';
    const ROLE_SESSVAR = 'role';

    // Possible values of $_SESSION[ROLE_SESSVAR]
    const ADMINISTRATOR_ROLE = 'Administrator';
    const RESEARCHER_ROLE = 'Researcher';
    const USER_ROLE = 'GeneralUser';
    const NOTINITIALIZED_ROLE = 'NotInitialized';


    // Used as parameters for isAuthorizedToViewPage()
    const NOTAUTHORIZED_ROLE = 'NOTAUTHORIZED';
    const SUPERVISING_ROLE = 'Supervising';
    const REGISTERED_ROLE = 'Registered';
    const NO_ROLE = '';

    // Password shared between HeaderMaker
    //   and LoginUserScript
    const PASSWORD_POSTVAR = 'password';

    // Used for file upload scripts in data_admin
    const BASE_UPLOAD_DIR = "/var/www/html/";
    const MAX_FILE_SIZE = 5000000;


    /**
     * Initializes session for each page
     */
    static function initialize_session()
    {
        if(!isset($_SESSION)) {
            session_start();
        }
    }


    /**
     * Checks to see whether User is allowed to
     *   view webpage based on Page restrictions
     *   and current user's ROLE
     *
     * @param $roletype: Type of role(s) permitted to view page
     *
     * @return bool: Whether current user is allowed to view page
     */
    static function check_role($roletype)
    {
        if (!isset($_SESSION[self::ROLE_SESSVAR]) &&
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


    /**
     * When a significant error occurs,
     *
     * Prints out a Webpage containing
     *   nothing but an Error Message
     *   and a link back to the Homepage
     *
     * @param $errorMsg string:  Message to be printed
     * @return void
     *    but display_page() takes over printing
     */
    static function redirectDueToError($errorMsg)
    {
        require_once('../templates/ErrorPage.php');
        $errorPage = new ErrorPage($errorMsg);
        $errorPage->display_page();
    }

    /**
     * When a significant success occurs,
     *
     * Prints out a Webpage containing
     *   nothing but a Success Message
     *   and a link back to the Homepage
     *
     * @param $successMsg string:  Message to be printed
     * @return void
     *    but display_page() takes over printing
     */
    static function redirectDueToSuccess($successMsg)
    {
        require_once('../templates/SuccessPage.php');
        $successPage = new SuccessPage($successMsg);
        $successPage->display_page();
    }


    /**
     * DEBUG METHOD FOR USE IN DEVELOPMENT
     * NEVER USE IN PRODUCTION
     *
     * This will cause the application to exit on a warning or notice
     *
     * Call at the top of the xxPage.php file, after
     *    require_once(WebPage.php) or require_once(DatabasePage.php)
     *    but before class definition
     */
    static function exit_on_warning_or_notice() {
        /**
         * Exists on error or warning
         *
         * @param $errNo
         * @param $errStr
         * @param $errFile
         * @param $errLine
         * @throws ErrorException
         */
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
     * This is used in user_admin for uploading files
     * It checks through various possible error conditions.
     * If it finds them, it returns null and sets the $errmsg.
     *
     * Otherwise it returns a filehandle
     *
     * Perhaps this function should be in data_admin dir?
     *
     * @param $postvar : POST parameter for file
     * @param $destdir : Destination directory
     * @param $errmsg : Error message is set and
     *     returned by reference if there is an error
     *
     * @return null|resource: returns null on error or file handle
     */
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