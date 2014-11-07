<?php

require_once('../templates/DatabaseConnectionPage.php');

/**
 * Class ChangePasswordPage
 */
class ChangePasswordPage extends DatabaseConnectionPage
{
    const PG_TITLE = "Change Password";
    const OLD_PASS_POSTVAR = 'oldpass';
    const NEW_PASS_POSTVAR = 'newpass';

    /**
     * @Override
     *
     * Makes the main functional content block of the page
     * If there is a post:
     * If the old password does not match, redirect to Error Page
     * Otherwise, change the password and redirect to Success Page
     *
     * If no post:
     *  Show change password form
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */
    function make_main_content($userid, $role) {
        $userid = $this->userid;
        $db_conn = $this->db_conn;

        $returnString = '';

        if (!empty($_POST) && !empty($_POST[self::OLD_PASS_POSTVAR]) && !empty($_POST[self::NEW_PASS_POSTVAR])) {

            if (! DBFunctionsAndConsts::isUserInDB_ByIDAndPW($db_conn, $userid, $_POST[self::OLD_PASS_POSTVAR])) {
                PageControlFunctionsAndConsts::redirectDueToError("The User ID and Password did not match.  Could not update password");
            }
            else {
                DBFunctionsAndConsts::updatePasswordByUserID($db_conn, $userid, $_POST[self::NEW_PASS_POSTVAR]);
                 PageControlFunctionsAndConsts::redirectDueToSuccess("Password successfully updated.");
            }
        }
        else {
            $returnString .= "User Id : $userid" .
                WidgetMaker::start_form($_SERVER['PHP_SELF'], 'POST', 'changePassForm',  ' form-horizontal ', '', ' data-parsley-validate ') .
                WidgetMaker::text_input('Old Password', self::OLD_PASS_POSTVAR, '', '', ' data-parsley-required ') .
                WidgetMaker::text_input('New Password', self::NEW_PASS_POSTVAR, '', '', ' data-parsley-required ') .
                WidgetMaker::text_input('Confirm Password', 'confirm' . self::NEW_PASS_POSTVAR, '', '', ' data-parsley-required data-parsley-equalto="#' . self::NEW_PASS_POSTVAR .'" ') .
                WidgetMaker::end_form();
        }
        return $returnString;
    }


    /**
     * @Override
     *
     * Only a Registered User may change their Password
     *
     * @return bool: Whether user is authroized
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(PageControlFunctionsAndConsts::REGISTERED_ROLE);
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
        return $this->make_image_content_columns ($userid, $role, 'R', 4) ;
    }

}
