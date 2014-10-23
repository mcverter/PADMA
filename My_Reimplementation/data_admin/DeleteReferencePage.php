<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

/**
 * Class DeleteReferencePage
 */
class DeleteReferencePage extends DatabaseConnectionPage {
    const VERSION_LABEL = "Version to Delete";
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
EOT
   . WidgetMaker::start_form($actionUrl)
    .      wMk::select_input(
                self::VERSION_LABEL,
                self::VERSION_POSTVAR,
                dbFn::selectVersionList($db_conn),
                self::VERSION_KEYVAL,
                self::VERSION_KEYVAL,
                false) .

            wMk::submit_button('deleteBtn', 'Delete', '')
            . WidgetMaker::end_form();

        return $returnString;
    }
}