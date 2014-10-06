<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/2/14
 * Time: 10:03 AM
 */


require_once (__DIR__ . "/SearchResultsBase.php");

class AdvancedSearchResultPage extends SearchResultsBase {
    static $advanced_cols = [
        [
            'col' =>self::PROBEID_FULLVIEW_TBL_COL,
            'type' =>'string',
            'postvar' => self::PROBEID_LABEL,
            'heading' => self::PROBEID_HEADING
        ],
        [
            'col' =>self::CGNUMBER_FULLVIEW_TBL_COL,
            'type' =>'string',
            'postvar' => self::CGNUMBER_LABEL,
            'heading' => self::CGNUMBER_HEADING
        ],
        [
            'col' =>self::FLYBASE_FULLVIEW_TBL_COL,
            'type' =>'string',
            'postvar' => self::FLYBASE_LABEL,
            'heading' => self::FLYBASE_HEADING
        ],
        [
            'col' =>self::GONUMBER_FULLVIEW_TBL_COL,
            'type' =>'string',
            'postvar' => self::GONUMBER_LABEL,
            'heading' => self::GONUMBER_HEADING
        ],
        [
            'col' =>self::GENENAME_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::GENENAME_LABEL,
            'heading' => self::GENENAME_HEADING

        ],
        [
            'col' =>self::BIOFUNCTION_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::BIOFUNCTION_LABEL,
            'heading' => self::BIOFUNCTION_HEADING
        ],
        [
            'col' =>self::EXPERIMENTNAME_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::EXPERIMENTNAME_LABEL,
            'heading' => self::EXPERIMENTNAME_HEADING
        ],
        [
            'col' =>self::ACTIVECATEGORY_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::ACTIVECATEGORY_LABEL,
            'heading' => self::ACTIVECATEGORY_HEADING
        ],
        [
            'col' =>self::ACTIVESPECIES_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::ACTIVESPECIES_LABEL,
            'heading' => self::ACTIVESPECIES_HEADING
        ],
        [
            'col' =>self::EXPERIMENTSUBJECT_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::EXPERIMENTSUBJECT_LABEL,
            'heading' => self::EXPERIMENTSUBJECT_HEADING

        ],
    ];



    function search_query() {
        return DBFunctions::selectAdvancedQueryResult($this->db_conn, $this->userid,
            $this->build_constraint(self::$advanced_cols));
    }

    function print_results () {
        $returnString = <<< EOT
        <table>
            <thead>
EOT;

        foreach ( self::$advanced_cols as $col) {
            $returnString .= "\n <th> " . $col['heading'] . " </th> ";
        }
        $returnString .= <<< EOT
        </thead>
        <tbody>
EOT;
        $query_result = $this->search_query();

        while (($row = oci_fetch_array($query_result)) != false) {
            $returnString .= "\n <tr> ";
            foreach ( self::$advanced_cols as $col) {
                $returnString .= "\n <td> " . $row[$col['col']] . " </td> ";
            }
            $returnString .= "\n </tr> ";
        }

        $returnString .= <<< EOT
        </tbody>
        </table>
EOT;
        return $returnString;

    }

    function export() {
        $queryResult = $this->search_query();
        # file name for download
        $filename = "PADMA_data_" . date('Ymd') . ".xls";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        $headerrow = oci_fetch_array($queryResult, OCI_ASSOC);
        echo implode("\t", array_keys($headerrow)) . "\n";

        while (false !== ($bodyrow = oci_fetch_array($queryResult, OCI_ASSOC))) {
            echo rtrim(implode("\t", array_values( preg_replace("/\t/", "\\t", $bodyrow)))) . "\n";
        }
    }

    function __construct(){
        $this->title = "Search Results";
        parent::__construct();
    }

    function print_content() {
        echo $this->print_results();
        WidgetMaker::start_form('');
        WidgetMaker::submit_button('export', 'Export Results');
        WidgetMaker::end_form();
    }

} 