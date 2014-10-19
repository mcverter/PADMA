<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');

/**
 * Class UploadExperimentPage
 */
class UploadExperimentPage extends DatabaseConnectionPage {


    const UPLOAD_DIR = "/var/www/html/drosoData/";
    const FILE_POSTVAR = 'experimentFile';

    protected  function isAuthorizedToViewPage() {
        return PageControlFunctions::check_role(WebPage::SUPERVISING_ROLE);
    }



    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }

    /**
     * @param $db_conn
     */
    function upload_file($db_conn)
    {
        $uploadedFileName = $_FILES[self::FILE_POSTVAR]['name'];
        if (strtolower(substr($uploadedFileName, -3, 3)) != "csv") {
            return PageControlFunctions::redirectDueToError("Invalid File Type.  Make sure ");
        }
        $destinationFileName = self::UPLOAD_DIR . $uploadedFileName;
        if (move_uploaded_file($_FILES[self::FILE_POSTVAR]['tmp_name'], $destinationFileName)) {
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
        while (($line = fgets($fileHandle)) !== false) {
            if (substr_count($line, ",") != 7) {
                return PageControlFunctions::redirectDueToError("There must be 8 columns in each line of {$destinationFileName}.  The following
             line does not: \n'{$line}'' ");
            }
            list ($prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $hour) =
                explode($line, ",");
            if (! dbFn::experimentInDB($db_conn, $exp_name)) {
                dbFn::insertIntoExpTbl($prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $userid, $date, $restricted, $hour);
                // AKIRA:  what is this?
                $recNum = count($prob_id);

                // AKIRA:  	what does this mean:	if($EXPERIMENT_ROWCOUNT==($recNum-2))
                if (dbFn::okay_to_insert_into_master($db_conn)) {
                    dbFn::insertIntoExpMasterTbl($db_conn, $exp_name, $description, $userid, $date,
                        $restricted, $recNum);
                }
            }
        }
    }

    /**
     *
     */
    function make_main_frame($title, $userid, $role) {
        $returnString = '';
        if(empty($_FILES) || ($_FILES['size'] < 1) ||
            empty($_FILES[self::FILE_POSTVAR]) || empty($_FILES[self::FILE_POSTVAR]["name"]) ||
            ! is_uploaded_file($_FILES[self::FILE_POSTVAR]["name"])) {
            $actionUrl = $_SERVER['PHP_SELF'];

            $returnString .= <<< EOT
        <form name="uploadExperimentForm" action="$actionUrl" method="POST" enctype="multipart/form-data">
            <h1>Load Experiment</h1>
EOT;
            wMk::file_input("Upload File", self::FILE_POSTVAR);
            wMk::submit_button();

            $returnString .= <<< EOT
            </form>
EOT;

        }
        else {
            $this->upload_file($this->db_conn);
        }
        return $returnString;
    }

    function get_title() {
        return "Upload Experiment";
    }
}

