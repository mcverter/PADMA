<?php
/**
 * Created by PhpStorm.
 * User: oracle
 * Date: 10/29/14
 * Time: 12:59 PM
 */

require_once("../templates/WebPage.php");

class SuccessPage extends WebPage {
    private $success_message;

    const PG_TITLE = 'CRITICAL ERROR';

    function make_page_middle($userid, $role){
        return $this->make_image_content_columns ($userid, $role, 'N', 8) ;
    }
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