<?php

function upload($db_conn) {

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
    }
}


function insert_reference($db_conn) {
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

    }


}


function insert_experiment($db_conn) {

  echo <<< EOT
    <form   action="insertReference.php" method="POST">
		      <td ><b><font color="#ffffff">Confirmation...</font></b></td>
EOT;

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



function create_experiment($db_conn) {
   <form   action="insertExperiment.php" method="POST">
		      <td ><b><font color="#ffffff">Confirmation...</font></b></td>

EOT;
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

			    //Directory location of the file that will be loaded
			    $directories="C:/inetpub/wwwroot/PADMA/drosoData/";
			    //$file = $_REQUEST['uploadedfile'] ;
			    $fileName=$directories . $_FILES['uploadedfile']['name'];
			    //echo $fileName .

				      //check if user wants to publish the data
			    $publish=$_REQUEST['publish'] ;
			    $publish=strtoupper(trim($publish));
			    if(!($publish=="YES" or $publish=="NO"))
			    {
			      $msg="Invalid Publish Status<br><a title='back' href='expLoaderStart.php'>Click Here</a> to go back";
			      exit($msg);
			    }

			    echo "<br><br>";

			    //---Veriable declaration to track the file that will be loaded
			    $TotalRowToInsert =0;
			    $noError=true;
			    $parts=array();

			    $prob_id=array();
			    $exp_name=array();
			    $catg=array();
			    $spec=array();
			    $subj=array();
			    $reg_val=array();
			    $hour=array();
			    $open=array();
			    $index=0;

			    //----Check if the file is in right format and how many rows are in the file
			    $handle = fopen($fileName, "rb") or die("ERROR: opening file");
			    $line_of_text_length=5;
			    //read the line with header

			    while ((!feof($handle)) && ($noError) && $line_of_text_length>4)
			    {
			     $line_of_text = fgets($handle);
			     $line_of_text_length=strlen(trim($line_of_text));
			     $parts = explode(',', $line_of_text);
			     if(count($parts) < 8)
			     {
				$noError=false;
				break;
			      }
			     else
			     {
				//create array to insert into database
				$prob_id[$index]=$parts[0];
				$exp_name[$index]=$parts[1];
				$catg[$index]=$parts[2];
				$spec[$index]=$parts[3];
				$subj[$index]=$parts[4];
				$reg_val[$index]=$parts[5];
				$open[$index]=$parts[6];
				$hour[$index]=$parts[7];

			      }
			     $index++;
			     $TotalRowToInsert++;
			     //$line_of_text = fgets($handle);
			     }
			    //close the file
			    fclose($handle);
			    //Check if the experimrnt exist into the database
			    $numrows=0;
			    $str = "SELECT  * FROM EXPERIMENT  WHERE EXP_NAME='".$exp_name[1]."'";
			    $parsed = ociparse($db_conn, $str);
			    ociexecute($parsed);
			    $numrows = ocifetchstatement($parsed, $results);
			    if($noError)
			    {
			      if($numrows>0)
			      {
				echo " Experiment: $exp_name[0] already in the system";
			      }
			      else
			      {
				echo "Total Record: " . $TotalRowToInsert . "<br>";

				echo " <b>Verification Complete</b><br><br>";
				$_POST['prob_id']=$prob_id;
				$_POST['exp_name']=$exp_name;
				$_POST['catg']=$catg;
				$_POST['spec']=$spec;
				$_POST['subj']=$subj;
				$_POST['reg_val']=$reg_val;
				$_POST['open']=$open;
				$_POST['hour']=$hour;
				$_POST['noError']=$noError;
				$_POST['publish']=$publish;
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
    }
  }
?>