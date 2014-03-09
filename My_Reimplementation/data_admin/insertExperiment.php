<?php
require_once (__DIR__ . "/../templates/DatabaseConnectionPage.php");
class InsertExperiment extends DatabaseConnectionPage {
    function __construct() {}
    function print_content() {

echo <<< EOT

    <form   action="insertReference.php" method="POST">
      <table class="_100">
	<tr>
	  <td class="_20">&nbsp;</td>
	  <td class="_60">
	    <table class="_100color_border">
	      <tr>
		<td>
		  <table class="headerImage">
		    <tr>
		      <td ><b><font color="#ffffff">Confirmation...</font></b></td>
		    </tr>
		  </table>

		  <br><br><br>
		  <table class="_100pad5">
		    <tr>
		      <td class="_20r">&nbsp;</td>
		      <td class="8lb">
EOT;
/*
			$prob_id=array();
			$exp_name=array();
			$catg=array();
			$spec=array();
			$subj=array();
			$reg_val=array();
			$open=array();

			$prob_id=$_POST['prob_id'];
			$exp_name=$_POST['exp_name'];
			$catg=$_POST['catg'];
			$spec=$_POST['spec'];
			$subj=$_POST['subj'];
			$reg_val=$_POST['reg_val'];
			$open=$_POST['open'];
			$hour=$_POST['hour'];
			$noError=$_POST['noError'];
			$userid=$_POST['userid'];
			$publish=$_POST['publish'];

			$restricted='1';
			if($publish=="YES")
			  $restricted='0';
			elseif($publish=="NO")
			$restricted='1';



			//insert data to Experiment Table
			$str = "";
			$date=date("m/d/y");
			$EXPERIMENT_ERROR=false;
			$EXPERIMENT_ROWCOUNT=0;
			$exp_desc="Not Available";
			$recNum=count($prob_id);
			//----------------------Insert EXPERIMENT Data----------------------------------------
			for($i=0;$i<$recNum;$i++)
			{

			  $EXPERIMENT_ROWCOUNT++;
			  $str ="insert into EXPERIMENT VALUES('$prob_id[$i]', '$exp_name[$i]', '$catg[$i]' ,'$spec[$i]','$subj[$i]','$reg_val[$i]','$open[$i]','$userid', '$date','$restricted','$hour[$i]')";
			  //echo $str . "<br>";
			  $parsed = ociparse($db_conn, $str);
			  if(! ociexecute($parsed))
			  {
			    $EXPERIMENT_ERROR=true;
			    break;
			  }
			  if($EXPERIMENT_ROWCOUNT==($recNum-2))
			  {
			    $strSQL ="insert into EXP_MASTER VALUES('$exp_name[$i]', '$exp_desc','$userid', '$date','$restricted',$recNum)";
			    //echo $str . "<br>";
			    $parsed = ociparse($db_conn, $strSQL);
			    if(! ociexecute($parsed))
			    {
			      $EXPERIMENT_ERROR=true;
			      break;
			    }
			  }
			  //$numrows = ocifetchstatement($parsed, $results);
			  //echo $str . "<br>";
			}
			if($EXPERIMENT_ERROR)
			{
			  $strDel ="delete from EXPERIMENT where EXP_NAME='".$exp_name[0]."'";
			  $parsed = ociparse($db_conn, $strDel);
			  ociexecute($parsed);

			  $strDel ="delete from EXP_MASTER where EXP_NAME='".$exp_name[0]."'";
			  $parsed = ociparse($db_conn, $strDel);
			  ociexecute($parsed);

			  exit("ERROR! Inserting Record# $EXPERIMENT_ROWCOUNT Into EXPERIMENT Table");
			}
			echo "<b>Experiment $exp_name[0] Inserted SUCCESSFULLY. </b>";
*/

    }
}
 
 
 
 
 
 
 
