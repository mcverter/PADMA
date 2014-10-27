<?php

require_once (__DIR__ . "/SearchBase.php");

/**
 * Class SearchResultPage
 */
class SearchResultPage extends SearchBase {

    const PG_TITLE = "Search Results";

    const RESULT_TABLE_ID = 'resultTable';

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
     * @return mixed
     * @throws ErrorException
     */
    function search_query() {
        return dbFn::selectSearchResult($this->db_conn, $this->userid, $this->build_constraint(self::$result_cols));
    }

    /**
     * @return string
     */
    function print_results () {
        $tableid = self::RESULT_TABLE_ID;
        $returnString = <<< EOT
        <table id='$tableid'>
            <thead>
EOT;

        foreach ( self::$result_cols as $col) {
            $returnString .= "\n <th> " . $col['heading'] . " </th> ";
        }
        $returnString .= <<< EOT
        </thead>
        <tbody>
EOT;
        $query_result = $this->search_query();

        while (($row = oci_fetch_assoc($query_result)) != false) {
            $returnString .= "\n <tr> ";
            foreach ( self::$result_cols as $col) {
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

    /**
     * @return string
     */
    function export() {
        $queryResult = $this->search_query();
        # file name for download
        $filename = "PADMA_data_" . date('Ymd') . ".xls";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        $headerrow = oci_fetch_assoc($queryResult, OCI_ASSOC);
        $returnString = implode("\t", array_keys($headerrow)) . "\n";

        while (false !== ($bodyrow = oci_fetch_assoc($queryResult, OCI_ASSOC))) {
            $returnString .= rtrim(implode("\t", array_values( preg_replace("/\t/", "\\t", $bodyrow)))) . "\n";
        }
        return $returnString;
    }

    /**
     * @param $userid
     * @param $role
     * @return string
     */
    function make_main_content($userid, $role) {
        $returnString = $this->print_results() ;
        return $returnString;
    }

    /**
     * @return string
     */
    function make_js() {
        $returnString = parent::make_js();
        $tableID = self::RESULT_TABLE_ID;


        $returnString .= <<< EOT
        <!-- DataTables CSS -->

<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="../extensions/TableTools/css/dataTables.tableTools.css">
	<link rel="stylesheet" type="text/css" href="../extensions/ColReorder/css/dataTables.colReorder.css">
	<link rel="stylesheet" type="text/css" href="../extensions/ColVis/css/dataTables.colVis.css">

<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="../js/jquery.js"></script>

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../extensions/TableTools/js/dataTables.tableTools.js"></script>
<script type="text/javascript" language="javascript" src="../extensions/ColReorder/js/dataTables.colReorder.js"></script>
<script type="text/javascript" language="javascript" src="../extensions/ColVis/js/dataTables.colVis.js"></script>
<script>
$(document).ready( function () {
    $('#$tableID').dataTable( {
        "dom": 'RC<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
        }
    } );
}  );
</script>
EOT;
        return $returnString;
    }
}