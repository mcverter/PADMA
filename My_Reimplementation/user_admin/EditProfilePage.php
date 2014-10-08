<?php

require_once(__DIR__ . "/../page_templates/DatabaseConnectionPage.php");

class EditProfilePage extends DatabaseConnectionPage {
    const TITLE_POSTVAR = 'title';
    const LNAME_POSTVAR = 'lname';
    const FNAME_POSTVAR = 'fname';
    const MNAME_POSTVAR = 'mname';
    const ADDRESS1_POSTVAR = 'address1';
    const ADDRESS2_POSTVAR = 'address2';
    const CITY_POSTVAR = 'city';
    const STATE_POSTVAR = 'state';
    const ZIP_POSTVAR = 'zip';
    const COUNTRY_POSTVAR = 'country';
    const PHONE_POSTVAR = 'phone';
    const EMAIL_POSTVAR = 'email';
    const INDUSTRY_POSTVAR = 'industry';
    const PROFESSION_POSTVAR = 'profession';

    function print_content() {

        $db_conn = $this->db_conn;
        $userid = $this->userid;
        if (isset ($_POST['submitted']) &&
            ($_POST['submitted']) === 'submitted') {
            list($title, $lname, $fname, $mname,
                $address1, $address2, $city, $state, $zip, $country,
                $phone, $email, $industry, $profession) =
               array( $_POST[self::TITLE_POSTVAR], $_POST[self::LNAME_POSTVAR],
                   $_POST[self::FNAME_POSTVAR], $_POST[self::MNAME_POSTVAR],
                   $_POST[self::ADDRESS1_POSTVAR],
                   $_POST[self::ADDRESS2_POSTVAR], $_POST[self::CITY_POSTVAR],
                   $_POST[self::STATE_POSTVAR], $_POST[self::ZIP_POSTVAR],
                   $_POST[self::COUNTRY_POSTVAR], $_POST[self::PHONE_POSTVAR],
                   $_POST[self::EMAIL_POSTVAR], $_POST[self::INDUSTRY_POSTVAR],
                   $_POST[self::PROFESSION_POSTVAR] ) ;

            $updated_by = $this->userid;
            $updated_on = DBFunctions::now();
            DBFunctions::updateUserProfile($db_conn, $title, $lname, $fname, $mname,
                $address1, $address2, $city, $state, $zip, $country,
                $phone, $email, $industry, $profession, $userid);
        }
        else {
            list($title, $fname, $lname, $mname,
                $address1, $address2, $city, $state, $zip, $country,
                $phone, $email, $industry, $profession, $updated_by, $updated_on) =
                oci_fetch_array(DBFunctions::selectProfileInfo($db_conn, $userid));
        }
        echo <<< EOT
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

        echo "<h2> Your current profile </h2> \n" .
            "<p> Last updated by $updated_by  on $updated_on </p>" .
            "<hr>\n" .
            WidgetMaker::start_form($formAction, 'POST', 'verifyForm') .
            WidgetMaker::hidden_input('submitted', 'submitted') .
            WidgetMaker::select_input('Title', 'title', DBFunctions::selectTitleList($db_conn), 'TITLE', false, $title,
                '') .
            WidgetMaker::text_input('Last Name', self::LNAME_POSTVAR,  $lname, '') .
            WidgetMaker::text_input('First Name', self::FNAME_POSTVAR,  $fname, '') .
            WidgetMaker::text_input('Middle Initial', self::MNAME_POSTVAR,  $mname, '') .
            WidgetMaker::text_input('Address:', self::ADDRESS1_POSTVAR,  $address1, '') .
            WidgetMaker::text_input('Address 2:', self::ADDRESS2_POSTVAR,  $address2, '') .
            WidgetMaker::text_input('City:', self::CITY_POSTVAR,  $city, '') .
            WidgetMaker::text_input('State:', self::STATE_POSTVAR,  $state, '') .
            WidgetMaker::text_input('Zip Code:', self::ZIP_POSTVAR,  $zip, '') .
            WidgetMaker::select_input('Country', self::COUNTRY_POSTVAR, DBFunctions::selectCountryList($db_conn), 'COUNTRY', false,
                $country, '') .
            WidgetMaker::text_input('Phone Number', self::PHONE_POSTVAR,  $phone, '') .
            WidgetMaker::text_input('Email', self::EMAIL_POSTVAR,  $email, '') .
            WidgetMaker::text_input('Industry', self::INDUSTRY_POSTVAR,  $industry, '') .
            WidgetMaker::text_input('Profession', self::PROFESSION_POSTVAR,  $profession, '') .
        WidgetMaker::submit_button('submit', 'Update Profile');
    }

    function __construct() {
        parent::__construct();

    }
} 