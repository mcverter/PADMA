<?php
include ("control_functions.php");
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

  <?php include("header.php");

error_log($db_conn);
//get the search criteria from previous page
$searchCriteria = $_POST['searchCriteria'];


//get the search token from previous page
$searchToken=$_POST['txt_searchToken'];
$SearchTokenParts=explode(",",$searchToken);

$newSearchToken="'". trim($SearchTokenParts[0]) ."'";
if (count($SearchTokenParts) > 1) {
  for ($i=1; $i<count($SearchTokenParts); $i++)
    $newSearchToken=$newSearchToken ."," . "'". trim($SearchTokenParts[$i]) ."'";
}


get_standard_search_inputs();
get_experiment_name();
get_active_category()
get_active_species();
get_experiment_subj();
get_regulation_value();

					    echo "<table class='_90c'>\n";
    echo "<tr>\n";
    echo "<td>";
    echo "<table border=0>\n";
    echo "<tr>\n";
    echo "<td>";
    echo"<br><br><fieldset>";
    echo "<br><b>" . $searchCriteria . ":</b> ";
    echo $searchToken . "<br>";

    //get matrix value from database
    $restricted='1';
    $notRestricted='0';
    $userid=$_POST['userid'];

    $cmdstrRetrieve = "SELECT DISTINCT PROBEID, CGNUMBER, GENENAME, FBCGNUMBER,EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V  WHERE RESTRICTED='" .$notRestricted."' and $searchCriteria IN ($newSearchToken)";
$cmdstrRetrieve2="SELECT DISTINCT PROBEID, CGNUMBER, GENENAME, FBCGNUMBER,EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V  WHERE RESTRICTED='" .$restricted."' and CREATED_BY='".$userid."' and $searchCriteria IN ($newSearchToken)";

add_experiment_name();
add_active_category();
add_active_species();
add_experiemnt_subject();
add_regulation_value() ;


    //$cmdstrRetrieve=$cmdstrRetrieve . " order by EXPERIMENTNAME,PROBEID";
    $cmdstrRetrieveUnion=$cmdstrRetrieve . " union " . $cmdstrRetrieve2 . " ORDER BY 5,1";

    $_POST['cmdStrQuick']=$cmdstrRetrieveUnion;
    //echo $cmdstrRetrieveUnion;
    //echo $cmdstrRetrieve;

    //$parsed = ociparse($db_conn, $cmdstrRetrieve);
    $parsed = ociparse($db_conn, $cmdstrRetrieveUnion);
    ociexecute($parsed);
    $numrows = ocifetchstatement($parsed, $results);
    echo "<b>Search Result: " .$numrows . "</b><br><br>";
    echo"</fieldset><br><br>";
    echo "</td>";
    echo "</tr>\n";
    echo "</table>";


    $str2="PROB ID,CG<br>Number,Gene<br>Name,FlyBase Number,Experiment Name,Active<br>Category,Active<br>Species,Experiment<br>Subject,Regulation<br>Value,Fold<br>Induction,Hour";
    $str="PROBEID CGNUMBER GENENAME FBCGNUMBER EXPERIMENTNAME ACTIVECATEGORY ACTIVESPECIES EXPERIMENTSUBJECT REGULATIONVALUE ADDITIONALINFO,HOUR";
    $token2=explode(",",$str2);
    $token=str_word_count($str,1);

    echo "<font size=2pt>";
    echo "<center>";
    echo "<table class='_100borderwhite'>\n";
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
    echo "<td bgcolor='#DDDDDD'>" . $results["$token[4]"][$i]. "</td>";
    echo "<td bgcolor='#DDDDDD'> " .$results["$token[5]"][$i]. "</td>";
    echo "<td bgcolor='#DDDDDD'> " .$results["$token[6]"][$i]. "</td>";
    echo "<td bgcolor='#DDDDDD'>" . $results["$token[7]"][$i] . "</td>";
    echo "<td bgcolor='#DDDDDD'> " .$results["$token[8]"][$i]. "</td>";
    echo "<td bgcolor='#DDDDDD'> " .number_format($results["$token[9]"][$i],3,'.',''). "</td>";
    echo "<td bgcolor='#DDDDDD'> " .$results["$token[10]"][$i]. "</td>";
    echo "</tr>\n";
    }
    else
    {
    echo "<tr>\n";
    echo "<td> " . $results["$token[0]"][$i]. "</td>";
    echo "<td> <a href ='http://flybase.org/cgi-bin/uniq.html?species=Dmel&field=SYN&db=fbgn&context=" . $results["$token[1]"][$i] . "&authors=&year=&alltext=&caller=quicksearch' target=_blank>" .$results["$token[1]"][$i]. "</a></td>";
    echo "<td> <a href ='http://flybase.org/cgi-bin/uniq.html?species=Dmel&field=SYN&db=fbgn&context=" . $results["$token[2]"][$i] . "&authors=&year=&alltext=&caller=quicksearch' target=_blank>" .$results["$token[2]"][$i]. "</a></td>";
    echo "<td> <a href= 'http://flybase.org/reports/" . $results["$token[3]"][$i] . ".html' target=_blank>" .$results["$token[3]"][$i]. "</a></td>";
    echo "<td>" . $results["$token[4]"][$i]. "</td>";
    echo "<td> " .$results["$token[5]"][$i]. "</td>";
    echo "<td> " .$results["$token[6]"][$i]. "</td>";
    echo "<td>" . $results["$token[7]"][$i] . "</td>";
    echo "<td> " .$results["$token[8]"][$i]. "</td>";
    echo "<td> " .number_format($results["$token[9]"][$i],3,'.',''). "</td>";
    echo "<td> " .$results["$token[10]"][$i]. "</td>";
    echo "</tr>\n";
    }
    }
    echo "</table></center>";
    echo "</font>";
    echo "<form action='exportToExcel.php' method='post' name='index'>";
    echo "<table class='_100'>";
    echo "<tr>";
    echo "<td class='_100c'><br>";
    echo "<input name='btn_submit' type='submit' value='Export Result'/>";
    echo "<input name='command' type='hidden' value='cmdStrQuick'/>";
    echo "</td>";
    echo "</tr>";
    echo "<tr><td class='_C'>[ data exporting is limited up to 5000 rows ]<td></tr>";

    //close database connection
  </body>
</html>

<?php oci_close($db_conn);  ?>






