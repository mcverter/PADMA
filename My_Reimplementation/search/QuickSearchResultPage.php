<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/2/14
 * Time: 10:04 AM
 */

class QuickSearchResultPage extends SearchResultsBase {
    static $quicksearch_cols = [
        [
//            'col' =>self::PROBEID_FULLVIEW_TBL_COL,
            'type' =>'quicksearch',
//            'postvar' => self::PROBEID_LABEL,

        ],
        [
            'col' =>self::BIOFUNCTION_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::BIOFUNCTION_LABEL,

        ],
        [
            'col' =>self::EXPERIMENTNAME_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::EXPERIMENTNAME_LABEL,

        ],
        [
            'col' =>self::ACTIVECATEGORY_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::ACTIVECATEGORY_LABEL,

        ],
        [
            'col' =>self::ACTIVESPECIES_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::ACTIVESPECIES_LABEL,

        ],
        [
            'col' =>self::EXPERIMENTSUBJECT_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::EXPERIMENTSUBJECT_LABEL,

        ],
    ];

    function search_query() {
        return DBFunctions::selectQuickSearchResultList($this->db_conn, $this->userid,
            $this->build_constraint(self::$quicksearch_cols));
    }

    function print_results () {
        $returnString = <<< EOT
        <table>
            <thead>
EOT;

        foreach ( self::$quicksearch_cols as $col) {
            $returnString .= "\n <th> " . $col['heading'] . " </th> ";
        }
        $returnString .= <<< EOT
        </thead>
        <tbody>
EOT;
        $query_result = $this->search_query();

        while (($row = oci_fetch_array($query_result)) != false) {
            $returnString .= "\n <tr> ";
            foreach ( self::$quicksearch_cols as $col) {
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

    }


} 