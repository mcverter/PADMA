<?php

require_once("../templates/WebPage.php");

/**
 * This class is used to override the printing of a page
 *   when a critical error occurs.
 * Rather than outputting the normal page, this prints out
 *   a page containing nothing but the header,
 *   the error message, and the footer.
 *
 */
class ErrorPage extends WebPage {
    private $error_message;

    const PG_TITLE = 'CRITICAL ERROR';

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
     * Prints out an error message

     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */
    function make_main_content($userid, $role){
        $returnString = '';
        $returnString .= WidgetMaker::errorMessage('error', $this->error_message);
        $returnString .= "Click <a href='../webpages/index.php'> here </a> to return to the Home Page";
        return $returnString;
    }

    /**
     * Error message is initialized
     *
     * @param $msg
     */
    function __construct($msg) {
        parent::__construct();
        $this->error_message = $msg;
    }
} 