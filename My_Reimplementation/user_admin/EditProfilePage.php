<?php

require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

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

    protected  function isAuthorizedToViewPage() {
        return PageControlFunctions::check_role(WebPage::REGISTERED_ROLE);
    }


    function make_page_middle($title, $userid, $role){
    return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
      }
    function get_title() {
        return "Edit Profile";
    }

    function make_main_content($title, $userid, $role) {

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
            $updated_on = dbFn::now();
            dbFn::updateUserProfile($db_conn, $title, $lname, $fname, $mname,
                $address1, $address2, $city, $state, $zip, $country,
                $phone, $email, $industry, $profession, $userid);
        }
        else {
            list($title, $fname, $lname, $mname,
                $address1, $address2, $city, $state, $zip, $country,
                $phone, $email, $industry, $profession, $updated_by, $updated_on) =
                oci_fetch_array(dbFn::selectProfileInfoByUserID($db_conn, $userid));
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
            wMk::start_form($formAction, 'POST', 'verifyForm') .
            wMk::hidden_input('submitted', 'submitted') .
            wMk::select_input('Title', 'title', dbFn::selectTitleList($db_conn),
                'TITLE','TITLE', false, $title, '') .
            wMk::text_input('Last Name', self::LNAME_POSTVAR,  $lname, '') .
            wMk::text_input('First Name', self::FNAME_POSTVAR,  $fname, '') .
            wMk::text_input('Middle Initial', self::MNAME_POSTVAR,  $mname, '') .
            wMk::text_input('Address:', self::ADDRESS1_POSTVAR,  $address1, '') .
            wMk::text_input('Address 2:', self::ADDRESS2_POSTVAR,  $address2, '') .
            wMk::text_input('City:', self::CITY_POSTVAR,  $city, '') .
            wMk::text_input('State:', self::STATE_POSTVAR,  $state, '') .
            wMk::text_input('Zip Code:', self::ZIP_POSTVAR,  $zip, '') .
            wMk::select_input('Country', self::COUNTRY_POSTVAR,
                dbFn::selectCountryList($db_conn), 'COUNTRY', 'COUNTRY',
                false, $country, '') .
            wMk::text_input('Phone Number', self::PHONE_POSTVAR,  $phone, '') .
            wMk::text_input('Email', self::EMAIL_POSTVAR,  $email, '') .
            wMk::text_input('Industry', self::INDUSTRY_POSTVAR,  $industry, '') .
            wMk::text_input('Profession', self::PROFESSION_POSTVAR,  $profession, '') .
        wMk::submit_button('submit', 'Update Profile');
        return $returnString;
    }
}