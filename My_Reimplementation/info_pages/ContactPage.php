<?php
require_once("../templates/WebPage.php");

/**
 * Class ContactPage
 */
class ContactPage extends WebPage {
    const PG_TITLE = "Contact Us";

    const NAME_POSTVAR = 'name';
    const EMAIL_POSTVAR = 'email';
    const SUBJECT_POSTVAR = 'subj';
    const MESSAGE_POSTVAR = 'msg';

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
        return $this->make_image_content_columns ($userid, $role, 'R', 8) ;
    }


    /**
     * @param $userid
     * @param $role
     * @return string
     */
    public function make_main_content($userid, $role)
    {
        $actionUrl = $_SERVER['PHP_SELF'];
        $returnString = '';
        if (!empty($_POST)) {
            $from_header =  'From: ' . $_POST[self::NAME_POSTVAR] . '<' . $_POST[self::EMAIL_POSTVAR] . '>\r\n';
            mail(PageControlFunctionsAndConsts::PADMA_EMAIL, $_POST[self::SUBJECT_POSTVAR], $_POST[self::MESSAGE_POSTVAR], $from_header);
            $returnString .= WidgetMaker::successMessage('success', 'Your message has been sent to the Padma Administrators!');
        } else {
            $returnString .= <<< EOT

        Please send us your comments we will get back to you shortly

EOT;

            $returnString .= WidgetMaker::start_form($actionUrl, 'POST', 'mailForm', ' form-horizontal ', '', ' data-parsley-validate ' )
                . WidgetMaker::text_input('Name', self::NAME_POSTVAR, '', '', ' data-parsley-required ')
                . WidgetMaker::text_input('Email', self::EMAIL_POSTVAR, '', '',  " data-parsley-required data-parsley-type='email'	")
                . WidgetMaker::text_input('Subject', self::SUBJECT_POSTVAR, '', '', ' data-parsley-required ')
                . WidgetMaker::text_area('Message', self::MESSAGE_POSTVAR, '', 50, 10, '', ' data-parsley-required ')
                . WidgetMaker::submit_button('submit', 'Send Email')
                . WidgetMaker::end_form();
        }
        return $returnString;

    }
}

















