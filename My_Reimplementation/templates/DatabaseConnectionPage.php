<?php
require_once("WebPage.php");
require_once("DB_Entity.php");

class DatabaseConnectionPage extends WebPage {
    protected $db_conn;

    function __construct() {
        parent::__construct();
        $this->db_conn = connect_to_db();
    }

    function __destruct() {
        $db_conn = $this->db_conn;
        oci_close($db_conn);
    }

}

?>