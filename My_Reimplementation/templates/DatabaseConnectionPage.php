<?php
require_once("../templates/WebPage.php");
require_once("../functions_and_consts/DBFunctionsAndConsts.php");

/**
 * Class DatabaseConnectionPage
 *
 * This is the base class for all Pages which
 *   require a Database Connection
 */
abstract class DatabaseConnectionPage extends WebPage {
    protected $db_conn;

    /**
     * Database Connection is initialized in constructor
     */
    function __construct()
    {
        parent::__construct();
        if ($this->db_conn == null) {
            $this->db_conn = DBFunctionsAndConsts::connect_to_db();
        }
    }

    /**
     * Existence of DB Connection is checked previous to display
     */
    function display_page() {
        if ($this->db_conn) {
            parent::display_page();
        }
    }
    /**
     * DB Connection is closed on page destruction.
     */
    function __destruct() {
        $db_conn = $this->db_conn;
        oci_close($db_conn);
    }
}

