<?php

/**
 * This class is used to override the printing of a page
 *   when a significant success occurs.
 * Rather than outputting the normal page, this prints out
 *   a page containing nothing but the header,
 *   the success message, and the footer.
 *
 */
require_once("../templates/WebPage.php");

class SuccessPage extends WebPage {
    private $success_message;

    const PG_TITLE = 'SUCCESS!';

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
        return $this->make_image_content_columns ($userid, $role, 'N', 8) ;
    }

    /**
     * @Override
     *
     * Makes the main functional content block of the page
     *
     * Prints out a success message

     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */
    function make_main_content($userid, $role){
        $returnString = '';
        $returnString .= WidgetMaker::successMessage('success', $this->success_message);
        $returnString .= "Click <a href='../webpages/index.php'> here </a> to return to the Home Page";
        return $returnString;
    }

    function __construct($msg) {
        parent::__construct();
        $this->success_message = $msg;
    }
} 