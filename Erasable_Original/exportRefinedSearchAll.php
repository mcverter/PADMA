<?php 
session_start(); 
//get session variabe
$db_UN=$_SESSION['un'];
$db_PASS=$_SESSION['pass'];
$db_DB=$_SESSION['db'];
  
//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);


        
//get matrix value from database
$cmdstrRetrieve=$_SESSION['cmdStrRefinedAll'];        
$parsed = ociparse($db_conn, $cmdstrRetrieve);
ociexecute($parsed);
		

function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
   // $str = preg_replace("/\n/", "\\n", $str);
  }

  # file name for download
  $filename = "PADMA_data_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  while (false!==($row=oci_fetch_array($parsed,OCI_ASSOC))) {
    if(!$flag) {
      # display field/column names as first row
      echo implode("\t", array_keys($row)) . "\n";
      $flag = true;
    }
    array_walk($row, 'cleanData');
    //echo implode("\t", array_values($row) . "\n");
	echo implode("\t", array_values($row));
  }
    exit;
    
    ?>