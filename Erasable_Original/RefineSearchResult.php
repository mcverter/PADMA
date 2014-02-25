<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head> </head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">

<?php
//include the header page
include("header.php");
session_start();
$maxExecutionTime=6000;
set_time_limit ( $maxExecutionTime );
		
$role=$_SESSION['role'];
if($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
{
	
}
else
{
 	echo "Access Denied";
	return;
}
?>        
        <table cellpadding="0" cellspacing="0" width="95%" align="center">        
        <tr>
                <td align="left">&nbsp;</td>
                <td align="right"><font color="#4682B4"><h5><a href='RefineSearch.php'>&lt;&lt;Back to Refine Search</a> | <a title='logout' href='index.php'>Log Out</a></h5></font></td>
        </tr>
        

		</table>
<?php
         //get session variabe
          $db_UN=$_SESSION['un'];
          $db_PASS=$_SESSION['pass'];
          $db_DB=$_SESSION['db'];

//connection to the database
$db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
if (! $db_conn)
{
	$e = oci_error(); 		
	echo "<font color='red'>";
	print htmlentities($e['message']);
	echo "<br>ERROR: Connecting to Database, Please try back later<br>";
	echo "</font>";
	echo "<a title='logout' href='index.php'>Click Here</a> to go back to home page";
	exit;
}

		//get the search criteria from previous page
        $PROBEID ="";
		$CGNUMBER ="";
		$FBCGNUMBER ="";
		$GENENAME = "";
		$GONUMBER = "";

		$PROBEID = $_POST['PROBEID'];
		$CGNUMBER = $_POST['CGNUMBER'];
		$FBCGNUMBER = $_POST['FBCGNUMBER'];
		$GENENAME = $_POST['GENENAME'];
		$GONUMBER = $_POST['GONUMBER'];
		if(!(strlen(trim($PROBEID))>0 || strlen(trim($CGNUMBER))>0 || strlen(trim($FBCGNUMBER))>0 || strlen(trim($GENENAME))>0 || strlen(trim($GONUMBER))>0))
		{
			echo "<table width='75%' align='center'><tr><td align='center'>";
				exit("Please Enter a Search Criteria");
			echo"</td></tr></table>";

		}

		$counter=1;
		$restricted='1';
		$notRestricted='0';
		$userid=$_SESSION['userid'];
		
		//Check if user enter any PROBID
		$PROBEID_LTH=strlen(trim($PROBEID));
		 if($PROBEID_LTH !=0 && strtoupper($PROBEID) != "ALL")
        {
			$token=explode(",",$PROBEID); 			
			$searchTokenStr="'" . trim($token[0]) . "'";			
			
			if(count($token)>1)
			{				
				for ($i=1;$i<count($token);$i++)
				{
					$searchTokenStr=$searchTokenStr ."," ."'" . trim($token[$i]) . "'";
				}
			}

			$str=$str . " and PROBEID IN ($searchTokenStr)";
			$counter=$counter+1;
			echo "<b>PROBEID: </b>". $PROBEID . "<br>";
		}

		//Check if user enter any CGNUMBER		
		$CGNUMBER_LTH=strlen(trim($CGNUMBER));
        if($CGNUMBER_LTH !=0 && strtoupper($CGNUMBER) != "ALL")
        {
			$token=explode(",",$CGNUMBER); 			
			$searchTokenStr="'" . trim($token[0]) . "'";			
			
			if(count($token)>1)
			{				
				for ($i=1;$i<count($token);$i++)
				{
					$searchTokenStr=$searchTokenStr ."," ."'" . trim($token[$i]) . "'";
				}
			}

         	if ($counter>0)
				$str=$str . " and CGNUMBER IN ($searchTokenStr)";
			else
				$str=$str . " CGNUMBER IN ($searchTokenStr)";
			$counter=$counter+1;
			echo "<b>CGNUMBER: </b>" . $CGNUMBER . "<br>";
		}

		//Check if user enter any FBCGNUMBER		
		$FBCGNUMBER_LTH=strlen(trim($FBCGNUMBER));
        if($FBCGNUMBER_LTH !=0 && strtoupper($FBCGNUMBER) != "ALL")
        {
			$token=explode(",",$FBCGNUMBER); 			
			$searchTokenStr="'" . trim($token[0]) . "'";			
			
			if(count($token)>1)
			{				
				for ($i=1;$i<count($token);$i++)
				{
					$searchTokenStr=$searchTokenStr ."," ."'" . trim($token[$i]) . "'";
				}
			}

         	if ($counter>0)
				$str=$str . " and FBCGNUMBER IN ($searchTokenStr)";
			else
				$str=$str . " FBCGNUMBER IN ($searchTokenStr)";
			$counter=$counter+1;
			echo "<b>FBCGNUMBER: </b>" . $FBCGNUMBER . "<br>";
		}

		//Check if user enter any GENENAME		
		$GENENAME_LTH=strlen(trim($GENENAME));
        if($GENENAME_LTH !=0 && strtoupper($GENENAME) != "ALL")
        {			
			$token=explode(",",$GENENAME); 			
			$searchTokenStr="'" . trim($token[0]) . "'";			
			
			if(count($token)>1)
			{				
				for ($i=1;$i<count($token);$i++)
				{
					$searchTokenStr=$searchTokenStr ."," ."'" . trim($token[$i]) . "'";
				}
			}

         	if ($counter>0)
				$str=$str . " and GENENAME IN ($searchTokenStr)";
			else
				$str=$str . " GENENAME IN ($searchTokenStr)";
			$counter=$counter+1;
			echo "<b>GENENAME: </b>" . $GENENAME . "<br>";
		}

		//Check if user enter any GONUMBER		
		$GONUMBER_LTH=strlen(trim($GONUMBER));
        if($GONUMBER_LTH !=0 && strtoupper($GONUMBER) != "ALL")
        {
			$token=explode(",",$GONUMBER); 			
			$searchTokenStr="'" . trim($token[0]) . "'";			
			
			if(count($token)>1)
			{				
				for ($i=1;$i<count($token);$i++)
				{
					$searchTokenStr=$searchTokenStr ."," ."'" . trim($token[$i]) . "'";
				}
			}
         	if ($counter>0)
				$str=$str . " and GONUMBER IN ($searchTokenStr)";
			else
				$str=$str . " GONUMBER IN ($searchTokenStr)";
			$counter=$counter+1;
			echo "<b>GONUMBER: </b>" . $GONUMBER . "<br>";
		}

       
		
        //get matrix value from database
        $cmdstrRetrieve = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  WHERE RESTRICTED='" .$notRestricted."' $str union SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  WHERE RESTRICTED='" .$restricted."' and CREATED_BY='".$userid."' $str order by 5,1";
        $parsed = ociparse($db_conn, $cmdstrRetrieve);
        ociexecute($parsed);        
        $numrows = ocifetchstatement($parsed, $results);
        

		//echo $cmdstrRetrieve . "<br>";
        //save search result into a session variable 
        
        $_SESSION['totalSearchResult']=$numrows;
		$_SESSION['searchResult']=$results;
		$_SESSION['SearchCreiteria']=$str;
		//$_SESSION['SearchString']=$searchToken;
		$_SESSION['cmdStrRefinedAll']=$cmdstrRetrieve;
		
        echo "<b>" .$numrows . " Results found<br> <a href='RefineSearchResultAll.php' target='blank'> Click Here </a>to see all the result <br> or<br> Select from below for refine search<br>   </b><br>";
        $str="PROBEID CGNUMBER GENENAME FBCGNUMBER EXPERIMENTNAME ACTIVECATEGORY ACTIVESPECIES EXPERIMENTSUBJECT GONUMBER BIOFUNCTION REGULATIONVALUE ADDITIONALINFO,HOUR";
        $token=str_word_count($str,1);
       
    	
    	//Create an array with unique Bio Function,Experiment Subject,Active Species,Active Category and Regulation Value
    	$BioFunction[]="ALL";
    	$ExperimentSubject[]="ALL";
    	$ActiveSpecies[]="ALL";
    	$ActiveCategory[]="ALL";
    	$RegulationValue[]="ALL";
    	
    	for ($i = 0; $i < $numrows; $i++ )
    	{
			$BioFunction[]=$results["$token[9]"][$i];
			$ExperimentSubject[]=$results["$token[7]"][$i];
			$ActiveSpecies[]=$results["$token[6]"][$i];
			$ActiveCategory[]=$results["$token[5]"][$i];
			$RegulationValue[]=$results["$token[10]"][$i];
			
		}
		$UniqueBioFunction=array();
		$UniqueExperimentSubject=array();
		$UniqueActiveSpecies=array();
		$UniqueActiveCategory=array();
		$UniqueRegulationValue=array();

        //$UniqueBioFunction=(array_unique($BioFunction));
        //$UniqueExperimentSubject=(array_unique($ExperimentSubject));
        //$UniqueActiveSpecies=(array_unique($ActiveSpecies));
        //$UniqueActiveCategory=(array_unique($ActiveCategory));
        //$UniqueRegulationValue=(array_unique($RegulationValue));


		$UniqueBioFunction[0]=$BioFunction[0];
        $UniqueExperimentSubject[0]=$ExperimentSubject[0];
        $UniqueActiveSpecies[0]=$ActiveSpecies[0];
        $UniqueActiveCategory[0]=$ActiveCategory[0];
		$UniqueRegulationValue[0]=$RegulationValue[0];
		
		//-------------Unique Bio function-----------------------------
		for ($i = 1; $i <count($BioFunction); $i++ )
		{	
			$match=0;
			for ($j = 0; $j <count($UniqueBioFunction); $j++ )
			{
				if($UniqueBioFunction[$j]==$BioFunction[$i])
				{
					$match=1;					
				}				
			}			
			if($match==0)
			{
				$UniqueBioFunction[count($UniqueBioFunction)]=$BioFunction[$i];
			}	
			
		}

		//-------------Unique UniqueExperimentSubject-----------------------------
		for ($i = 1; $i <count($ExperimentSubject); $i++ )
		{	
			$match=0;
			for ($j = 0; $j <count($UniqueExperimentSubject); $j++ )
			{
				if($UniqueExperimentSubject[$j]==$ExperimentSubject[$i])
				{
					$match=1;					
				}				
			}			
			if($match==0)
			{
				$UniqueExperimentSubject[count($UniqueExperimentSubject)]=$ExperimentSubject[$i];
			}	
			
		}

		//-------------Unique UniqueActiveSpecies-----------------------------
		for ($i = 1; $i <count($ActiveSpecies); $i++ )
		{	
			$match=0;
			for ($j = 0; $j <count($UniqueActiveSpecies); $j++ )
			{
				if($UniqueActiveSpecies[$j]==$ActiveSpecies[$i])
				{
					$match=1;					
				}				
			}			
			if($match==0)
			{
				$UniqueActiveSpecies[count($UniqueActiveSpecies)]=$ActiveSpecies[$i];
			}	
			
		}
		//-------------Unique UniqueActiveCategory-----------------------------
		for ($i = 1; $i <count($ActiveCategory); $i++ )
		{	
			$match=0;
			for ($j = 0; $j <count($UniqueActiveCategory); $j++ )
			{
				if($UniqueActiveCategory[$j]==$ActiveCategory[$i])
				{
					$match=1;					
				}				
			}			
			if($match==0)
			{
				$UniqueActiveCategory[count($UniqueActiveCategory)]=$ActiveCategory[$i];
			}	
			
		}
		//-------------Unique RegulationValue-----------------------------
		for ($i = 1; $i <count($RegulationValue); $i++ )
		{	
			$match=0;
			for ($j = 0; $j <count($UniqueRegulationValue); $j++ )
			{
				if($UniqueRegulationValue[$j]==$RegulationValue[$i])
				{
					$match=1;					
				}				
			}			
			if($match==0)
			{
				$UniqueRegulationValue[count($UniqueRegulationValue)]=$RegulationValue[$i];
			}	
			
		}

        //save all the Unique array into session varialbe
        $_SESSION['S_UniqueBioFunction']=$UniqueBioFunction;
        $_SESSION['S_UniqueExperimentSubject']=$UniqueExperimentSubject;
        $_SESSION['S_UniqueActiveSpecies']=$UniqueActiveSpecies;
        $_SESSION['S_UniqueActiveCategory']=$UniqueActiveCategory;
        $_SESSION['S_UniqueRegulationValue']=$UniqueRegulationValue;        
        
        echo "<form action='RefineSearchResultRefined.php' method='post' name='refine'>";
        echo "<table cellpadding='2' cellspacing='2'  width='75%' align='center' style='font-family:Verdana; font-size:small'><tr><td>";
        echo "<fieldset>";
        echo "<table cellpadding='2' cellspacing='2' bgcolor='#F0FFF0' width='100%' align='center' style='font-family:Verdana; font-size:small'>";
		echo	"<tr>";
		echo        "<td align='left' width='30%'>&nbsp;<br />";
		echo        	"<b>Bio Function:</b>&nbsp;&nbsp;";
		echo        "</td>";
		echo        "<td align='left' width='70%'>&nbsp;<br />";
		echo 			"<select name='BioFunction[]' multiple='multiple' style='width:75%; font-family:verdana'>";
							for ($i=0;$i<=count($UniqueBioFunction);$i++)
                			{             
        echo 					"<option value=" . $i . ">" . $UniqueBioFunction[$i] . "</option>";
                			}
        echo 			"</select>";                                                                                                                                                  
		echo        "</td>";
		echo    "</tr>";
		
		echo	"<tr>";
		echo        "<td align='left' width='30%'>&nbsp;<br />";
		echo        	"<b>Experiment Subject:</b>&nbsp;&nbsp;";
		echo        "</td>";
		echo        "<td align='left' width='70%'>&nbsp;<br />";
		echo 			"<select name='ExperimentSubject[]' multiple='multiple' style='width:75%; font-family:verdana'>";
							for ($i=0;$i<=count($UniqueExperimentSubject);$i++)
                			{          
        echo 					"<option value=" . $i . ">" . $UniqueExperimentSubject[$i] . "</option>";
                			}
        echo 			"</select>";                                                                                                                                                
		echo        "</td>";
		echo    "</tr>";
		
		echo	"<tr>";
		echo        "<td align='left' width='30%'>&nbsp;<br />";
		echo        	"<b>Active Species:</b>&nbsp;&nbsp;";
		echo        "</td>";
		echo        "<td align='left' width='70%'>&nbsp;<br />";
		echo 			"<select name='ActiveSpecies[]' multiple='multiple' style='width:75%; font-family:verdana'>";
							for ($i=0;$i<=count($UniqueActiveSpecies);$i++)
                			{                              
        echo 					"<option value=" . $i . ">" . $UniqueActiveSpecies[$i] . "</option>";
                			}
        echo 			"</select>";                                                                                                                                                  
		echo        "</td>";
		echo    "</tr>";
		
		echo	"<tr>";
		echo        "<td align='left' width='30%'>&nbsp;<br />";
		echo        	"<b>Active Category:</b>&nbsp;&nbsp;";
		echo        "</td>";
		echo        "<td align='left' width='70%'>&nbsp;<br />";
		echo 			"<select name='ActiveCategory[]' multiple='multiple' style='width:75%; font-family:verdana'>";
							for ($i=0;$i<=count($UniqueActiveCategory);$i++)
                			{                    
        echo 					"<option value=" . $i . ">" . $UniqueActiveCategory[$i] . "</option>";
                			}
        echo 			"</select>";                                                                                                                                                 
		echo        "</td>";
		echo    "</tr>";
		
		echo	"<tr>";
		echo        "<td align='left' width='30%'>&nbsp;<br />";
		echo        	"<b>Regulation Value:</b>&nbsp;&nbsp;";
		echo        "</td>";
		echo        "<td align='left' width='70%'>&nbsp;<br />";
		echo 			"<select name='RegulationValue[]' multiple='multiple' style='width:75%; font-family:verdana'>";
							
							for ($i=0;$i<=count($UniqueRegulationValue);$i++)
                			{                    
        echo 					"<option value=" . $i . ">" . $UniqueRegulationValue[$i] . "</option>";
                			}

        echo 			"</select>";                                                                                                                                                 
		echo        "</td>";
		echo    "</tr>";
		echo    "</TABLE>";
		echo "</fieldset>";
		echo "</td></tr></table>";
		

        //close database connection
		oci_close($db_conn);  
  ?>
  <table cellpadding="5" cellspacing="0" width="100%"border="0"><tr>
	<td width="100%" align="center">
		<input name="btn_submit" type="submit" value="Submit"/>
	</td></tr>
</table>
<?php echo"</form"; ?>
</body>
</html>
