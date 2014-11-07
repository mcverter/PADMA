<?php

require_once('../templates/DatabaseConnectionPage.php');

/**
 * Class UploadReferencePage
 *
 * This is used to upload new Reference Versions to the Database
 */
class UploadReferencePage extends DatabaseConnectionPage {

    const PG_TITLE =  "Upload Version";

    const FILE_POSTVAR = 'referenceFile';
    const UPLOAD_SUBDIR =  "drosoReference/";
    /**
     * Only Administrators are allowed to Upload Versions
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
    function make_page_middle($userid, $role) {
        return $this->make_image_content_columns ($userid, $role, 'R', 4) ;
    }


    /**
     *
     * Processes each line of the uploaded file and
     *   inserts its contents into the database in
     *   REFERENCE_MAIN, REFERENCE_GO, & REFERENCE_BIO
     */
    function upload_file()
    {
        $db_conn = $this->db_conn;
        $version = $_POST['version'];
        if (DBFunctionsAndConsts::isVersionInDB($db_conn, $version)) {
            return PageControlFunctionsAndConsts::redirectDueToError(
                "Version already exists in the database");
        }

        $errmsg = '';
        if (($filehandle = PageControlFunctionsAndConsts::openUploadedCSVFile(
                self::FILE_POSTVAR,
                PageControlFunctionsAndConsts::BASE_UPLOAD_DIR . self::UPLOAD_SUBDIR,
                $errmsg)) == null) {
            return PageControlFunctionsAndConsts::redirectDueToError($errmsg);
        }

        $userid = $_SESSION[PageControlFunctionsAndConsts::USERID_SESSVAR];
        $date=date("m/d/y");

        // first line is header
        fgets($filehandle);

        while (($line = fgets($filehandle)) !== false) {
            if (substr_count($line, ",") < 4) {
                return PageControlFunctionsAndConsts::redirectDueToError("There must be 5 columns in each line of the uploaded file.  The following line does not:\n'{$line}'' ");
            }
            $line = trim($line);
            $line = str_replace("\"", '', $line);
            $line = str_replace("'", '', $line);
            $commaIdxEnd = strpos($line, ",");
            $probeid = substr($line, 0, $commaIdxEnd);
            $commaIdxStart = $commaIdxEnd+1;
            $commaIdxEnd = strpos($line, ",", $commaIdxStart);
            $cgname = substr($line, $commaIdxStart, $commaIdxEnd-$commaIdxStart);
            $commaIdxStart = $commaIdxEnd+1;
            $commaIdxEnd = strpos($line, ",", $commaIdxStart);
            $genename = substr($line, $commaIdxStart, $commaIdxEnd-$commaIdxStart);
            $commaIdxStart = $commaIdxEnd+1;
            $commaIdxEnd = strpos($line, ",", $commaIdxStart);
            $flybasenum = substr($line, $commaIdxStart, $commaIdxEnd-$commaIdxStart);
            $commaIdxStart = $commaIdxEnd+1;
            $godata = substr($line, $commaIdxStart, strlen($line) -$commaIdxStart);

            DBFunctionsAndConsts::insertReference($db_conn, $probeid, $cgname, $genename, $flybasenum, $version, $userid, $date);

            // if godata not empty
            if (preg_match("/\d/", $godata)) {
                $godata = str_replace("\"", "", $godata);
                foreach (explode("///", $godata) as $goentry) {
                    $gospecification = explode("//", $goentry);
                    $gonumber = array_shift($gospecification);
                    DBFunctionsAndConsts::insertReferenceGo($db_conn, $probeid, $gonumber, $version, $userid, $date);
                    foreach ($gospecification as $description) {
                        DBFunctionsAndConsts::insertReferenceBio($db_conn, $gonumber, $description, $version, $userid, $date);
                    }
                }
            }
        }
    }


    /**
     * @Override
     * Shows the main functional content block of the page
     * Shows an File Input widget allowing user to upload File.
     * If $_FILES is set, the input file will be processed
     * and a success message will be displayed
     * If any error occurs, an error message will be displayed upon the page.
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
    function make_main_content($userid, $role) {
        $returnString = '';

        // Probably redundant
        if(((empty($_FILES) || empty($_FILES[self::FILE_POSTVAR])
                || ($_FILES[self::FILE_POSTVAR]['size'] < 1)
                || empty($_FILES[self::FILE_POSTVAR]["name"])
                ||! is_uploaded_file($_FILES[self::FILE_POSTVAR]["tmp_name"])))
            == false ) {
            $this->upload_file();
            $returnString .= WidgetMaker::successMessage('uploadSuccess', 'You have successfully uploaded an Version');
        }

        $returnString .=
            WidgetMaker::start_file_form($_SERVER['PHP_SELF'], 'POST', 'uploadForm', 'form-horizontal', ' data-parsley-validate ') .
            WidgetMaker::text_input('Version Number', 'version', '', '', " data-parsley-required" ) .
            WidgetMaker::file_input("           ", self::FILE_POSTVAR, '', " data-parsley-required") .
            WidgetMaker::submit_button() .
            WidgetMaker::end_form();
        return $returnString;
    }
}


