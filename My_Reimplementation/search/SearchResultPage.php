<?php

require_once("../templates/DatabaseConnectionPage.php");

/**
 * Class SearchResultPage
 *
 * This displays the results of the Search of the
 * FULL_VIEW database, which contains complete information
 * about experiments.
 *
 * The results can be exported to a csv or several other formats
 *
 * Note that the Number of results is limited by
 * DBFunctionsAndConsts::SEARCH_RESULT_LIMIT
 */

class SearchResultPage extends DatabaseConnectionPage
{
    const PG_TITLE = "Search Results";

    const RESULT_TABLE_ID = 'resultTable';
    const NOT_POSTED = "notPosted";
    const ARRAY_TYPE = 'array';
    const STRING_TYPE = 'string';

    /**
     * The $result_cols array stores the following information:
     *
     * (1)  The Column in the FULL_VIEW database
     * (2)  The name of the POSTed variable
     * (3)  The type of the POSTed variable (array or string or notposted)
     * (4) The heading in the result table.
     *
     * Notes:
     *  (A) Because the columns in the FULL_VIEW view
     *   do not correspond to the columns in the EXPERIMENT and other
     *   tables, the POST attribute may not correspond to the COLUMN attribute
     *
     *  (B) The POSTed attribute will be appended with "[]" when
     *    the POST submission is being processed
     *
     *  (C) Certain resulting Database columns are not POSTed
     *     in the form submission.
     *
     */
    static $result_cols = array(
        array('col' => DBFunctionsAndConsts::FULL_VIEW_PROBE_ID,
            'type' => self::STRING_TYPE,
            'postvar' => DBFunctionsAndConsts::PROB_ID_COL,
            'heading' => "Probe ID"),
        array('col' => DBFunctionsAndConsts::FULL_VIEW_CGNUMBER,
            'type' => self::STRING_TYPE,
            'postvar' => DBFunctionsAndConsts::CGNUMBER_COL,
            'heading' => "CG Number"),
        array('col' => DBFunctionsAndConsts::GENENAME_COL,
            'type' => self::ARRAY_TYPE,
            'postvar' => DBFunctionsAndConsts::GENENAME_COL,
            'heading' => "Gene Name"),
        array('col' => DBFunctionsAndConsts::FULL_VIEW_FBNUM,
            'type' => self::STRING_TYPE,
            'postvar' => DBFunctionsAndConsts::FBGNNUMBER_COL,
            'heading' => "FlyBase Number"),
        array('col' => DBFunctionsAndConsts::BIOFUNCTION_COL,
            'type' => self::ARRAY_TYPE,
            'postvar' => DBFunctionsAndConsts::BIOFUNCTION_COL,
            'heading' => "Bio Function"),
        array('col' => DBFunctionsAndConsts::GONUMBER_COL,
            'type' => self::STRING_TYPE,
            'postvar' => DBFunctionsAndConsts::GONUMBER_COL,
            'heading' => "GO Number"),
        array('col' => DBFunctionsAndConsts::FULL_VIEW_NAME,
            'type' => self::ARRAY_TYPE,
            'postvar' => DBFunctionsAndConsts::EXP_NAME_COL,
            'heading' => "Experiment Name"),
        array('col' => DBFunctionsAndConsts::FULL_VIEW_CATG,
            'type' => self::ARRAY_TYPE,
            'postvar' => DBFunctionsAndConsts::CATG_COL,
            'heading' => "Active Category"),
        array('col' => DBFunctionsAndConsts::FULL_VIEW_SPEC,
            'type' => self::ARRAY_TYPE,
            'postvar' => DBFunctionsAndConsts::SPEC_COL,
            'heading' => "Active Species"),
        array('col' => DBFunctionsAndConsts::FULL_VIEW_SUBJ,
            'type' => self::ARRAY_TYPE,
            'postvar' => DBFunctionsAndConsts::SUBJ_COL,
            'heading' => "Experiment Subject"),
        array('col' => DBFunctionsAndConsts::FULL_VIEW_REG_VAL,
            'type' => self::ARRAY_TYPE,
            'postvar' => DBFunctionsAndConsts::REG_VAL_COL,
            'heading' => "Regulation Value"),
        array('col' => DBFunctionsAndConsts::FULL_VIEW_ADDITIONALINFO,
            'type' => self::NOT_POSTED,
            'postvar' => self::NOT_POSTED,
            'heading' => "Fold Induction"),
        array('col' => DBFunctionsAndConsts::HOUR_COL,
            'type' => self::NOT_POSTED,
            'postvar' => self::NOT_POSTED,
            'heading' => "Hour"),
    );

    /**
     * @Override
     *
     * Makes the main functional content block of the page
     *
     * Converts the POSTed parameters from the Search Form
     *   into a Database query and prints out a formatted table
     *   for viewing the results.
     *
     * @return string
     */
    function make_main_content($userid, $role)
    {
        $tableid = self::RESULT_TABLE_ID;
        $returnString = <<< EOT
        <table id='$tableid' class='table table-striped table-bordered table-condensed'>
            <thead>
EOT;
        // create table headers
        foreach (self::$result_cols as $col) {
            $returnString .= "\n <th> " . $col['heading'] . " </th> ";
        }
        $returnString .= <<< EOT
        </thead>
        <tbody>
EOT;
        $query_result = DBFunctionsAndConsts::selectSearchResult($this->db_conn, $this->userid,
            $this->build_constraint(self::$result_cols));

        // Print each row of the table based on each DB row
        while (($row = oci_fetch_assoc($query_result)) != false) {
            $returnString .= "\n <tr> ";
            foreach (self::$result_cols as $col) {
                $returnString .= "\n <td> " . trim($row[$col['col']]) . " </td> ";
            }
            $returnString .= "\n </tr> ";
        }

        $returnString .= <<< EOT
        </tbody>
        </table>
EOT;
        return $returnString;
    }

    /**
     * Converts the POSTed values in the Search Query
     *   into one long string that will fit into the
     *   "WHERE" clause of a database query.
     *
     * @param $search_params: The POST parameters that will
     *       be processed.  We are currently only supporting
     *       a Full Advanced Search of the Database,
     *       but we could potentially support a less exhaustive
     *       Search by changing the $search_params parameter
     *
     * @return string:  WHERE clause for DB query
     */
    function build_constraint($search_params)
    {
        $constraint = " 1=1 ";
        foreach ($search_params as $param) {
            $type = $param['type'];
            $postvar = $param['postvar'];
            if ($type === self::ARRAY_TYPE) {
                if (isset($_POST[$postvar]) &&
                    (!empty ($_POST[$postvar]))) {
                    $constraint .= " AND " . $param['col'] . " IN  ";
                    $constraint .= " ( " . self::extract_csv_from_array($_POST[$param['postvar']]) . " ) ";
                }}
            elseif ($param['type'] === self::STRING_TYPE) {
                if (isset($_POST[$postvar]) &&
                    (!empty ($_POST[$postvar]))) {
                    $constraint .= " AND " . $param['col'] . " IN  ";
                    $constraint .= " ( " . self::extract_csv_from_string($_POST[$param['postvar']]) . " ) ";
                }
            }
        }
        return $constraint;
    }

    /**
     * Used to transform parameter from POST request
     *  into parameter for usage in Database query
     *
     * @param $arr: PHP Array posted to Page
     * @return string: Comma separated, quoted list for DB query
     */
    static private function extract_csv_from_array($arr) {
        $csv = " '" . array_pop($arr) . "'";
        foreach ($arr as $v) {
            $csv .= " , '" . $v . "' ";
        }
        return $csv;
    }

    /**
     * Used to transform string from POST request
     *  into parameter for usage in Database query
     *
     * @param $str: PHP String posted to Page
     * @return string: Comma separated, quoted list for DB query
     */
    static private function extract_csv_from_string($str) {
        return self::extract_csv_from_array(explode(',', $str));
    }




    /**
     * Makes the javascript for the page
     *
     * This page makes heavy usage of datatables.js to
     *  (1) allow for column reordering
     *  (2) allow for column hiding
     *  (3) Fixes the table header
     *  (4) Allows for downloading as csv and other formats
     *
     * @return string:  Javascript for page
     */
    function make_js()
    {
        $returnString = parent::make_js();
        $tableID = self::RESULT_TABLE_ID;


        $returnString .= <<< EOT
        <!-- DataTables CSS -->

        <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../extensions/TableTools/css/dataTables.tableTools.css">
        <link rel="stylesheet" type="text/css" href="../extensions/ColReorder/css/dataTables.colReorder.css">
        <link rel="stylesheet" type="text/css" href="../extensions/ColVis/css/dataTables.colVis.css">

        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="../js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="../extensions/TableTools/js/dataTables.tableTools.js"></script>
        <script type="text/javascript" language="javascript" src="../extensions/ColReorder/js/dataTables.colReorder.js"></script>
        <script type="text/javascript" language="javascript" src="../extensions/ColVis/js/dataTables.colVis.js"></script>
        <script>
            $(document).ready( function () {
                $('#$tableID').dataTable( {
                    dom: 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "../extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                    }
                } );
            }  );
        </script>
EOT;
        return $returnString;
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
        return $this->make_image_content_columns($userid, $role, 'N');
    }
}