<?php
check_role('a');
initialize_session();
$db_conn = connect_to_db();
$userid=strtoupper($_SESSION['userid']);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>
    <?php
    //include the header page
    include("header.php");

    if ($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
    {
      echo "<table class='_90small_bold'>";
      echo	"<tr>";
      echo		"<td class='rc'>";
      echo			"<a title='back' href='DataManagement.php'>Back to Data Management Page</a> <br/>";
      echo		"</td>";
      echo	"</tr>";
      echo "</table>";
    }
    else
    {
      echo "&nbsp;<br>";
    }
    echo <<< EOT
    <form   action="insertReference.php" method="POST">
      <table class="headerImage"></table>
      <td ><h2><font color="#ffffff">Confirmation...</font></h2></td>
EOT;

      $PID=array();
      $cgNumber=array();
      $geneName=array();
      $fbgn=array();
      $pidGo=array();
      $goBio=array();

      $PID=$_POST['pid'];
      $cgNumber=$_POST['cgNumber'];
      $geneName=$_POST['geneName'];
      $fbgn=$_POST['fbgn'];
      $uniquePidGo=$_POST['uniquePidGo'];
      $uniqueGoBio=$_POST['uniqueGoBio'];
      $noError=$_POST['noError'];
      $userid=$_POST['userid'];
      $Version=$_POST['Version'];

      //insert data to REFERENCE_MAIN Table
      $str = "";
      $date=date("m/d/y");
      $REFERENCE_MAIN_ERROR=false;
      $REFERENCE_GO_ERROR=false;
      $REFERENCE_BIO_ERROR=false;

      $REFERENCE_MAIN_ROWCOUNT=0;
      $REFERENCE_GO_ROWCOUNT=0;
      $REFERENCE_BIO_ROWCOUNT=0;

      //----------------------Insert REFERENCE_MAIN Data----------------------------------------
      for($i=0;$i<count($PID);$i++)
      {
	$geneNameTrimmed=str_replace("'", "", $geneName[$i]);
	$REFERENCE_MAIN_ROWCOUNT++;
	$str ="insert into REFERENCE_MAIN VALUES('$PID[$i]', '$cgNumber[$i]', '$geneNameTrimmed' ,'$fbgn[$i]', '$Version', '$userid', '$date')";
	//echo $str . "<br>";
	$parsed = ociparse($db_conn, $str);
	if(! ociexecute($parsed))
	{
	  $REFERENCE_MAIN_ERROR=true;
	  break;
	}
	//$numrows = ocifetchstatement($parsed, $results);
	//echo $str . "<br>";
      }
      if($REFERENCE_MAIN_ERROR)
      {
	$strDel ="delete from REFERENCE_MAIN where VERSION='".$Version."'";
	$parsed = ociparse($db_conn, $strDel);
	ociexecute($parsed);
	exit("ERROR! Inserting Record# $REFERENCE_MAIN_ROWCOUNT Into REFERENCE_MAIN Table");
      }

      //----------------------Insert REFERENCE_GO Data----------------------------------------
      foreach($uniquePidGo as $strItem)
      {
	$REFERENCE_GO_ROWCOUNT++;
	$uniquePidGoPart=explode("//",$strItem);
	$str ="insert into REFERENCE_GO VALUES('$uniquePidGoPart[0]', '$uniquePidGoPart[1]', '$Version', '$userid', '$date')";

	//echo $str . "<br>";
	$parsed = ociparse($db_conn, $str);
	if(! ociexecute($parsed))
	{
	  $REFERENCE_GO_ERROR=true;
	  break;
	}
	//$numrows = ocifetchstatement($parsed, $results);
	//echo $str . "<br>";
      }

      if($REFERENCE_GO_ERROR)
      {
	$strDel1 ="delete from REFERENCE_MAIN where VERSION='".$Version."'";
	$strDel ="delete from REFERENCE_GO where VERSION='".$Version."'";

	$parsed = ociparse($db_conn, $strDel);
	ociexecute($parsed);

	$parsed = ociparse($db_conn, $strDel1);
	ociexecute($parsed);

	exit("ERROR! Inserting Record# $REFERENCE_GO_ROWCOUNT Into REFERENCE_GO Table");
      }

      //----------------------Insert REFERENCE_BIO Data----------------------------------------
      foreach($uniqueGoBio as $strItem)
      {
	$REFERENCE_BIO_ROWCOUNT++;
	$uniqueGoBioPart=explode("//",$strItem);
	$uniqueGoBioPartTrimmed=str_replace("'", "",$uniqueGoBioPart[1]);
	$str ="insert into REFERENCE_BIO VALUES('$uniqueGoBioPart[0]', '$uniqueGoBioPartTrimmed', '$Version', '$userid', '$date')";

	$parsed = ociparse($db_conn, $str);
	if(! ociexecute($parsed))
	{
	  $REFERENCE_BIO_ERROR=true;
	  break;
	}
	//$numrows = ocifetchstatement($parsed, $results);
	//echo $str . "<br>";
      }

      if($REFERENCE_BIO_ERROR)
      {
	$strDel1 ="delete from REFERENCE_MAIN where VERSION='".$Version."'";
	$strDel2 ="delete from REFERENCE_GO where VERSION='".$Version."'";
	$strDel ="delete from REFERENCE_BIO where VERSION='".$Version."'";

	$parsed = ociparse($db_conn, $strDel1);
	ociexecute($parsed);

	$parsed = ociparse($db_conn, $strDel2);
	ociexecute($parsed);

	$parsed = ociparse($db_conn, $strDel);
	ociexecute($parsed);

	exit("ERROR! Inserting Record# $REFERENCE_BIO_ROWCOUNT Into REFERENCE_BIO Table");
      }

      echo "<h2>Reference Data Version $Version Inserted SUCCESSFULLY. </h2>";
      ?>
      <div id="txtHint"><h2></h2></div>
    </form>
    <?php oci_close($db_conn); ?>
  </body>
</html>









