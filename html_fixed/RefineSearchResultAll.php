<?
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();
?>


<!DOCTYPE html>

<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />

  </head>
  <body>
    <?php include("header.php");  ?>

    <?php

    //get the search criteria from session
    $searchCriteria = $_POST['SearchCreiteria'];

    //get the search token from session
    $searchToken=$_POST['SearchString'];

    //save search result into a session variable
    $numrows=$_POST['totalSearchResult'];
    $results=$_POST['searchResult'];

    echo "<table class='_90c'>\n";
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
    echo "<table class='_100b1'>\n";
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
    echo "<table class='_100'>";
    echo "<tr>";
    echo "<td class='_100c'>";
    echo "<input name='btn_submit' type='submit' value='Export Result'/>";
    echo "<input name='command' type='hidden' value='cmdStrRefinedAll'/>";
    echo "</td>";
    echo "</tr>";
    echo "<tr><td class='_C'>[ data exporting is limited up to 5000 rows ]<td></tr>";
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








