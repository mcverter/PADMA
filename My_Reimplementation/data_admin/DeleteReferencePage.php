<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

/**
 * Class DeleteReferencePage
 */
class DeleteReferencePage extends DatabaseConnectionPage {
    const VERSION_LABEL = "Version to Delete";
    const VERSION_SELECT_NAME = "Version";
    const VERSION_KEYVAL = "VERSION";
    const VERSION_POSTVAR = "version";


    function get_title() {
        return "Delete Reference";
    }

    function make_page_middle($title, $userid, $role){
    return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
      }
    /**
     *
     */
    function showReferenceList() {
        dbFn::selectVersionList();
    }


    /**
     *
     */
    function make_submit_button()
    {
    }

\
    /**
     *
     */
    function make_main_content($title, $userid, $role) {
        $db_conn = $this->db_conn;

        $returnString = '';
        if (isset ($_POST[self::VERSION_POSTVAR]) &&
            !empty ($_POST[self::VERSION_POSTVAR])
        ) {
            $versionPost = $_POST[self::VERSION_POSTVAR];
            dbFn::deleteReference($db_conn, $versionPost);
            $returnString .= <<< EOT
            <h2> Version $versionPost has been deleted </h2>
EOT;
        }

        $actionUrl = $_SERVER['PHP_SELF'];

        $returnString .= <<< EOT

	<h2> Select a Version to delete)</h2>
	<br>

     <form name="deleteVersion" action="$actionUrl" method="post">

EOT;
        $returnString .=
        wMk::select_input(
            self::VERSION_LABEL,
            self::VERSION_SELECT_NAME,
            dbFn::selectVersionList($db_conn),
            self::VERSION_KEYVAL,
            self::VERSION_KEYVAL,
            false) .

        wMk::submit_button('deleteBtn', 'Delete', '');


        $returnString .= <<< EOT
        </form>
EOT;

        return $returnString;
    }
}