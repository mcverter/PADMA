<?php
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();

//get matrix value from database
$cmdstrRetrieve = $_POST['cmdStrQuick'];
$parsed = ociparse($db_conn, $cmdstrRetrieve);
ociexecute($parsed);

function cleanData(&$str) {
  $str = preg_replace("/\t/", "\\t", $str);
  // $str = preg_replace("/\n/", "\\n", $str);
}
# file name for download
$filename = "PADMA_data_" . date('Ymd') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$count = 0;
$flag = false;
while (false !== ($row = oci_fetch_array($parsed, OCI_ASSOC))) {
  if(!$flag) {
    # display field/column names as first row
    echo implode("\t", array_keys($row)) . "\n";
    $flag = true;
  }
  array_walk($row, 'cleanData');
  echo rtrim(implode("\t", array_values($row))) . "\n";
  if (++$count >= 5000) break;
}
exit;
?>
 
 
 
 
 
 
 
 
 
 
 
 
