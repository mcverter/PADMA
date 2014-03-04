<?php
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();


$command = isset($_POST['command'])? $_POST['command'] : "undefined";
if ($command == "undefined") {
  echo "<br /><font color='red'><b>ERROR:</b></font> Internal logic error, please contact PADMA administrator.<br />";
  echo "<a title='logout' href='index.php'>Click Here</a> to go back to home page";
  exit;
}
//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
if (!$db_conn) {
  print_db_conn_failure( oci_error() );
  exit;
}
//get matrix value from database
$cmdstrRetrieve = $_POST[$command];
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
 
 
 
 
 
 
 
 
 
 
 
