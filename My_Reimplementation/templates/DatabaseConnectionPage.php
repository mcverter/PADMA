<?php
require_once("../templates/WebPage.php");
require_once("../functions/DBFunctionsAndConsts.php");

/**
 * Class DatabaseConnectionPage
 */
abstract class DatabaseConnectionPage extends WebPage {
    protected $db_conn;

    const DB_USER = "drosophilarc2";
    const DB_PASS = "drosopivot";
    const DB_DATABASE = "//127.0.0.1/ORATIKI";

    /**
     *
     */
    function __construct()
    {
        parent::__construct();
        if ($this->db_conn == null) {
            $this->db_conn = dbFn::connect_to_db();
        }
    }

    function display_page() {
        if ($this->db_conn) {
            parent::display_page();
        }
    }
    /**
     *
     */
    function __destruct() {
        $db_conn = $this->db_conn;
        oci_close($db_conn);
    }
}

