<?php
require_once (__DIR__ . "/../templates/DatabaseConnectionPage.php");
class DeleteReferencePage extends DatabaseConnectionPage {
    function __construct() {check_role('a');
    }
    function print_content() {
        $role=0;
        $db_conn = $this->db_conn;
        $userid=strtoupper($_SESSION['userid']);


//delete experiment when delete button is clicked
$version=$_POST['version'];
$cmdstr = "delete from REFERENCE_MAIN where VERSION='".$version."'";
$cmdstr2 = "delete from REFERENCE_GO where VERSION='".$version."'";
$cmdstr3 = "delete from REFERENCE_BIO where VERSION='".$version."'";
//echo $cmdstr;
$parsed = ociparse($db_conn, $cmdstr);
ociexecute($parsed);
$parsed = ociparse($db_conn, $cmdstr2);
ociexecute($parsed);
$parsed = ociparse($db_conn, $cmdstr3);
ociexecute($parsed);


echo <<< EOT

     <form name="form1" action="" method="post">
      <fieldset>
	<b>(Select a Version to delete)</b><br>
 
      </fieldset>
    </form>
EOT;
    }
}











