<?php


//[Fri Feb 14 11:53:03 2014] [error] [client ::1] query is SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V where  PROBEID IN ('141217_at') and ACTIVECATEGORY IN ('Development','Fungal','Microbial','Mutant','Parasitoid') and ACTIVESPECIES IN ('A.tabida','B. bassiana','B. bassiana Spz','Dif1','Dorsal1','E. coli','E. coli M. leutus','E. coli M. luteus','E. coli OreR','E. coli Rel','E.coli M.leutus Rel','E.coli M.leutus Spz','Hop tum-l','L.boulardi','L.heterotoma','NURF 301 Delta C','Rel E20','Toll10b','W1118') and EXPERIMENTSUBJECT IN ('Hemocyte','Larvae','Prepupae') AND RESTRICTED='0' UNION SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V where  PROBEID IN ('141217_at') and ACTIVECATEGORY IN ('Development','Fungal','Microbial','Mutant','Parasitoid') and ACTIVESPECIES IN ('A.tabida','B. bassiana','B. bassiana Spz','Dif1','Dorsal1','E. coli','E. coli M. leutus','E. coli M. luteus','E. coli OreR','E. coli Rel','E.coli M.leutus Rel','E.coli M.leutus Spz','Hop tum-l','L.boulardi','L.heterotoma','NURF 301 Delta C','Rel E20','Toll10b','W1118') and EXPERIMENTSUBJECT IN ('Hemocyte','Larvae','Prepupae') AND RESTRICTED='1' and CREATED_BY='AKIRA' ORDER BY 5,1\n, referer: http://localhost/old_PADMA/PADMA/AdvancedQuery.php


function display_results() {

$numrows=0;

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
    echo <<< EOT
    <font size=2pt>
    <center>
    <table class='_100b1'>
    <tr>
    <td bgcolor='#F0FFF0'><b>" .$token2[0]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[1]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[2]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[3]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[4]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[5]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[6]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[7]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[8]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[9]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[10]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[11]. "</b></td>
    <td bgcolor='#F0FFF0'><b>" .$token2[12]. "</b></td>
    </tr>
EOT;

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

  }


function allow_export() {
    echo <<< EOT
    </table></center>
    </font>

    <form action='exportToExcel.php' method='post' name='index'>
    <table class='_100'>
    <tr>
    <td class='_100c'><br>
    <input name='btn_submit' type='submit' value='Export Result'/>
    <input name='command' type='hidden' value='cmdStrCustom'/>
    </td>
    </tr>
    <tr><td class='_C'>[ data exporting is limited up to 5000 rows ]<td></tr>
    <tr><td>&nbsp;<td></tr>
    </table>
    </form>
    </td>
    </tr>\n
    </table>    
EOT;

}
function build_query () {
  error_log(print_r($_POST, true));
  $multiple_select_inputs = array( "BIOFUNCTION",
			      "EXPERIMENTNAME",
			      "ACTIVECATEGORY",
			      "ACTIVESPECIES",
			      "EXPERIMENTSUBJECT",
			      "REGULATIONVALUE",
				   );

  $text_field_inputs = array(
			       "PROBEID",
			       "CGNUMBER",
			       "GENENAME",
			       "FBCGNUMBER",
			       "GONUMBER",
			       "ADDITIONALINFO",
			       "RESTRICTED",
			       "CREATED_BY",	
			       "HOUR"
			     );

  $query_string = " SELECT "; 
  $query_string .= join($multiple_select_inputs, " , " ) . " , " .
    join($text_field_inputs, " , " );
  $query_string .= " WHERE 1 ";
  

  foreach ($text_field_inputs as $constraint)
    {
      if (isset($_POST[$constraint]) && 
	  ($posted=$_POST[$constraint]))
	{
	  $posted_arr = explode("," , $posted);
	  error_log ("constraint $constraint posted str: $posted: arr : " . print_r($posted_arr, true));
	  $query_string .= " AND $constraint IN " . 
	    extract_csv_from_array($posted_arr);
	}
    }
  foreach ($multiple_select_inputs as $constraint) 
    {
      if (isset($_POST[$constraint]) && 
	  ( $posted=$_POST[$constraint]))
	{
	  error_log ("constraint $constraint posted arr : " . print_r($posted, true));
	  $query_string .= " AND $constraint IN " . 
	    extract_csv_from_array($posted);
	}
    }
  error_log($query_string);
  }



function extract_csv_from_array($arr) 
{
  $csv = " ( '" . array_pop($arr) . "'"; 
  foreach ($arr as $v)
    {
      $csv .= " , '$v' ";
    }
  $csv .= ") ";
  return $csv;
}

?>
