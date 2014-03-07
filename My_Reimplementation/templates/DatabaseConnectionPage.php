<?php
require_once("WebPage.php");
require_once(__DIR__ . "/../widgets/DB_WidgetMaker.php");

class DatabaseConnectionPage extends WebPage {
    protected $db_conn;

    abstract function __construct() {
        parent::__construct();
        $this->db_conn = connect_to_db();
    }

    function __destruct() {
        $db_conn = $this->db_conn;
        oci_close($db_conn);
    }

}

?>