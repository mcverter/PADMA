<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/3/14
 * Time: 12:51 PM
 */
$queryResult = $_POST['queryResultHandle'];
# file name for download
$filename = "PADMA_data_" . date('Ymd') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");
$headerrow = oci_fetch_array($queryResult, OCI_ASSOC);
echo implode("\t", array_keys($headerrow)) . "\n";

while (false !== ($bodyrow = oci_fetch_array($queryResult, OCI_ASSOC))) {
    echo rtrim(implode("\t", array_values( preg_replace("/\t/", "\\t", $bodyrow)))) . "\n";
}
