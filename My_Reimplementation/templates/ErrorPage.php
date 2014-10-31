<?php
/**
 * Created by PhpStorm.
 * User: oracle
 * Date: 10/29/14
 * Time: 12:59 PM
 */

require_once("../templates/WebPage.php");

class ErrorPage extends WebPage {
    private $error_message;

    const PG_TITLE = 'CRITICAL ERROR';

    function make_page_middle($userid, $role){
        return $this->make_image_content_columns ($userid, $role, 'N', 8) ;
    }
    function make_main_content($userid, $role){
        $returnString = '';
        $returnString .= WidgetMaker::errorMessage('error', $this->error_message);
        $returnString .= "Click <a href='../webpages/index.php'> here </a> to return to the Home Page";
        return $returnString;
    }
    function __construct($msg) {
        parent::__construct();
        $this->error_message = $msg;
    }
} 