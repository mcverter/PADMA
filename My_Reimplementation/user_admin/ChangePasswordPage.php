<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');

/**
 * Class ChangePasswordPage
 */
class ChangePasswordPage extends DatabaseConnectionPage
{
    const PG_TITLE = "Change Password";

    /**
     * @Override
     *
     * Only a Registered User may change their Password
     *
     * @return bool
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(pgFn::REGISTERED_ROLE);
    }

    /**
     * @Override
     *
     * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */

    function make_page_middle($userid, $role){
        return $this->make_image_content_columns ($userid, $role, 'R', 8) ;
    }

    /**
     * @param $password
     */
    function checkPasswordMatch($password)
    {
        dbFn::selectUserByIDAndPW($this->db_conn,
            strtoupper($this->userid), sha1($password));
    }

    /**
     * @param $userid
     * @param $role
     * @return string
     */
    function make_main_content($userid, $role) {
        $userid = $this->userid;
        $db_conn = $this->db_conn;

        $returnString = '';

        if ($_POST['submitted']) {
            $newpass = $_POST['newpass'];
            dbFn::updateUserPassword($db_conn, strtoupper($userid), sha1($newpass));
        }
        else {
            $actionUrl = $_SERVER['PHP_SELF'];
            $returnString .= "User Id : $userid" .
                wMk::start_form($actionUrl, 'gform') .
                wMk::text_input('Old Password', 'oldpass', '') .
                wMk::text_input('New Password', 'newpass', '', 'password') .
                wMk::text_input('Confirm Password', 'confirmpass', '', 'confirmpass') .
                wMk::end_form();
        }
        return $returnString;
    }
}
