<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head> </head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">

<?php
//include the header page
include("header.php");
if (session_id() == "") session_start();

$role=$_SESSION['role'];
if($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
{
	
}
else
{
 	echo "Access Denied";
	return;
}
$maxExecutionTime=6000;
set_time_limit ( $maxExecutionTime );
?>        
        <table cellpadding="0" cellspacing="0" width="95%" align="center">
        <tr>
                <td align="left">&nbsp;</td>
                <td align="right">&nbsp;</td>
        </tr>
        <tr>
                <td align="left">&nbsp;</td>
                <td align="right"><font color="#4682B4"><h5><a href='AdvancedQuery.php'>&lt;&lt;Back to Advanced Query</a> | <a title='logout' href='index.php'>Log Out</a></h5></font></td>
        </tr>
        

		</table>
<?php
         //get session variabe
          $db_UN=$_SESSION['un'];
          $db_PASS=$_SESSION['pass'];
          $db_DB=$_SESSION['db'];
  		  $userid=$_SESSION['userid'];

          //connection to the database
          $db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
          
          //get the search criteria from previous page
        //$SearchFrom = $_POST['searchFrom'];
    		
        //get the search criteria from previous page
        $PROBEID = $_POST['PROBEID'];
		$CGNUMBER = $_POST['CGNUMBER'];
		$FBCGNUMBER = $_POST['FBCGNUMBER'];
		$GENENAME = $_POST['GENENAME'];
		$GONUMBER = $_POST['GONUMBER'];
		       
        
        //get all the Unique array from session varialbe
        $EXPERIMENTNAME_S=$_SESSION['EXP_NAME_S'];
     	$ACTIVECATEGORY_S=$_SESSION['CATG_S'];
     	$ACTIVESPECIES_S=$_SESSION['SPEC_S'];
     	$EXPERIMENTSUBJECT_S=$_SESSION['SUBJ_S'];
		$BIOFUNCTION_S=$_SESSION['BIOFUNCTION_S'];
        
        //get rest of the search criteria
		//-----------BIOFUNCTION--------------------
        $BIOFUNCTION_TEMP=$_POST['BIOFUNCTION'];
        $BIOFUNCTION_TEMP_SIZE=sizeof($BIOFUNCTION_TEMP);
		$BIOFUNCTION="'" . $BIOFUNCTION_S[$BIOFUNCTION_TEMP[0]] . "'";
		if($BIOFUNCTION_TEMP_SIZE>1)
		{
			for($i=1;$i<$BIOFUNCTION_TEMP_SIZE;$i++)
				$BIOFUNCTION=$BIOFUNCTION ."," ."'" . $BIOFUNCTION_S[$BIOFUNCTION_TEMP[$i]] . "'";
		}

        //-----------Experiment name--------------------
        $EXPERIMENTNAME_TEMP=$_POST['EXP_NAME'];
        $EXPERIMENTNAME_TEMP_SIZE=sizeof($EXPERIMENTNAME_TEMP);
		$EXPERIMENTNAME="'" . $EXPERIMENTNAME_S[$EXPERIMENTNAME_TEMP[0]] . "'";
		if($EXPERIMENTNAME_TEMP_SIZE>1)
		{
			for($i=1;$i<$EXPERIMENTNAME_TEMP_SIZE;$i++)
				$EXPERIMENTNAME=$EXPERIMENTNAME ."," ."'" . $EXPERIMENTNAME_S[$EXPERIMENTNAME_TEMP[$i]] . "'";
		}	

		//---------------Active Category------------------------
        $ACTIVECATEGORY_TEMP=$_POST['CATG'];
        $ACTIVECATEGORY_TEMP_SIZE=sizeof($ACTIVECATEGORY_TEMP);
		$ACTIVECATEGORY="'" . $ACTIVECATEGORY_S[$ACTIVECATEGORY_TEMP[0]] . "'";
        if($ACTIVECATEGORY_TEMP_SIZE>1)
        {
			for($i=1;$i<$ACTIVECATEGORY_TEMP_SIZE;$i++)
				$ACTIVECATEGORY=$ACTIVECATEGORY ."," ."'" . $ACTIVECATEGORY_S[$ACTIVECATEGORY_TEMP[$i]] . "'";
		}		
		//---------------Active Species------------------------
        $ACTIVESPECIES_TEMP=$_POST['SPEC'];
        $ACTIVESPECIES_TEMP_SIZE=sizeof($ACTIVESPECIES_TEMP);
		$ACTIVESPECIES="'" . $ACTIVESPECIES_S[$ACTIVESPECIES_TEMP[0]] . "'";
        if($ACTIVESPECIES_TEMP_SIZE>1)
        {
			for($i=1;$i<$ACTIVESPECIES_TEMP_SIZE;$i++)
				$ACTIVESPECIES=$ACTIVESPECIES ."," ."'" . $ACTIVESPECIES_S[$ACTIVESPECIES_TEMP[$i]] . "'";
		}		
		//---------------Experiment Subject------------------------
        $EXPERIMENTSUBJECT_TEMP=$_POST['SUBJ'];
        $EXPERIMENTSUBJECT_TEMP_SIZE=sizeof($EXPERIMENTSUBJECT_TEMP);
		$EXPERIMENTSUBJECT="'" . $EXPERIMENTSUBJECT_S[$EXPERIMENTSUBJECT_TEMP[0]] . "'";
        if($EXPERIMENTSUBJECT_TEMP_SIZE>1)
        {
			for($i=1;$i<$EXPERIMENTSUBJECT_TEMP_SIZE;$i++)
				$EXPERIMENTSUBJECT=$EXPERIMENTSUBJECT ."," ."'" . $EXPERIMENTSUBJECT_S[$EXPERIMENTSUBJECT_TEMP[$i]] . "'";
		}        
        
		//----------------start building the where clause-------------------
        $str="";        
		$counter=0;

		echo "<table border=0 width='90%' align='center'>\n";
        echo "<tr>\n";
      	echo "<td>";

		echo "<table border=0>\n";
        echo "<tr>\n";
      	echo "<td>";
		echo"<br><br><fieldset>";

		//Check if user enter any PROBID
		$PROBEID_LTH=strlen(trim($PROBEID));
		if($PROBEID_LTH !=0 && strtoupper($PROBEID) != "ALL")
        {
			//Check how many PROBID user entered
			$token=explode(",",$PROBEID); 		
			$searchTokenStr="'" . trim($token[0]) . "'";			
			if(count($token)>1)
			{				
				for ($i=1;$i<count($token);$i++)
				{
					$searchTokenStr=$searchTokenStr ."," ."'" . trim($token[$i]) . "'";
				}
			}
			$str=$str . " PROBEID IN ($searchTokenStr)";
			$counter=$counter+1;
			echo "<b>PROBEID: </b>". $PROBEID . "<br>";
		}

		//Check if user enter any CGNUMBER		
		$CGNUMBER_LTH=strlen(trim($CGNUMBER));
        if($CGNUMBER_LTH !=0 && strtoupper($CGNUMBER) != "ALL")
        {
			//Check how many PROBID user entered
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
			//Check how many PROBID user entered
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
			//Check how many PROBID user entered
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
			//Check how many PROBID user entered
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
		
		
		
		 if(($BIOFUNCTION_TEMP[0]) !=0)
        {
         	if ($counter>0)
         		$str=$str . " and BIOFUNCTION IN ($BIOFUNCTION)";
         	else
				$str=$str . " BIOFUNCTION IN ($BIOFUNCTION)";
			$counter=$counter+1;
			echo "<b>BIOFUNCTION: </b>" . $BIOFUNCTION . "<br>";
		}		

		
        if(($EXPERIMENTNAME_TEMP[0]) !=0)
        {
         	if ($counter>0)
         		$str=$str . " and EXPERIMENTNAME IN ($EXPERIMENTNAME)";
         	else
				$str=$str . " EXPERIMENTNAME IN ($EXPERIMENTNAME)";
			$counter=$counter+1;
			echo "<b>EXPERIMENTNAME: </b>" . $EXPERIMENTNAME . "<br>";
		}		
		
        if(($ACTIVECATEGORY_TEMP[0]) !=0)
        {
         	if ($counter>0)
         		$str=$str . " and ACTIVECATEGORY IN ($ACTIVECATEGORY)";
         	else
				$str=$str . " ACTIVECATEGORY IN ($ACTIVECATEGORY)";
			$counter=$counter+1;
			echo "<b>ACTIVECATEGORY: </b>" . $ACTIVECATEGORY . "<br>";
		}		
		
        if(($ACTIVESPECIES_TEMP[0]) !=0)
        {
         	if ($counter>0)
         		$str=$str . " and ACTIVESPECIES IN ($ACTIVESPECIES)";
         	else
				$str=$str . " ACTIVESPECIES IN ($ACTIVESPECIES)";
			$counter=$counter+1;
			echo "<b>ACTIVESPECIES: </b>" . $ACTIVESPECIES . "<br>";
		}		
		
        if(($EXPERIMENTSUBJECT_TEMP[0]) !=0)
        {
         	if ($counter>0)
         		$str=$str . " and EXPERIMENTSUBJECT IN ($EXPERIMENTSUBJECT)";
         	else
				$str=$str . " EXPERIMENTSUBJECT IN ($EXPERIMENTSUBJECT)";
			$counter=$counter+1;
			echo "<b>EXPERIMENTSUBJECT: </b>" . $EXPERIMENTSUBJECT . "<br>";
		}
        
        
        //get value from database
		$notRestricted='0';
		$restricted='1';
        if ($counter==0)
        	$cmdstrRetrieve = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  where RESTRICTED='" .$notRestricted."' union SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  where RESTRICTED='" .$restricted."' and CREATED_BY='".$userid."' ORDER BY 5,1";
        else
        	$cmdstrRetrieve = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW where "  . $str . " AND RESTRICTED='" .$notRestricted."' UNION SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW where "  . $str . " AND RESTRICTED='" .$restricted."' and CREATED_BY='".$userid."' ORDER BY 5,1";
        
        $_SESSION['cmdStrCustom']=$cmdstrRetrieve;
        $parsed = ociparse($db_conn, $cmdstrRetrieve);
        ociexecute($parsed);        
        $numrows = ocifetchstatement($parsed, $results);
        if ($numrows>1000)
		{
			echo "<b>" .$numrows . " Results found</b><br>(Information listed below is partial view of search result)<br>";
			$numrows=1000;
		}
		else
		{
			echo "<b>" .$numrows . " Results found</b><br><br>";
		}

		echo"</fieldset><br><br>";
		echo "</td>";
		echo "</tr>\n";
        echo "</table>";
		//echo $cmdstrRetrieve; 
        //string for header
        $str2="PROB ID,CG<br>Number,Gene<br>Name,FlyBase<br>Number,Experiment Name,Active<br>Category,Active<br>Species,Experiment<br>Subject,GO<br>Number,Bio Function,Regulation<br>Value,Fold<br>Induction,Hour";
		$str="PROBEID CGNUMBER GENENAME FBCGNUMBER EXPERIMENTNAME ACTIVECATEGORY ACTIVESPECIES EXPERIMENTSUBJECT GONUMBER BIOFUNCTION REGULATIONVALUE ADDITIONALINFO,HOUR";
        $token2=explode(",",$str2);
		$token=str_word_count($str,1);   
		 
		//echo "<br>".$cmdstrRetrieve ."<br>";   
		
        echo "<font size=2pt>";
        echo "<center>";
        echo "<table border=1 cellspacing='0' width='100%'>\n";
        echo "<tr>\n";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[0]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[1]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[2]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[3]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[4]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[5]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[6]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[7]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[8]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[9]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[10]. "</b></td>";
      	echo "<td bgcolor='#F0FFF0'><b>" .$token2[11]. "</b></td>";
		echo "<td bgcolor='#F0FFF0'><b>" .$token2[12]. "</b></td>";
      	echo "</tr>\n";
      	
        for ($i = 0; $i < $numrows; $i++ )
    	{
			if(($i%2)==1)
			{
				echo "<tr>\n";
				echo "<td bgcolor='#DDDDDD'> " . $results["$token[0]"][$i]. "</td>";
				echo "<td bgcolor='#DDDDDD'> <a href ='http://flybase.org/cgi-bin/uniq.html?species=Dmel&field=SYN&db=fbgn&context=" . $results["$token[1]"][$i] . "&authors=&year=&alltext=&caller=quicksearch' target=_blank>" .$results["$token[1]"][$i]. "</a></td>";
				echo "<td bgcolor='#DDDDDD'> <a href ='http://flybase.org/cgi-bin/uniq.html?species=Dmel&field=SYN&db=fbgn&context=" . $results["$token[2]"][$i] . "&authors=&year=&alltext=&caller=quicksearch' target=_blank>" .$results["$token[2]"][$i]. "</a></td>";
				echo "<td bgcolor='#DDDDDD'> <a href= 'http://flybase.org/reports/" . $results["$token[3]"][$i] . ".html' target=_blank>" .$results["$token[3]"][$i]. "</a></td>";
				echo "<td bgcolor='#DDDDDD'> " .$results["$token[4]"][$i]. "</td>";
				echo "<td bgcolor='#DDDDDD'> " .$results["$token[5]"][$i]. "</td>";
				echo "<td bgcolor='#DDDDDD'>" . $results["$token[6]"][$i]. "</td>";
				echo "<td bgcolor='#DDDDDD'> " .$results["$token[7]"][$i]. "</td>";
				
				if(strlen($results["$token[8]"][$i]) < 1)
					echo "<td bgcolor='#DDDDDD'> " ."UNKNOWN". "</td>";
				else
					echo "<td bgcolor='#DDDDDD'> " .$results["$token[8]"][$i]. "</td>";
				if(strlen($results["$token[9]"][$i]) < 1)
					echo "<td bgcolor='#DDDDDD'> " ."UNKNOWN". "</td>";
				else
					echo "<td bgcolor='#DDDDDD'> " .$results["$token[9]"][$i]. "</td>";

				echo "<td bgcolor='#DDDDDD'> " .$results["$token[10]"][$i]. "</td>";
				echo "<td bgcolor='#DDDDDD'> " .number_format($results["$token[11]"][$i],3,'.',''). "</td>";
				echo "<td bgcolor='#DDDDDD'> " .$results["$token[12]"][$i]. "</td>";
				echo "</tr>\n";
			}
			else
			{
				echo "<tr>\n";
				echo "<td> " . $results["$token[0]"][$i]. "</td>";
				echo "<td> <a href ='http://flybase.org/cgi-bin/uniq.html?species=Dmel&field=SYN&db=fbgn&context=" . $results["$token[1]"][$i] . "&authors=&year=&alltext=&caller=quicksearch' target=_blank>" .$results["$token[1]"][$i]. "</a></td>";
				echo "<td> <a href ='http://flybase.org/cgi-bin/uniq.html?species=Dmel&field=SYN&db=fbgn&context=" . $results["$token[2]"][$i] . "&authors=&year=&alltext=&caller=quicksearch' target=_blank>" .$results["$token[2]"][$i]. "</a></td>";
				echo "<td> <a href= 'http://flybase.org/reports/" . $results["$token[3]"][$i] . ".html' target=_blank>" .$results["$token[3]"][$i]. "</a></td>";
				echo "<td> " .$results["$token[4]"][$i]. "</td>";
				echo "<td> " .$results["$token[5]"][$i]. "</td>";
				echo "<td>" . $results["$token[6]"][$i]. "</td>";
				echo "<td> " .$results["$token[7]"][$i]. "</td>";
				
				if(strlen($results["$token[8]"][$i]) < 1)
					echo "<td> " ."UNKNOWN". "</td>";
				else
					echo "<td> " .$results["$token[8]"][$i]. "</td>";
				if(strlen($results["$token[9]"][$i]) < 1)
					echo "<td> " ."UNKNOWN". "</td>";
				else
					echo "<td> " .$results["$token[9]"][$i]. "</td>";

				echo "<td> " .$results["$token[10]"][$i]. "</td>";
				echo "<td> " .number_format($results["$token[11]"][$i],3,'.',''). "</td>";
				echo "<td> " .$results["$token[12]"][$i]. "</td>";
				echo "</tr>\n";
			}
    	}
    	echo "</table></center>";
    	echo "</font>";

		echo "<form action='exportToExcel.php' method='post' name='index'>";
		echo "<table cellpadding='0' cellspacing='0' width='100%' border='0'>";
		echo "<tr>";
		echo "<td width='100%' align='center'><br>";
		echo "<input name='btn_submit' type='submit' value='Export Result'/>";
	        echo "<input name='command' type='hidden' value='cmdStrCustom'/>";
	        echo "</td>";
                echo "</tr>";
	        echo "<tr><td align='center'>[ data exporting is limited up to 5000 rows ]<td></tr>";	
	        echo "<tr><td>&nbsp;<td></tr>";	
		echo "</table>";
		echo "</form>";
		echo "</td>";
		echo "</tr>\n";
        echo "</table>";
        //close database connection
		oci_close($db_conn);  
  ?>
</body>
</html>
