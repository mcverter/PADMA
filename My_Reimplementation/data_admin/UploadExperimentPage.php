<?php

require_once('../templates/DatabaseConnectionPage.php');
PageControlFunctionsAndConsts::exit_on_warning();

/**
 * Class UploadReferencePage
 *
 * This is used to upload new Experiments to the Database
 */
class UploadExperimentPage extends DatabaseConnectionPage {

    const PG_TITLE =  "Upload Experiment";
    const UPLOAD_SUBDIR =  "drosoData/";
    const FILE_POSTVAR = 'experimentFile';
    const YES_VALUE = "Yes";
    const PUBLISH_RADIO_ID = "publish_radio";
    const NO_VALUE = "No";

    /**
     * Checks to make sure that the Request to upload experiments
     * came from the Upload Agreement Page.
     */
    function check_referrer() {
        if (! isset($_SERVER['HTTP_REFERER'])) {
            return false;
        }
        $referrer_parts = parse_url($_SERVER['HTTP_REFERER']);
        if (($_SERVER['HTTP_HOST'] !== $referrer_parts['host']) ||
            (($referrer_parts['path'] !==$_SERVER['PHP_SELF']) &&
                ($referrer_parts['path'] !==
                    dirname(dirname($_SERVER['PHP_SELF'])) .
                    "/webpages/upload_agreement.php"))) {
            return false;
        }
        return true;
    }



    /**
     * Only Researchers and Administrators are allowed to Upload Experiments
     *
     * @return bool:  Whether user is allowed to view page
     */
    protected  function isAuthorizedToViewPage() {
        return PageControlFunctionsAndConsts::check_role(pgFn::SUPERVISING_ROLE);
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
        return $this->make_image_content_columns ($userid, $role, 'L', 3) ;
    }

    /**
     *
     * Processes each line of the uploaded file and
     *   inserts its contents into the database in
     *   EXPERIMENT and EXPERIMENT_MASTER tables
     *
     * Assuming only one experiment per file
     */
    function upload_file()
    {
        $errmsg = '';
        if (($filehandle = PageControlFunctionsAndConsts::openUploadedCSVFile(
                self::FILE_POSTVAR,
                PageControlFunctionsAndConsts::BASE_UPLOAD_DIR . self::UPLOAD_SUBDIR,
                $errmsg)) == null) {
            return PageControlFunctionsAndConsts::redirectDueToError($errmsg);
        }

        $db_conn = $this->db_conn;
        $restricted = ($_POST[self::PUBLISH_RADIO_ID] == self::YES_VALUE) ? 0 : 1;
        $date = date("m/d/y");
        $userid = $_SESSION[PageControlFunctionsAndConsts::USERID_SESSVAR];
        $description = "Not Available";
        $count = 0;

        $line = fgets($filehandle);
        if ($line != false) {
            list ($prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $hour) =
                explode(",", trim($line));
            if ($exp_name && !dbFn::experimentInDB($db_conn, $exp_name)) {

                // Insert into EXPERIMENT table
                while ($line != false) {
                    if (substr_count($line, ",") != 7) {
                        return PageControlFunctionsAndConsts::redirectDueToError("There must be 8 columns in each line of {$destinationFileName}.  The following line does not: \n'{$line}'' ");
                    }
                    list ($prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $hour) =
                        explode(",", trim($line));
                    dbFn::insertIntoExpTbl($db_conn, $prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $userid, $date, $restricted, $hour);
                    $count++;
                    $line = fgets($filehandle);
                }

                // insert into EXPERIMENT_MASTER table
                if ($count) {
                    dbFn::insertIntoExpMasterTbl($db_conn, $exp_name, $description, $userid, $date, $restricted, $count);
                }
            }
        }
    }

    /**
     * @Override
     * Shows the main functional content block of the page
     * Shows an File Input widget allowing user to upload File.
     * If $_FILES is set, the input file will be processed.
     * If any error occurs, it will be displayed upon the page.
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */

    function make_main_content($userid, $role) {
        if (!$this->check_referrer()) {
            return PageControlFunctionsAndConsts::redirectDueToError("You must agree to the terms of service before you complete the registration");
        }

        $returnString = '';

        // Probably redundant
        if(((empty($_FILES) || empty($_FILES[self::FILE_POSTVAR])
                || ($_FILES[self::FILE_POSTVAR]['size'] < 1)
                || empty($_FILES[self::FILE_POSTVAR]["name"])
                ||! is_uploaded_file($_FILES[self::FILE_POSTVAR]["tmp_name"])))
            == false ) {
            $this->upload_file();
            $returnString .= wMk::successMessage('uploadSuccess', 'You have successfully uploaded an experiment');
        }


        $returnString .= wMk::start_file_form($_SERVER['PHP_SELF'],  'POST', 'uploadForm', 'form-horizontal',' data-parsley-validate ')
            . wMk::file_input("Upload File", self::FILE_POSTVAR, '',  " data-parsley-required ")
            . "<br><h4>Publish?<h4><br>"
            . WidgetMaker::radio_input(self::YES_VALUE, self::PUBLISH_RADIO_ID, self::YES_VALUE, '')
            . WidgetMaker::radio_input(self::NO_VALUE, self::PUBLISH_RADIO_ID, self::NO_VALUE, "checked")
            . wMk::submit_button()
            . wMk::end_form();

        return $returnString;
    }
}

