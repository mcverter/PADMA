<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');

/**
 * Class UploadExperimentPage
 */
class UploadExperimentPage extends DatabaseConnectionPage {

    const PG_TITLE =  "Upload Experiment";

    const UPLOAD_DIR = "/var/www/html/drosoData/";
    const FILE_POSTVAR = 'experimentFile';

    /**
     * @return bool
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctions::check_role(WebPage::SUPERVISING_ROLE);
    }


    /**
     * @param $title
     * @param $userid
     * @param $role
     * @return string
     */
    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }

    /**
     * Assuming only one experiment per file
     * @param $db_conn
     */
    function upload_file($db_conn)
    {
        $uploadedFileName = $_FILES[self::FILE_POSTVAR]['name'];
        if (strtolower(substr($uploadedFileName, -3, 3)) != "csv") {
            return PageControlFunctions::redirectDueToError("Invalid File Type.  Make sure ");
        }
        $destinationFileName = self::UPLOAD_DIR . $uploadedFileName;
        if ((move_uploaded_file($_FILES[self::FILE_POSTVAR]['tmp_name'], $destinationFileName)) == false) {
            return PageControlFunctions::redirectDueToError("File could not be uploaded to path {$destinationFileName}. Please check with
        PADMA support");
        }
        /*  ALERT: This restriction is given in original file.  Assuming it is an error?
        if ($_POST['publish']!='T'){
            return PageControlFunctions::redirectDueToError("File is not being published.  Please try again");
        }*/
        if (!($fileHandle = fopen($destinationFileName, "rb"))) {
            return PageControlFunctions::redirectDueToError("Could not open uploaded file {$destinationFileName}.  Please report error to
        support");
        }
        $restricted = ($_POST['publish'] == 'T') ? 0 : 1;
        $date = date("m/d/y");
        $userid = $_SESSION[wPg::USERID_SESSVAR];
        $description = "Not Available";
        $count = 0;
        $line = fgets($fileHandle);
        if ($line != false) {
            list ($prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $hour) =
                explode(",", trim($line));
            if ($exp_name && !dbFn::experimentInDB($db_conn, $exp_name)) {
                while ($line != false) {
                    if (substr_count($line, ",") != 7) {
                        return PageControlFunctions::redirectDueToError("There must be 8 columns in each line of {$destinationFileName}.  The following line does not: \n'{$line}'' ");
                    }
                    list ($prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $hour) =
                        explode(",", trim($line));
                    dbFn::insertIntoExpTbl($db_conn, $prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $userid, $date, $restricted, $hour);
                    $count++;
                    $line = fgets($fileHandle);
                }
                if ($count) {
                    DBFunctions::insertIntoExpMasterTbl($db_conn, $name, $description, $userid, $date, $restricted, $count);
                }
            }
        }
    }

    /**
     *
     */
    function make_main_content($title, $userid, $role) {
        $returnString = '';
        if(((empty($_FILES) || empty($_FILES[self::FILE_POSTVAR])
                || ($_FILES[self::FILE_POSTVAR]['size'] < 1)
                || empty($_FILES[self::FILE_POSTVAR]["name"])
                ||! is_uploaded_file($_FILES[self::FILE_POSTVAR]["tmp_name"])))
            == false ) {
            $this->upload_file($this->db_conn);
            $returnString .= wMk::successMessage('uploadSuccess', 'You have successfully uploaded an experiment');
        }
        $actionUrl = $_SERVER['PHP_SELF'];

        $returnString .=

            <<< EOT
                <h1>Load Experiment</h1>
EOT

            . wMk::start_file_form($actionUrl)
            . wMk::file_input("Upload File", self::FILE_POSTVAR)
            . wMk::submit_button()
            . wMk::end_form();

        return $returnString;
    }

}

