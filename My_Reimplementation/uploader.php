<?php
check_role('ar');
initialize_session();
connect_to_db();
$userid=strtoupper($_SESSION['userid']);
?>



<!DOCTYPE html>

<html>

  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>
    <?php include("header.php"); ?>

    <form   action="insertReference.php" method="POST">
      <table class="headerImage">
	<b><font color="#ffffff">Confirmation...</font></b>
      </table>

      <?php
      //upload file to the server
      $uploaddir = 'C:/inetpub/wwwroot/PADMA/drosoData/';
      $uploadfile = $uploaddir . $_FILES['uploadedfile']['name'];

      $extension=explode(".",$uploadfile);
      if($extension[1]=="csv")
      {
	if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $uploadfile))
	{

	  //Get sesisson veriable to connect to database
	  $db_UN=$_SESSION['un'];
	  $db_PASS=$_SESSION['pass'];
	  $db_DB=$_SESSION['db'];

	  //connection to the database
	  $db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
	  if (! $db_conn)
	  {
	    $e = oci_error();
	    print htmlentities($e['message']);
	    exit;

	  }


	  //Directory location of the file that will be loaded
	  $Version=$_REQUEST['version'] ;
	  $directories="C:/inetpub/wwwroot/PADMA/drosoData/";
	  //$file = $_REQUEST['uploadedfile'] ;
	  $fileName=$directories . $_FILES['uploadedfile']['name'];
	  echo "<br><br>";

	  //---Veriable declaration to track the file that will be loaded
	  $TotalRowToInsert =0;
	  $TotalGoNumber=0;
	  $noError=true;
	  $parts=array();
	  $headerParts=array();
	  $goBioParts=array();
	  $InsideGoBioParts=array();
	  $GoBioFunction="";

	  $PID=array();
	  $cgNumber=array();
	  $geneName=array();
	  $fbgn=array();
	  $index=0;

	  $pidGo=array();
	  $goBio=array();
	  $pidGoIndex=0;
	  $goBioIndex=0;

	  //----Check if the file is in right format and how many rows are in the file
	  $handle = fopen($fileName, "rb") or die("ERROR: opening file");
	  //read the line with header
	  $line_of_text = fgets($handle);
	  $headerParts=explode(",",$line_of_text);
	  if(count($headerParts)!=5)
	  {
	    $noError=false;
	  }


	  while ((!feof($handle)) && ($noError))
	  {
	    $line_of_text = fgets($handle);
	    $parts = explode(',', $line_of_text);
	    $goBioLength=strlen(trim($parts[4]));
	    if(count($parts)< 5)
	    {
	      $noError=false;
	      break;
	    }
	    else
	    {
	      $GoBioFunction=$parts[4];
	      if(count($parts)>5)
	      {
		for($i=5;$i<count($parts);$i++)
		{
		  $GoBioFunction=$GoBioFunction . ',' .$parts[$i];
		}
	      }
	    }
	    //create array to insert into database
	    $PID[$index]=$parts[0];
	    $cgNumber[$index]=$parts[1];
	    $geneName[$index]=$parts[2];
	    $fbgn[$index]=$parts[3];
	    $index++;

	    //Remove double quote from GoBiofunction
	    $tempGoBioParts=explode('"',$GoBioFunction);

	    $GoBioFunction=$tempGoBioParts[0];
	    if (count($tempGoBioParts)==3)
	    {
	      $GoBioFunction=$tempGoBioParts[1];
	    }
	    else if (count($tempGoBioParts) > 3)
	    {
	      $noError=false;
	      break;
	    }
	    $goBioParts=explode('///',$GoBioFunction);
	    //echo $GoBioFunction . "<br><br>";
	    for ($i=0;$i<count($goBioParts);$i++)
	    {
	      //echo $goBioParts[$i]."<br><br>";
	      $InsideGoBioParts=explode('//',$goBioParts[$i]);
	      if(count($InsideGoBioParts) >1)
	      {
		$TotalGoNumber++;
		$pidGo[$pidGoIndex]=trim($parts[0]) . "//" . trim($InsideGoBioParts[0]);
		$goBio[$goBioIndex]=trim($InsideGoBioParts[0]) . "//" . trim($InsideGoBioParts[1]);
		$pidGoIndex++;
		$goBioIndex++;

	      }
	    }
	    $GoBioFunction="";
	    $TotalRowToInsert++;
	  }
	  //close the file
	  fclose($handle);
	  //Check if the version exist into the database
	  $numrows=0;
	  $str = "SELECT  * FROM REFERENCE_MAIN  WHERE VERSION='".$Version."'";
	  $parsed = ociparse($db_conn, $str);
	  ociexecute($parsed);
	  $numrows = ocifetchstatement($parsed, $results);
	  //echo $numrows;
	  if($noError)
	  {
	    if($numrows>0)
	    {
	      echo " Reference data for Version: $Version already in the system";
	    }
	    else
	    {
	      $uniquePidGo=array_unique($pidGo);
	      $uniqueGoBio=array_unique($goBio);

	      echo "Total Record: " . $TotalRowToInsert . "<br>";
	      echo "Total Go: " . count($uniqueGoBio) . "<br><br>";
	      echo " <b>Verification Complete</b><br><br>";
	      $_POST['pid']=$PID;
	      $_POST['cgNumber']=$cgNumber;
	      $_POST['geneName']=$geneName;
	      $_POST['fbgn']=$fbgn;
	      $_POST['uniquePidGo']=$uniquePidGo;
	      $_POST['uniqueGoBio']=$uniqueGoBio;
	      $_POST['noError']=$noError;
	      $_POST['Version']=$Version;
	      echo "<input name='Button1' type='submit' value='Load Data' />";
	    }
	  }
	  else
	  {
	    echo "File is not in Right format <br> Check Row# " . $TotalRowToInsert++ . " PID: " .$parts[0];
	  }
	}
	else
	{
	  print "Possible file upload attack!  Here's some debugging info:\n";
	  print_r($_FILES);

	}
      }
      else
      {
	print "Invalid file type, file was not uploaded. ";
      }
      ?>
    </form>
    <?php
    //close database connection
    oci_close($db_conn);
    ?>
  </body>
</html>







