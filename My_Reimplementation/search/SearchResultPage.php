<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/2/14
 * Time: 10:03 AM
 */


require_once (__DIR__ . "/SearchBase.php");

class SearchResultPage extends SearchBase {


    const RESULT_TABLE_ID = 'resultTable';



  function make_page_middle($title, $userid, $role){
    return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
      }
    function search_query() {
        return dbFn::selectSearchResult($this->db_conn, $this->userid, $this->build_constraint(self::$result_cols));
    }

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

        while (($row = oci_fetch_array($query_result)) != false) {
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

    function export() {
        $queryResult = $this->search_query();
        # file name for download
        $filename = "PADMA_data_" . date('Ymd') . ".xls";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        $headerrow = oci_fetch_array($queryResult, OCI_ASSOC);
        $returnString = implode("\t", array_keys($headerrow)) . "\n";

        while (false !== ($bodyrow = oci_fetch_array($queryResult, OCI_ASSOC))) {
            $returnString .= rtrim(implode("\t", array_values( preg_replace("/\t/", "\\t", $bodyrow)))) . "\n";
        }
        return $returnString;
    }

    function make_main_frame($title, $userid, $role) {
        $returnString = $this->print_results() ;
        return $returnString;
    }
    function get_title() {
        return "Search Results";
    }

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