<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head> </head>
<body topmargin="0" leftmargin="0" rightmargin="0" style="font-family:Verdana">

<?php
//include the header page
include("header.php");
if (session_id() == "") session_start();
$maxExecutionTime=6000;
set_time_limit ( $maxExecutionTime );

$role=$_SESSION['role'];
if($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser"){}
else
{
 	 	header("location: index.php"); 
}
?>        
        <!-- <table cellpadding="0" cellspacing="0" width="95%" align="center">
        <tr>
                <td align="left">&nbsp;</td>
                <td align="right">&nbsp;</td>
        </tr>
        <tr>
                <td align="left">&nbsp;</td>
                <td align="right"><font color="#4682B4"><h5><a href='RefineSearch.php'>&lt;&lt;Back to Refine Search</a> | <a title='logout' href='index.php'>Log Out</a></h5></font></td>
        </tr>
		</table> -->
<?php
         //get session variabe
          $db_UN=$_SESSION['un'];
          $db_PASS=$_SESSION['pass'];
          $db_DB=$_SESSION['db'];
  
          //connection to the database
          $db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
      
        //get the search criteria from session
        $searchCriteria = $_SESSION['SearchCreiteria'];
        
        //get the search token from session
        $searchToken=$_SESSION['SearchString'];      
        
        //save search result into a session variable 
        $numrows=$_SESSION['totalSearchResult'];
	$results=$_SESSION['searchResult'];
	
	echo "<table border=0 width='90%' align='center'>\n";
        echo "<tr>\n";
      	echo "<td>";

        //echo "<b>" .$searchCriteria . ": $searchToken </b><br>";
        echo "<b>" .$numrows . " Results found</b><br>";
        
        $str2="PROB ID,CG<br>Number,Gene<br>Name,FlyBase Number,Experiment Name,Active<br>Category,Active<br>Species,Experiment<br>Subject,GO<br>Number,Bio Function,Regulation<br>Value,Fold Induction,Hour";
		$str="PROBEID CGNUMBER GENENAME FBCGNUMBER EXPERIMENTNAME ACTIVECATEGORY ACTIVESPECIES EXPERIMENTSUBJECT GONUMBER BIOFUNCTION REGULATIONVALUE ADDITIONALINFO,HOUR";
        $token2=explode(",",$str2);
		$token=str_word_count($str,1);
		
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
	echo "<td width='100%' align='center'>";
	echo "<input name='btn_submit' type='submit' value='Export Result'/>";
        echo "<input name='command' type='hidden' value='cmdStrRefinedAll'/>";
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
</form>
</body>
</html>
