<?
include ("control_functions.php");
initialize_session();
$db_conn = connect_to_db();
?>

<!DOCTYPE html>


<head>
  <title>PADMA Database</title>
  <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>

  <?php  include("header.php"); ?>
  <div class="backToRefine">
    <!--
    <font color="#4682B4"><h5><a href='RefineSearch.php'>&lt;&lt;Back to Refine Search</a> | <a title='logout' href='index.php'>Log Out</a></h5></font></td>
    </tr>
    -->
  </div>

  <?php

  $query = build_refined_query();
  display_results();
  allow_export_results();



  //get matrix value from database
  $cmdstrRetrieve = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V  WHERE RESTRICTED='" .$notRestricted."' $str union SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V  WHERE RESTRICTED='" .$restricted."' and CREATED_BY='".$userid."' $str order by 5,1";
  $parsed = ociparse($db_conn, $cmdstrRetrieve);
  ociexecute($parsed);
  $numrows = ocifetchstatement($parsed, $results);


  //echo $cmdstrRetrieve . "<br>";
  //save search result into a session variable

  $_POST['totalSearchResult']=$numrows;
  $_POST['searchResult']=$results;
  $_POST['SearchCreiteria']=$str;
  //$_POST['SearchString']=$searchToken;
  $_POST['cmdStrRefinedAll']=$cmdstrRetrieve;

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
  $_POST['S_UniqueBioFunction']=$UniqueBioFunction;
  $_POST['S_UniqueExperimentSubject']=$UniqueExperimentSubject;
  $_POST['S_UniqueActiveSpecies']=$UniqueActiveSpecies;
  $_POST['S_UniqueActiveCategory']=$UniqueActiveCategory;
  $_POST['S_UniqueRegulationValue']=$UniqueRegulationValue;

  echo "<form action='RefineSearchResultRefined.php' method='post' name='refine'>";
  echo "<table class='_75_small'><tr><td>";
  echo "<fieldset>";
  echo "<table class='_100C_color_pad2'>";
  echo	"<tr>";
  echo        "<td class="_30L">&nbsp;<br />";
  echo        	"<b>Bio Function:</b>&nbsp;&nbsp;";
  echo        "</td>";
  echo        "<td class="_70L">&nbsp;<br />";
  echo 			"<select name='BioFunction[]' multiple='multiple' style='width:75%; font-family:verdana'>";
  for ($i=0;$i<=count($UniqueBioFunction);$i++)
  {
    echo 					"<option value=" . $i . ">" . $UniqueBioFunction[$i] . "</option>";
  }
  echo 			"</select>";
  echo        "</td>";
  echo    "</tr>";

  echo	"<tr>";
  echo        "<td class="_30L">&nbsp;<br />";
  echo        	"<b>Experiment Subject:</b>&nbsp;&nbsp;";
  echo        "</td>";
  echo        "<td class="_70L">&nbsp;<br />";
  echo 			"<select name='ExperimentSubject[]' multiple='multiple' style='width:75%; font-family:verdana'>";
  for ($i=0;$i<=count($UniqueExperimentSubject);$i++)
  {
    echo 					"<option value=" . $i . ">" . $UniqueExperimentSubject[$i] . "</option>";
  }
  echo 			"</select>";
  echo        "</td>";
  echo    "</tr>";

  echo	"<tr>";
  echo        "<td class="_30L">&nbsp;<br />";
  echo        	"<b>Active Species:</b>&nbsp;&nbsp;";
  echo        "</td>";
  echo        "<td class="_70L">&nbsp;<br />";
  echo 			"<select name='ActiveSpecies[]' multiple='multiple' style='width:75%; font-family:verdana'>";
  for ($i=0;$i<=count($UniqueActiveSpecies);$i++)
  {
    echo 					"<option value=" . $i . ">" . $UniqueActiveSpecies[$i] . "</option>";
  }
  echo 			"</select>";
  echo        "</td>";
  echo    "</tr>";

  echo	"<tr>";
  echo        "<td class="_30L">&nbsp;<br />";
  echo        	"<b>Active Category:</b>&nbsp;&nbsp;";
  echo        "</td>";
  echo        "<td class="_70L">&nbsp;<br />";
  echo 			"<select name='ActiveCategory[]' multiple='multiple' style='width:75%; font-family:verdana'>";
  for ($i=0;$i<=count($UniqueActiveCategory);$i++)
  {
    echo 					"<option value=" . $i . ">" . $UniqueActiveCategory[$i] . "</option>";
  }
  echo 			"</select>";
  echo        "</td>";
  echo    "</tr>";

  echo	"<tr>";
  echo        "<td class="_30L">&nbsp;<br />";
  echo        	"<b>Regulation Value:</b>&nbsp;&nbsp;";
  echo        "</td>";
  echo        "<td class="_70L">&nbsp;<br />";
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
  <td class="_100_pad5"><tr>
    <td class="_100c">
      <input name="btn_submit" type="submit" value="Submit"/>
    </td></tr>
    </table>
    <?php echo"</form"; ?>
</body>
</html>







