<?php


$EXP_TO_FULL_V = array( "FUNC"     => "BIOFUNCTION",
			"EXP_NAME" => "EXPERIMENTNAME",
			"CATG"     => "ACTIVECATEGORY",
			"SPEC"     => "ACTIVESPECIES",
			"SUBJ"     =>"EXPERIMENTSUBJECT",
			"REG_VAL"   => "REGULATIONVALUE",
			);



function make_widget($db_conn, $type, $user_id)
{
  $full_v_type = $EXP_TO_FULL_V = array($type);


  $query = "select distinct $type from EXPERIMENT where RESTRICTED ='0' ";
  if ($user_id) {
    $query .= "  UNION select distinct $type from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='$userid' order by 1";
  }
  
  $select_box = "<select name='$full_v_type' multiple='multiple'>\n";
  $select_box .= "\t<option value=0>ALL</option>\n";


  $stdid= ociparse($db_conn, $cmdstr);
  ociexecute($stdid);
  $idx = 1;
  while ($row = oci_fetch_array($stdid))
    {
      $select_box .= "\t<option_value=$idx>" . $row[0] . "</option>\n";
    }
  $select_box .= "</select>";
}

/*
function category_widget($db_conn) {
  $cmdstr = "select distinct CATG from EXPERIMENT where RESTRICTED ='0'	UNION select distinct CATG from EXPERIMENT where RESTRICTED ='1' 	 order by 1";
  $parsed = ociparse($db_conn, $cmdstr);
  ociexecute($parsed);
  $total = ocifetchstatement($parsed, $results);
  $ACTIVECATEGORY[]="ALL";
  for ($i = 0; $i < $total; $i++ )
    {
      $ACTIVECATEGORY[]=$results["CATG"][$i];
    }
  echo "<select name='ACTIVECATEGORY' multiple='multiple'>";
  for ($i=0;$i<count($CATG);$i++)
    {
      echo "<option value=" . $i . ">" . $CATG[$i] . "</option>";
    }
  echo "</select>";
  }

function species_widget($db_conn) {
  $cmdstr = "select distinct SPEC from EXPERIMENT where RESTRICTED ='0'	UNION select distinct SPEC from EXPERIMENT where RESTRICTED ='1' 	 order by 1";
  $parsed = ociparse($db_conn, $cmdstr);
  ociexecute($parsed);
  $total = ocifetchstatement($parsed, $results);
  $SPEC[]="ALL";
  for ($i = 0; $i < $total; $i++ )
    {
      $SPEC[]=$results["SPEC"][$i];
    }
  echo "<select name='SPEC' multiple='multiple'>";
  for ($i=0;$i<count($SPEC);$i++)
    {
      echo "<option value=" . $i . ">" . $SPEC[$i] . "</option>";
    }
  echo "</select>";
}

function subject_widget($db_conn) {
  $cmdstr = "select distinct SUBJ from EXPERIMENT where RESTRICTED ='0'	UNION select distinct SUBJ from EXPERIMENT where RESTRICTED ='1' 	 order by 1";
  $parsed = ociparse($db_conn, $cmdstr);
  ociexecute($parsed);
  $total = ocifetchstatement($parsed, $results);
  $SUBJ[]="ALL";
  for ($i = 0; $i < $total; $i++ )
    {
      $SUBJ[]=$results["SUBJ"][$i];
    }
  echo "<select name='SUBJ' multiple='multiple'>";
  for ($i=0;$i<count($SUBJ);$i++)
    {
      echo "<option value=" . $i . ">" . $SUBJ[$i] . "</option>";
    }
  
  echo "</select>";
}

function regulation_value_widget($db_conn) {
  $cmdstr = "select distinct REG_VAL from EXPERIMENT where RESTRICTED ='0'	UNION select distinct REG_VAL from EXPERIMENT where RESTRICTED ='1' 	 order by 1";
  $parsed = ociparse($db_conn, $cmdstr);
  ociexecute($parsed);
  $total = ocifetchstatement($parsed, $results);
  $REG_VAL[]="ALL";
  for ($i = 0; $i < $total; $i++ )
    {
      $REG_VAL[]=$results["REG_VAL"][$i];
    }
  echo "<select name='REG_VAL' multiple='multiple'>";
  for ($i=0;$i<count($REG_VAL);$i++)
    {
      echo "<option value=" . $i . ($i == 0? " selected" : "") . ">" . $REG_VAL[$i] . "</option>";
    }
  echo "</select>";
}

function experiment_widget($db_conn) {
  $cmdstr = "select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='0' UNION select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='1'   order by 1";
  $parsed = ociparse($db_conn, $cmdstr);
  ociexecute($parsed);
  $total = ocifetchstatement($parsed, $results);
  $EXP_NAME[]="ALL";
  for ($i = 0; $i < $total; $i++ )
    {
      $EXP_NAME[]=$results["EXP_NAME"][$i];
    }
  echo "<select name='EXP_NAME' multiple='multiple'>";
  for ($i=0;$i < count($EXP_NAME);$i++)
    {
      echo "<option value=" . $i . ">" . $EXP_NAME[$i] . "</option>";
    }
  echo "</select>";
}

function show_experiment_plus_detail($db_conn) {
  $cmdCountry = "select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='0' UNION select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='1'   order by 1";
  $parsed = ociparse($db_conn, $cmdCountry);
  ociexecute($parsed);
  $totalCountry = ocifetchstatement($parsed, $results);

  echo "<select name='Country' style='width:92%' size='5' onchange='showDescription(this.value)'>";
  
  for ($i=0;$i<$totalCountry;$i++)
    {
      echo "<option value=" . $results["EXP_NAME"][$i] . ">" . $results["EXP_NAME"][$i] . "</option>";
    }
  echo "</select>";
}


function biofunction_widget($db_conn) {
  $cmdstr = "select distinct biofunction as BIOFUNCTION from REFERENCE_BIO order by biofunction";
  $parsed = ociparse($db_conn, $cmdstr);
  ociexecute($parsed);
  $total = ocifetchstatement($parsed, $results);
  $BIOFUNCTION[]="ALL";
  for ($i = 0; $i < $total; $i++ )
    {
      $BIOFUNCTION[]=$results["BIOFUNCTION"][$i];
    }
  echo "<select name='BIOFUNCTION' multiple='multiple'>";
  for ($i=0;$i<count($BIOFUNCTION);$i++)
    {
    echo "<option value=" . $i . ">" . $BIOFUNCTION[$i] . "</option>";
    }
  echo "</select>";
}

function select_from_researcher_experiments($db_conn) {
  /*
    <form name="form1" action="EditDescription.php" method="post" onSubmit="return validate(form1);">

  <select name='expName' style='width:92%' onchange='showDescription(this.value)'>
  <option value="Select one">Select one...</option>
   */
  $cmdCountry = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0'   order by EXP_NAME";
  $parsed = ociparse($db_conn, $cmdCountry);
  ociexecute($parsed);
  $totalCountry = ocifetchstatement($parsed, $results);
  for ($i=0;$i<$totalCountry;$i++) 
    {
      echo "<option value=\"" . $results["EXP_NAME"][$i] . "\">" . $results["EXP_NAME"][$i] . "</option>";
    }
  
}

function select_from_all_experiments ($db_conn) 
{
  /*
    <form name="form1" action="EditDescription.php" method="post">
      
    <select name='expName' style='width:92%' onchange='showDescription(this.value)'>
     */
  
  $cmdCountry = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0' order by EXP_NAME";
  $parsed = ociparse($db_conn, $cmdCountry);
  ociexecute($parsed);
  $totalCountry = ocifetchstatement($parsed, $results);
  for ($i=0;$i<$totalCountry;$i++) 
    {
      echo "<option value=\"" . $results["EXP_NAME"][$i] . "\">" . $results["EXP_NAME"][$i] . "</option>";
    }
}

function delete_ref_version($db_conn) 
{
  $cmdCountry = "select distinct VERSION from REFERENCE_MAIN order by VERSION";
  $parsed = ociparse($db_conn, $cmdCountry);
  ociexecute($parsed);
  $totalCountry = ocifetchstatement($parsed, $results);
  echo "<select name='version' style='width:92%' size='8'>";
  for ($i=0;$i<$totalCountry;$i++)
    {
      echo "<option value=" . $results["VERSION"][$i] . ">Version:" . $results["VERSION"][$i] . "</option>";
    }
  echo "</select><br><br><input name='cmdDelete' type='submit' value='Delete'/><br>";
  
}

function delete_experiment_administrator ($db_conn) 
{
  $cmdCountry = "select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='0' union select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='1'   order by 1";
  
  $parsed = ociparse($db_conn, $cmdCountry);
  ociexecute($parsed);
  $totalCountry = ocifetchstatement($parsed, $results);
  echo "<select name='exp_name' style='width:92%' size='8'>";
  for ($i=0;$i<$totalCountry;$i++)
    {
      echo "<option value=" . $results["EXP_NAME"][$i] . ">" . $results["EXP_NAME"][$i] . "</option>";
    }
  echo "</select><br><br><input name='cmdDelete' type='submit' value='Delete'/><br>";

}
?>