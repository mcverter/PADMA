<?php
/**
 * Created by PhpStorm.
 * User: oracle
 * Date: 10/27/14
 * Time: 2:19 PM
 */
require_once("../templates/DatabaseConnectionPage.php");


/**
 * Class RegistrationPage
 *  This Page is used for new user registration.
 *
 *  A new user must fill out the form completely in order to
 * register as a user.  After this, her application must be reviewed
 * by the Administrator.
 *
 * Many of the fields on the form are required and subject to other verifications,
 * including insuring the existence of a unique user name
 */

class RegistrationPage extends DatabaseConnectionPage {

    const PG_TITLE = "New User Registration";

    /**
     * Checks to make sure that the Request to register came from the
     * User Agreement Page.
     */
    function check_referrer() {
        if (! isset($_SERVER['HTTP_REFERER'])) {
            return false;
        }
        $referrer_parts = parse_url($_SERVER['HTTP_REFERER']);
        if (($_SERVER['HTTP_HOST'] !== $referrer_parts['host']) ||
            (($referrer_parts['path'] !==$_SERVER['PHP_SELF']) &&
                ($referrer_parts['path'] !==
                    dirname(dirname($_SERVER['PHP_SELF'])) .
                    "/webpages/new_user_terms.php"))) {
            return false;
        }
        return true;
    }

    /**
     * Checks to make sure that the user is not already logged in as a user
     *
     * @return bool:  Whether User is allowed to see page
     */
    function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(PageControlFunctionsAndConsts::NO_ROLE);
    }

    /**
     * @Override
     *
     * Makes the main functional content block of the page
     * Displays a form for a new user to fill out.
     * The form is validated using the
     *   Parsely JS library (parsleyjs.org)
     *  (1) Many forms are "required"
     *  (2) Emails must be in a proper format
     *  (3) Several fields have minimum lengths
     *  (4) Usernames must be unique
     *
     *
     * If no post:
     *  Show change password form
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */

    function make_main_content($userid, $role)
    {
        if (!$this->check_referrer()) {
            return PageControlFunctionsAndConsts::redirectDueToError("You must agree to the terms of service before you complete the registration");
        }
        $db_conn = $this->db_conn;
        $returnString = '';
        if (isset($_POST[DBFunctionsAndConsts::PASSWORD_COL]) &&
            isset($_POST[DBFunctionsAndConsts::USER_ID_COL])) {
            DBFunctionsAndConsts::insertUserProfile(
                $db_conn,
                $_POST[DBFunctionsAndConsts::TITLE_COL],
                $_POST[DBFunctionsAndConsts::LNAME_COL],
                $_POST[DBFunctionsAndConsts::MNAME_COL],
                $_POST[DBFunctionsAndConsts::FNAME_COL],
                $_POST[DBFunctionsAndConsts::ADD_1_COL],
                $_POST[DBFunctionsAndConsts::ADD_2_COL],
                $_POST[DBFunctionsAndConsts::CITY_COL],
                $_POST[DBFunctionsAndConsts::STATE_COL],
                $_POST[DBFunctionsAndConsts::ZIP_COL],
                $_POST[DBFunctionsAndConsts::COUNTRYNAME_COL],
                $_POST[DBFunctionsAndConsts::PHONE_COL],
                $_POST[DBFunctionsAndConsts::EMAIL_COL],
                $_POST[DBFunctionsAndConsts::IND_COL],
                $_POST[DBFunctionsAndConsts::PROF_COL],
                strtoupper($_POST[DBFunctionsAndConsts::USER_ID_COL]),
                sha1($_POST[DBFunctionsAndConsts::PASSWORD_COL]),
                DBFunctionsAndConsts::now_applied());
            $returnString .= PageControlFunctionsAndConsts::redirectDueToSuccess("You have successfully registered for PADMA.  "
                . "<br >An administrator will email you when your registration is complete.");

        } else {
            $returnString .= <<< EOT
Welcome to PADMA Database. Just select an UserID and Password, answer a few simple questions.
We will send you an e-mail when your account setup is complete

EOT;

            $password_col = DBFunctionsAndConsts::PASSWORD_COL;

            $returnString .=
                WidgetMaker::start_form($_SERVER['PHP_SELF'], 'POST', 'registerForm', ' form-horizontal ', '', ' data-parsley-validate ') .
                WidgetMaker::text_input("User ID *:", DBFunctionsAndConsts::USER_ID_COL, '', '', ' data-parsley-required data-parsley-trigger="keyup" data-parsley-trigger="blur" data-parsley-trigger="change"  autocomplete=off data-parsley-remote="../user_admin/CheckUniqueUsernameAJAX.php" data-parsley-remote-message="That User ID already exists"	data-parsley-minlength="5" ') .
                WidgetMaker::password_input("Password *:", $password_col, '', " data-parsley-required autocomplete=off  data-parsley-minlength='6'	 ") .
                WidgetMaker::password_input("Confirm Password *:", 'passConfirm ', '', " data-parsley-required data-parsley-equalto='#$password_col'	 ") .
                WidgetMaker::select_input("Title *:", DBFunctionsAndConsts::TITLE_COL, DBFunctionsAndConsts::selectTitleList($db_conn), DBFunctionsAndConsts::TITLE_COL, DBFunctionsAndConsts::TITLE_COL, false, '', 3, '', 'data-parsley-required') .
                WidgetMaker::text_input("Last Name *:", DBFunctionsAndConsts::LNAME_COL, '', '', 'data-parsley-required') .
                WidgetMaker::text_input("First Name *:", DBFunctionsAndConsts::FNAME_COL, '', '', 'data-parsley-required') .
                WidgetMaker::text_input("Middle Initial (optional):", DBFunctionsAndConsts::MNAME_COL) .
                WidgetMaker::text_input("Address *:", DBFunctionsAndConsts::ADD_1_COL, '', '', ' data-parsley-required') .
                WidgetMaker::text_input("Address (optional):", DBFunctionsAndConsts::ADD_2_COL) .
                WidgetMaker::text_input("City *:", DBFunctionsAndConsts::CITY_COL, '', '', ' data-parsley-required') .
                WidgetMaker::text_input("State *:", DBFunctionsAndConsts::STATE_COL, '', '', 'data-parsley-required') .
                WidgetMaker::text_input("Zip Code *:", DBFunctionsAndConsts::ZIP_COL, '', '', " data-parsley-required data-parsley-minlength='5'	 ") .
                WidgetMaker::select_input("Country *:", DBFunctionsAndConsts::COUNTRYNAME_COL, DBFunctionsAndConsts::selectCountryList($db_conn), DBFunctionsAndConsts::COUNTRYID_COL, DBFunctionsAndConsts::COUNTRYNAME_COL, false, '', 5, '', ' data-parsley-required ') .
                WidgetMaker::text_input("Phone Number *:", DBFunctionsAndConsts::PHONE_COL, '', '', 'data-parsley-required') .
                WidgetMaker::text_input("EMail Address *:", DBFunctionsAndConsts::EMAIL_COL, '', '', " data-parsley-required data-parsley-type='email'	") .
                WidgetMaker::text_input("Industry *:", DBFunctionsAndConsts::IND_COL, '', '', 'data-parsley-required') .
                WidgetMaker::text_input("Profession *:", DBFunctionsAndConsts::PROF_COL, '', '', 'data-parsley-required') .
                WidgetMaker::submit_button("submit", "Register New User") .
                WidgetMaker::end_form();
        }
        return $returnString;
    }

    /**
     * @param $userid
     * @param $role
     * @return string
     */
    function make_page_middle($userid, $role) {
        return $this->make_image_content_columns ($userid, $role, 'O', 8) ;
    }

    /**
     *
     */
    function make_js() {
        $userid = DBFunctionsAndConsts::USER_ID_COL;
        return parent::make_js() .
        <<< EOT

        <script src="../js/parsley.remote.js"></script>`
        <script src="../js/parsley.js"></script>
        <script>
        $(document).ready(function(event) {
           $('#$userid').focus();
        });
        </script>


EOT;
    }
}


