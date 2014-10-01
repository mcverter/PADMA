<?php
require_once (__DIR__ . "/../templates/DatabaseConnectionPage.php");

class DeleteReferencePage {
    const VERSION_LABEL = "Version to Delete";
    const VERSION_SELECT_NAME = "Version";
    const VERSION_KEYVAL = "VERSION";
    const VERSION_POSTVAR = "version";

    function make_version_select()
    {
        WidgetMaker::form_select(
            self::VERSION_LABEL,
            self::VERSION_SELECT_NAME,
            $this->showReferenceList(),
            self::VERSION_KEYVAL,
            false);
    }

    function showReferenceList() {
        db_selectVersionList();
    }
    function exec_delete_reference($version) {
        deleteReference($version);
    }
    function make_submit_button()
    {
        WidgetMaker::submit_button('deleteBtn', 'Delete', '');
    }

    function __construct() {check_role('a');
        parent::__construct();
        $this->title = " Delete Reference ";
    }
    function print_content() {
        $db_conn = $this->db_conn;

        if (isset ($_POST[self::VERSION_POSTVAR]) &&
            !empty ($_POST[self::VERSION_POSTVAR])
        ) {
            $versionPost = $_POST[self::VERSION_POSTVAR];
            $this->exec_delete_reference($versionPost);
            echo <<< EOT
            <h2> Version $versionPost has been deleted </h2>
EOT;
        }

        $actionUrl = $_SERVER['PHP_SELF'];

        echo <<< EOT

	<h2> Select a Version to delete)</h2>
	<br>

     <form name="deleteVersion" action="$actionUrl" method="post">

EOT;
        $this->make_version_select();

        $this->make_submit_button();


        echo<<< EOT
        </form>
EOT;

    }

}