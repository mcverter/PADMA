<?php

require_once("../templates/DatabaseConnectionPage.php");

/**
 * Class EditProfilePage
 *
 * This page allows A User to Edit her profile information
 */
class EditProfilePage extends DatabaseConnectionPage {

    const PG_TITLE = "Edit Profile";

    /**
     * Displays editable Profile Information with SUBMIT button
     * If the page has already been submitted, a Databaase update is executed.
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for main Content
     */
    function make_main_content($userid, $role) {

        $db_conn = $this->db_conn;
        $userid = $this->userid;
        if (!empty($_POST)) {
            list($title, $lname, $fname, $mname,
                $address1, $address2, $city, $state, $zip, $country,
                $phone, $email, $industry, $profession) =
                array( $_POST[DBFunctionsAndConsts::TITLE_COL],
                    $_POST[DBFunctionsAndConsts::LNAME_COL],
                    $_POST[DBFunctionsAndConsts::FNAME_COL],
                    $_POST[DBFunctionsAndConsts::MNAME_COL],
                    $_POST[DBFunctionsAndConsts::ADD_1_COL],
                    $_POST[DBFunctionsAndConsts::ADD_2_COL],
                    $_POST[DBFunctionsAndConsts::CITY_COL],
                    $_POST[DBFunctionsAndConsts::STATE_COL],
                    $_POST[DBFunctionsAndConsts::ZIP_COL],
                    $_POST[DBFunctionsAndConsts::COUNTRYID_COL],
                    $_POST[DBFunctionsAndConsts::PHONE_COL],
                    $_POST[DBFunctionsAndConsts::EMAIL_COL],
                    $_POST[DBFunctionsAndConsts::IND_COL],
                    $_POST[DBFunctionsAndConsts::PROF_COL] ) ;

            $updated_by = $this->userid;
            $updated_on = dbFn::now();
            dbFn::updateUserProfile($db_conn, $title, $lname, $fname, $mname,
                $address1, $address2, $city, $state, $zip, $country,
                $phone, $email, $industry, $profession, $userid);
        }
        else {
            list($title, $fname, $lname, $mname,
                $address1, $address2, $city, $state, $zip, $country,
                $phone, $email, $industry, $profession, $updated_by, $updated_on) =
                oci_fetch_assoc(dbFn::selectProfileInfoByUserID($db_conn, $userid));
        }
        $returnString = <<< EOT
    <h2> Profile Information </h2>
    <h4>Please enter your current information in the form below.
    This data will be reviewed by a PADMA administrator to determine
    your access credentials.  The collected information will never be
	      disclosed to a third party.</h4>
	      <hr>
	      <h3> You are currently logged in as </h3>
	      <h4> {$userid} </h4>
	      <hr>
	      <p> Please click <a href=""> here </a> to change your password </p>
	      <hr>

EOT;
        $formAction = $_SERVER['PHP_SELF'];

        $returnString .= "<h2> Your current profile </h2> \n" .
            "<p> Last updated by $updated_by  on $updated_on </p>" .
            "<hr>\n" .
            wMk::start_form($formAction, 'POST', 'verifyForm', ' form-horizontal ', '', ' data-parsley-validate ') .
            wMk::select_input('Title', DBFunctionsAndConsts::TITLE_COL,
                dbFn::selectTitleList($db_conn),
                dbFn::TITLE_COL, dbFn::TITLE_COL, false, $title, 5, '', ' data-parsley-required ') .
            wMk::text_input('Last Name', DBFunctionsAndConsts::LNAME_COL,  $lname, '', '', ' data-parsley-required ') .
            wMk::text_input('First Name', DBFunctionsAndConsts::FNAME_COL,  $fname,'', '', ' data-parsley-required ') .
            wMk::text_input('Middle Initial', DBFunctionsAndConsts::MNAME_COL,  $mname, '', '', ' data-parsley-required ') .
            wMk::text_input('Address:', DBFunctionsAndConsts::ADD_1_COL,  $address1, '', '', ' data-parsley-required ') .
            wMk::text_input('Address 2:', DBFunctionsAndConsts::ADD_2_COL,  $address2, '', '', ' data-parsley-required ') .
            wMk::text_input('City:', DBFunctionsAndConsts::CITY_COL,  $city, '', '', ' data-parsley-required ') .
            wMk::text_input('State:', DBFunctionsAndConsts::STATE_COL,  $state, '', '', ' data-parsley-required ') .
            wMk::text_input('Zip Code:', DBFunctionsAndConsts::ZIP_COL,  $zip, '', '', ' data-parsley-required ') .
            wMk::select_input('Country',
                DBFunctionsAndConsts::COUNTRYID_COL,
                dbFn::selectCountryList($db_conn),
                DBFunctionsAndConsts::COUNTRYID_COL,
                DBFunctionsAndConsts::COUNTRYNAME_COL,
                false,
                $country,
                '',5, '', ' data-parsley-required ') .
            wMk::text_input('Phone Number', DBFunctionsAndConsts::PHONE_COL,  $phone, '', '', ' data-parsley-required ') .
            wMk::text_input('Email', DBFunctionsAndConsts::EMAIL_COL,  $email, '', '', ' data-parsley-required ') .
            wMk::text_input('Industry', DBFunctionsAndConsts::IND_COL,  $industry, '', '', ' data-parsley-required ') .
            wMk::text_input('Profession', DBFunctionsAndConsts::PROF_COL,  $profession, '', '', ' data-parsley-required ') .
            wMk::submit_button('submit', 'Update Profile');
        return $returnString;
    }

    /**
     * Checks to make sure Registered User is accessing page
     *
     * @return bool: Whether user has rights to view page
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(pgFn::REGISTERED_ROLE);
    }

    /**
     * @Override
     * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_page_middle($userid, $role){
        return $this->make_image_content_columns ($userid, $role, 'N', 8) ;
    }


}