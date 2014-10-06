<?php
require_once (__DIR__ . "/../page_templates/DatabaseConnectionPage.php");

/**
 * Class DeleteReferencePage
 */
class DeleteReferencePage extends DatabaseConnectionPage {
    const VERSION_LABEL = "Version to Delete";
    const VERSION_SELECT_NAME = "Version";
    const VERSION_KEYVAL = "VERSION";
    const VERSION_POSTVAR = "version";

    /**
     *
     */
    function showReferenceList() {
        DBFunctions::selectVersionList();
    }


    /**
     *
     */
    function make_submit_button()
    {
    }

    /**
     *
     */
    function __construct() {
        PageControlFunctions::check_role('a');
        parent::__construct();
        $this->title = " Delete Reference ";
    }

    /**
     *
     */
    function print_content() {
        $db_conn = $this->db_conn;

        if (isset ($_POST[self::VERSION_POSTVAR]) &&
            !empty ($_POST[self::VERSION_POSTVAR])
        ) {
            $versionPost = $_POST[self::VERSION_POSTVAR];
            DBFunctions::deleteReference($db_conn, $versionPost);
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
        echo
        WidgetMaker::select_input(
            self::VERSION_LABEL,
            self::VERSION_SELECT_NAME,
            DBFunctions::selectVersionList($db_conn),
            self::VERSION_KEYVAL,
            false) .

        WidgetMaker::submit_button('deleteBtn', 'Delete', '');


        echo<<< EOT
        </form>
EOT;

    }
}