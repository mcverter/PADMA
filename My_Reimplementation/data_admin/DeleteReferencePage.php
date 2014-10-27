<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

/**
 * Class DeleteReferencePage
 */
class DeleteReferencePage extends DatabaseConnectionPage {

    const PG_TITLE  = "Delete Reference";

    const VERSION_LABEL = "Version to Delete";
    const VERSION_POSTVAR = "version";

    /**
 * @Override
 * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */

    function make_page_middle($userid, $role){
        return $this->make_image_content_columns ($userid, $role, 'R', 8) ;
    }

    /**
     * @Override
     * Shows the main functional content block of the page
     *
     * Shows a list of Reference Versions which may be deleted
     * If VERSION_POSTVAR is set, that version is deleted
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_main_content($userid, $role) {
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
            . wMk::start_form($actionUrl)
            .      wMk::select_input(
                self::VERSION_LABEL,
                self::VERSION_POSTVAR,
                dbFn::selectVersionList($db_conn),
                dbFn::VERSION_COL,
                dbFn::VERSION_COL,
                false) .

            wMk::submit_button('deleteBtn', 'Delete', '')
            . wMk::end_form();

        return $returnString;
    }
}