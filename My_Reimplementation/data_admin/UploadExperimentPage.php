<?php

require_once(__DIR__ . '/../page_templates/DatabaseConnectionPage.php');

/**
 * Class UploadExperimentPage
 */
class UploadExperimentPage extends DatabaseConnectionPage {


    const UPLOAD_DIR = "/var/www/html/drosoData/";
    const FILE_POSTVAR = 'experimentFile';

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
        $userid = $_SESSION['userid'];
        $description = "Not Available";
        while (($line = fgets($fileHandle)) !== false) {
            if (substr_count($line, ",") != 7) {
                return PageControlFunctions::redirectDueToError("There must be 8 columns in each line of {$destinationFileName}.  The following
             line does not: \n'{$line}'' ");
            }
            list ($prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $hour) =
                explode($line, ",");
            if (! DBFunctions::experimentInDB($db_conn, $exp_name)) {
                DBFunctions::insertIntoExpTbl($prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $userid, $date, $restricted, $hour);
                // AKIRA:  what is this?
                $recNum = count($prob_id);

                // AKIRA:  	what does this mean:	if($EXPERIMENT_ROWCOUNT==($recNum-2))
                if (DBFunctions::okay_to_insert_into_master($db_conn)) {
                    DBFunctions::insertIntoExpMasterTbl($db_conn, $exp_name, $description, $userid, $date,
                        $restricted, $recNum);
                }
            }
        }
    }

    /**
     *
     */
    function __construct()
    {
        $_SESSION['role'] = 'Administrator';
        PageControlFunctions::check_role('ar');
        parent::__construct();
    }

    /**
     *
     */
    function print_content() {
        if(empty($_FILES) || ($_FILES['size'] < 1) ||
            empty($_FILES[self::FILE_POSTVAR]) || empty($_FILES[self::FILE_POSTVAR]["name"]) ||
            ! is_uploaded_file($_FILES[self::FILE_POSTVAR]["name"])) {
            $actionUrl = $_SERVER['PHP_SELF'];

            echo <<< EOT
        <form name="uploadExperimentForm" action="$actionUrl" method="POST" enctype="multipart/form-data">
            <h1>Load Experiment</h1>
EOT;
            WidgetMaker::file_input("Upload File", self::FILE_POSTVAR);
            WidgetMaker::submit_button();

            echo <<< EOT
            </form>
EOT;

        }
        else {
            $this->upload_file($this->db_conn);
        }
    }
}
