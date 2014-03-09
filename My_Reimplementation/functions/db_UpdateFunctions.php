<?php
function confirm_edit_description($db_conn) {
        $userid=strtoupper($_SESSION['userid']);

        $expName= isset($_POST['expName'])? urldecode($_POST['expName']) : "";
        $desc= isset($_POST['desc'])? urldecode($_POST['desc']) : "";

        if (empty($expName) || empty($desc)) {
            ECHO "<font color='#FF0000'>Error! Invalid input formation, contact PADMA administrator</font>";
            return;
        }

        $str ="update EXP_MASTER set EXP_DESC='".$desc."' WHERE EXP_MASTER.EXP_NAME = '".$expName."'";
        $parsed = ociparse($db_conn, $str);
        $execute=ociexecute($parsed);


        if($execute)
        {
            edit_success_page();
        }
        else
        {
            edit_failure_page();
        }



  }

?>