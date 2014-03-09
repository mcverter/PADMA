<?php

require_once(__DIR__ . '/../templates/DatabaseConnectionPage.php');

class ExperimentUploader extends DatabaseConnectionPage {
    function __construct() {
        check_role('ar');
    }

    function print_content() {
        $role=0;
        $db_conn = $this->db_conn;



    if ($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
    {
      echo "<table class='_90small_bold'>";
      echo	"<tr>";
      echo		"<td class='rc'>";
      echo			"<a title='back' href='expLoaderStart.php'>Back to Experiment Load Page</a> <br/>";
      echo		"</td>";
      echo	"</tr>";
      echo "</table>";
    }
    else
    {
      echo "&nbsp;<br>";
    }
    echo <<< EOT
    <br><br><br>
    <form   action="insertExperiment.php" method="POST">
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
 
 
 
 
 
 
 
 
 
 
