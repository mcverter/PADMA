<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');


class ChangePasswordPage extends DatabaseConnectionPage
{

    protected  function isAuthorizedToViewPage() {
        return PageControlFunctions::check_role(WebPage::REGISTERED_ROLE);
    }


  function make_page_middle($title, $userid, $role){
    return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
      }
    function checkPasswordMatch($password)
    {
        dbFn::selectUserByIDAndPW($this->db_conn,
            strtoupper($this->userid), sha1($password));
    }

    function make_main_content($title, $userid, $role) {
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
    function get_title() {
        return "Change Password";
    }

}
