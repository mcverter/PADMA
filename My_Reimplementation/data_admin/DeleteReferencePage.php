<?php
require_once("../templates/DatabaseConnectionPage.php");

/**
 * Class DeleteReferencePage
 *
 * Creates a page for Adminsitrators to delete Reference Versions
 */
class DeleteReferencePage extends DatabaseConnectionPage {

    const PG_TITLE  = "Delete Reference";


    /**
     * Only Administrators are allowed to Delete Versions
     *
     * @return bool:  Whether user is allowed to view page
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(PageControlFunctionsAndConsts::ADMINISTRATOR_ROLE);
    }

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
        return $this->make_image_content_columns ($userid, $role, 'L', 4) ;
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
        if (isset ($_POST[DBFunctionsAndConsts::VERSION_COL]) &&
            !empty ($_POST[DBFunctionsAndConsts::VERSION_COL])
        ) {
            $versionPost = $_POST[DBFunctionsAndConsts::VERSION_COL];
            dbFn::deleteReference($db_conn, $versionPost);
            $returnString .= wMk::successMessage('success',
                "Version $versionPost has been deleted");
        }

        $returnString .= <<< EOT

	<h2> Select a Version to delete</h2>
EOT
            . wMk::start_form($_SERVER['PHP_SELF'])
            . wMk::select_input(
                "Version",
                DBFunctionsAndConsts::VERSION_COL,
                dbFn::selectVersionList($db_conn),
                dbFn::VERSION_COL,
                dbFn::VERSION_COL,
                false) .

            wMk::submit_button('deleteBtn', 'Delete', '')
            . wMk::end_form();

        return $returnString;
    }
}