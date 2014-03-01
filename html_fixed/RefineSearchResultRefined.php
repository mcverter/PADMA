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
    $searchCriteria = $_SESSION['SearchCreiteria'];

    //get the search token from session
    //$searchToken=$_SESSION['SearchString'];

    //get all the Unique array from session varialbe
    $UniqueBioFunction=$_SESSION['S_UniqueBioFunction'];
    $UniqueExperimentSubject=$_SESSION['S_UniqueExperimentSubject'];
    $UniqueActiveSpecies=$_SESSION['S_UniqueActiveSpecies'];
    $UniqueActiveCategory=$_SESSION['S_UniqueActiveCategory'];
    $UniqueRegulationValue=$_SESSION['S_UniqueRegulationValue'];

    //get all the refined search criteria
    //------------Bio Function------------------
    $RefinedBioFunctionTokenTemp=$_POST['BioFunction'];
    $RefinedBioFunctionTokenTempSize=sizeof($RefinedBioFunctionTokenTemp);
    $RefinedBioFunctionToken="'" . $UniqueBioFunction[$RefinedBioFunctionTokenTemp[0]] . "'";

    if($RefinedBioFunctionTokenTempSize>1)
    {
      for($i=1;$i<$RefinedBioFunctionTokenTempSize;$i++)
	$RefinedBioFunctionToken=$RefinedBioFunctionToken ."," ."'" . $UniqueBioFunction[$RefinedBioFunctionTokenTemp[$i]] . "'";
    }

    //------------Experiment Subject---------------------
    $RefinedExperimentSubjectTokenTemp=$_POST['ExperimentSubject'];
    $RefinedExperimentSubjectTokenTempSize=sizeof($RefinedExperimentSubjectTokenTemp);
    $RefinedExperimentSubjectToken="'" . $UniqueExperimentSubject[$RefinedExperimentSubjectTokenTemp[0]] . "'";

    if($RefinedExperimentSubjectTokenTempSize>1)
    {
      for($i=1;$i<$RefinedExperimentSubjectTokenTempSize;$i++)
	$RefinedExperimentSubjectToken=$RefinedExperimentSubjectToken ."," ."'" . $UniqueExperimentSubject[$RefinedExperimentSubjectTokenTemp[$i]] . "'";
    }

    //---------------Active Species--------------------
    $RefinedActiveSpeciesTokenTemp=$_POST['ActiveSpecies'];
    $RefinedActiveSpeciesTokenTempSize=sizeof($RefinedActiveSpeciesTokenTemp);
    $RefinedActiveSpeciesToken="'" . $UniqueActiveSpecies[$RefinedActiveSpeciesTokenTemp[0]] . "'";
    if($RefinedActiveSpeciesTokenTempSize>1)
    {
      for($i=1;$i<$RefinedActiveSpeciesTokenTempSize;$i++)
	$RefinedActiveSpeciesToken=$RefinedActiveSpeciesToken ."," ."'" . $UniqueActiveSpecies[$RefinedActiveSpeciesTokenTemp[$i]] . "'";
    }

    //---------------Active Category-----------------
    $RefinedActiveCategoryTokenTemp=$_POST['ActiveCategory'];
    $RefinedActiveCategoryTokenTempSize=sizeof($RefinedActiveCategoryTokenTemp);
    $RefinedActiveCategoryToken="'" . $UniqueActiveCategory[$RefinedActiveCategoryTokenTemp[0]] . "'";
    if($RefinedActiveCategoryTokenTempSize>1)
    {
      for($i=1;$i<$RefinedActiveCategoryTokenTempSize;$i++)
	$RefinedActiveCategoryToken=$RefinedActiveCategoryToken ."," ."'" . $UniqueActiveCategory[$RefinedActiveCategoryTokenTemp[$i]] . "'";
    }

    //--------------Regulation Value----------------
    $RefinedRegulationValueTokenTemp=$_POST['RegulationValue'];
    $RefinedRegulationValueTokenTempSize=sizeof($RefinedRegulationValueTokenTemp);
    $RefinedRegulationValueToken="'" . $UniqueRegulationValue[$RefinedRegulationValueTokenTemp[0]] . "'";
    if($RefinedRegulationValueTokenTempSize>1)
    {
      for($i=1;$i<$RefinedRegulationValueTokenTempSize;$i++)
	$RefinedRegulationValueToken=$RefinedRegulationValueToken ."," ."'" . $UniqueRegulationValue[$RefinedRegulationValueTokenTemp[$i]] . "'";
    }


    $str=$searchCriteria;
    if(($RefinedBioFunctionTokenTemp[0])!= 0)
      $str=$str . " and BIOFUNCTION IN ($RefinedBioFunctionToken)";

    if(($RefinedExperimentSubjectTokenTemp[0])!= 0)
      $str=$str . " and EXPERIMENTSUBJECT IN ($RefinedExperimentSubjectToken)";

    if(($RefinedActiveSpeciesTokenTemp[0])!= 0)
      $str=$str . " and ACTIVESPECIES IN ($RefinedActiveSpeciesToken)";

    if(($RefinedActiveCategoryTokenTemp[0])!= 0)
      $str=$str . " and ACTIVECATEGORY IN ($RefinedActiveCategoryToken)";

    if(($RefinedRegulationValueTokenTemp[0])!= 0)
      $str=$str . " and REGULATIONVALUE IN ($RefinedRegulationValueToken)";


    $restricted='1';
    $notRestricted='0';
    $userid=$_SESSION['userid'];

    $cmdstrRetrieve ="SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V  WHERE RESTRICTED='" .$notRestricted."' $str union SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V  WHERE RESTRICTED='" .$restricted."' and CREATED_BY='".$userid."' $str order by 5,1";

    //echo $cmdstrRetrieve . "<br>";

    $_SESSION['cmdStrRefined']=$cmdstrRetrieve;
    $parsed = ociparse($db_conn, $cmdstrRetrieve);
    ociexecute($parsed);
    $numrows = ocifetchstatement($parsed, $results);

    echo "<table class='_90c'>\n";
    echo "<tr>\n";
    echo "<td>";

    echo "<table border=0>\n";
    echo "<tr>\n";
    echo "<td>";
    echo"<br><br><fieldset>";

    $strToken=explode("and",$str);
    for ($i=1;$i<count($strToken);$i++)
    {
      $strTokenInner=explode("IN", trim($strToken[$i]));
      echo "<b>" . trim($strTokenInner[0]) .": </b>" . trim($strTokenInner[1]) . "<br>";
    }
    echo "<b>" .$numrows . " Results found</b><br>";

    echo"</fieldset><br><br>";
    echo "</td>";
    echo "</tr>\n";
    echo "</table>";
    //string for header
    $str2="PROB ID,CG<br>Number,Gene<br>Name,FlyBase Number,Experiment Name,Active<br>Category,Active<br>Species,Experiment<br>Subject,GO<br>Number,Bio<br>Function,Regulation<br>Value,Fold<br>Induction,Hour";
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
      if(($i%2)==0)
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
    echo "<td class='_100L'>";
    echo "<input name='btn_submit' type='submit' value='Export Result'/>";
    echo "<input name='command' type='hidden' value='cmdStrRefined'/>";
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
  </body>
</html>







