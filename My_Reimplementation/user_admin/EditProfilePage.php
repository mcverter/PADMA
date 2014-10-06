<?php

require_once(__DIR__ . "/../page_templates/DatabaseConnectionPage.php");

class EditProfilePage extends DatabaseConnectionPage {
    const TITLE_POSTVAR = 'title';
    const LNAME_POSTVAR = 'lname';
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
        if ($_POST['submitted']) {
            list($title, $lname, $fname, $mname,
                $address1, $address2, $city, $state, $zip, $country,
                $phone, $email, $industry, $profession) =
               [$_POST[self::TITLE_POSTVAR], $_POST[self::LNAME_POSTVAR],
                   $_POST[self::MNAME_POSTVAR], $_POST[self::ADDRESS1_POSTVAR],
                   $_POST[self::ADDRESS2_POSTVAR], $_POST[self::CITY_POSTVAR],
                   $_POST[self::STATE_POSTVAR], $_POST[self::ZIP_POSTVAR],
                   $_POST[self::COUNTRY_POSTVAR], $_POST[self::PHONE_POSTVAR],
                   $_POST[self::EMAIL_POSTVAR], $_POST[self::INDUSTRY_POSTVAR],
                   $_POST[self::PROFESSION_POSTVAR] ] ;

            $updated_by = $this->userid;
            $updated_on = DBFunctions::now();
            DBFunctions::updateUserProfile($title, $lname, $fname, $mname,
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
            "<input type='hidden' name='submitted'".
            "<p> Last updated by $updated_by  on $updated_on </p>" .
            "<hr>\n" .
            WidgetMaker::start_form('', '', 'verifyForm') .
            WidgetMaker::select_input('Title', 'title', DBFunctions::selectTitleList($db_conn), 'TITLE', false, $title,
                '') .
            WidgetMaker::text_input('Last Name', 'lname',  $lname, '') .
            WidgetMaker::text_input('First Name', 'fname',  $fname, '') .
            WidgetMaker::text_input('Middle Initial', 'mname',  $mname, '') .
            WidgetMaker::text_input('Address:', 'address1',  $address1, '') .
            WidgetMaker::text_input('Address 2:', 'address2',  $address2, '') .
            WidgetMaker::text_input('City:', 'city',  $city, '') .
            WidgetMaker::text_input('State:', 'state',  $state, '') .
            WidgetMaker::text_input('Zip Code:', 'zip',  $zip, '') .
            WidgetMaker::select_input('Country', 'country', DBFunctions::selectCountryList($db_conn), 'COUNTRY', false,
                $country, '') .
            WidgetMaker::text_input('Phone Number', 'phone',  $phone, '') .
            WidgetMaker::text_input('Email', 'email',  $email, '') .
            WidgetMaker::text_input('Industry', 'industry',  $industry, '') .
            WidgetMaker::text_input('Profession', 'profession',  $profession, '') ;
    }

    function __construct() {
        parent::__construct();

    }
} 