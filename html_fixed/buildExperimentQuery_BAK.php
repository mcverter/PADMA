<?php


//[Fri Feb 14 11:53:03 2014] [error] [client ::1] query is SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V where  PROBEID IN ('141217_at') and ACTIVECATEGORY IN ('Development','Fungal','Microbial','Mutant','Parasitoid') and ACTIVESPECIES IN ('A.tabida','B. bassiana','B. bassiana Spz','Dif1','Dorsal1','E. coli','E. coli M. leutus','E. coli M. luteus','E. coli OreR','E. coli Rel','E.coli M.leutus Rel','E.coli M.leutus Spz','Hop tum-l','L.boulardi','L.heterotoma','NURF 301 Delta C','Rel E20','Toll10b','W1118') and EXPERIMENTSUBJECT IN ('Hemocyte','Larvae','Prepupae') AND RESTRICTED='0' UNION SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_V where  PROBEID IN ('141217_at') and ACTIVECATEGORY IN ('Development','Fungal','Microbial','Mutant','Parasitoid') and ACTIVESPECIES IN ('A.tabida','B. bassiana','B. bassiana Spz','Dif1','Dorsal1','E. coli','E. coli M. leutus','E. coli M. luteus','E. coli OreR','E. coli Rel','E.coli M.leutus Rel','E.coli M.leutus Spz','Hop tum-l','L.boulardi','L.heterotoma','NURF 301 Delta C','Rel E20','Toll10b','W1118') and EXPERIMENTSUBJECT IN ('Hemocyte','Larvae','Prepupae') AND RESTRICTED='1' and CREATED_BY='AKIRA' ORDER BY 5,1\n, referer: http://localhost/old_PADMA/PADMA/AdvancedQuery.php


function build_query () {
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
  

  foreach ($text_field_input as $constraint)
    {
      $posted = $_POST[$constraint];
      if (isset($posted) && ! empty($posted))
	{
	  $posted_arr = explode($posted);
	  $query_string .= " AND $posted IN ( '" . pop($posted_arr) . "'"; 
	  foreach ($posted_arr as $selection)
	    {
	      $query_string .= " , '$selection' ";
	    }
	  $query_string .= ") ";
	}   
    }
  foreach ($multiple_select_inputs as $constraint) {
    $posted = $_POST[$constraint];
    if (isset($posted) && ! empty($posted))
      {
	$query_string .= " AND $posted IN ( '" . pop($posted) . "'"; 
	foreach ($posted as $selection)
	  {
	    $query_string .= " , '$selection' ";
	  }
	$query_string .= ") ";
      }
  }

?>
  /*function build_where() 
  $query_string = "";


//get_standard_search_inputs();
add_array_constraint($query_string, $_POST['BIOFUNCTION']);
add_array_constraint($query_string, $_POST['EXPERIMENTNAME']);
add_array_constraint($query_string, $_POST['ACTIVESPECIES']);
add_array_constraint($query_string, $_POST['ACTIVECATEGORY']);
add_array_constraint($query_string, $_POST['EXPERIMENTSUBJECT']);
add_array_constraint($query_string, $_POST['REGULATIONVALUE']);


add_string_constraint($query_string, $_POST['PROBEID']);
add_string_constraint($query_string, $_POST['CGNUMBER']);
add_string_constraint($query_string, $_POST['FBCNUMBER']);
add_string_constraint($query_string, $_POST['GENENAME']);
add_string_constraint($query_string, $_POST['GONUMBER']);

add_string_constraint($query_string, $_POST['ADDITIONALINFO']);
add_string_constraint($query_string, $_POST['HOUR']);

}


function add_array_constraint(&$query_string) {
  
}

get_standard_search_inputs() {
    //get the search criteria from previous page
    //$SearchFrom = $_POST['searchFrom'];
    //get the search criteria from previous page
    $PROBEID = $_POST['PROBEID'];
    $CGNUMBER = $_POST['CGNUMBER'];
    $FBCGNUMBER = $_POST['FBCGNUMBER'];
    $GENENAME = $_POST['GENENAME'];
    $GONUMBER = $_POST['GONUMBER'];



    //get all the Unique array from session varialbe
    $EXPERIMENTNAME_S=$_POST['EXP_NAME_S'];
    $ACTIVECATEGORY_S=$_POST['CATG_S'];
    $ACTIVESPECIES_S=$_POST['SPEC_S'];
    $EXPERIMENTSUBJECT_S=$_POST['SUBJ_S'];
    $BIOFUNCTION_S=$_POST['BIOFUNCTION_S'];
    $REGULATIONVALUE_S=$_POST['REG_VAL_Q'];
  }



function add_probe_id() {
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
}


function add_cgnumber() {
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

}

function add_fbcgnumber() {
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
}


function add_genename() {

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

}

function add_biofunction() {
    if(($BIOFUNCTION_TEMP[0]) !=0)
    {
      if ($counter>0)
	$str=$str . " and BIOFUNCTION IN ($BIOFUNCTION)";
      else
	$str=$str . " BIOFUNCTION IN ($BIOFUNCTION)";
      $counter=$counter+1;
      echo "<b>BIOFUNCTION: </b>" . $BIOFUNCTION . "<br>";
    }


}



function add_experiment_name() {
    if(($EXPERIMENTNAME_TEMP[0]) !=0)
    {
      if ($counter>0)
	$str=$str . " and EXPERIMENTNAME IN ($EXPERIMENTNAME)";
      else
	$str=$str . " EXPERIMENTNAME IN ($EXPERIMENTNAME)";
      $counter=$counter+1;
      echo "<b>EXPERIMENTNAME: </b>" . $EXPERIMENTNAME . "<br>";
    }

    if(($EXPERIMENTNAME_TEMP[0]) !=0)
    {
    $cmdstrRetrieve=$cmdstrRetrieve . " and EXPERIMENTNAME IN ($EXPERIMENTNAME)";
    $cmdstrRetrieve2=$cmdstrRetrieve2 . " and EXPERIMENTNAME IN ($EXPERIMENTNAME)";
    echo "<b>EXPERIMENTNAME: </b>" . $EXPERIMENTNAME . "<br>";
    }


}


function add_active_species() {
    if(($ACTIVESPECIES_TEMP[0]) !=0)
    {

    $cmdstrRetrieve=$cmdstrRetrieve . " and ACTIVESPECIES IN ($ACTIVESPECIES)";
    $cmdstrRetrieve2=$cmdstrRetrieve2 . " and ACTIVESPECIES IN ($ACTIVESPECIES)";
    echo "<b>ACTIVESPECIES: </b>" . $ACTIVESPECIES . "</b><br>";
    }


}
function add_active_category ()
{
    if(($ACTIVECATEGORY_TEMP[0]) !=0)
    {
      if ($counter>0)
	$str=$str . " and ACTIVECATEGORY IN ($ACTIVECATEGORY)";
      else
	$str=$str . " ACTIVECATEGORY IN ($ACTIVECATEGORY)";
      $counter=$counter+1;
      echo "<b>ACTIVECATEGORY: </b>" . $ACTIVECATEGORY . "<br>";
    }
    if(($ACTIVECATEGORY_TEMP[0]) !=0)
    {
    $cmdstrRetrieve=$cmdstrRetrieve . " and ACTIVECATEGORY IN ($ACTIVECATEGORY)";
    $cmdstrRetrieve2=$cmdstrRetrieve2 . " and ACTIVECATEGORY IN ($ACTIVECATEGORY)";
    echo "<b>ACTIVECATEGORY: </b>" . $ACTIVECATEGORY . "</b><br>";
    }

}

function add_regulation_value() {
    if(($REGULATIONVALUE_TEMP[0]) !=0)
    {

    $cmdstrRetrieve=$cmdstrRetrieve . " and REGULATIONVALUE IN ($REGULATIONVALUE)";
    $cmdstrRetrieve2=$cmdstrRetrieve2 . " and REGULATIONVALUE IN ($REGULATIONVALUE)";
    echo "<b>REGULATIONVALUE: </b>" . $REGULATIONVALUE . "</b><br>";
    }


}


function add_experiment_subject(){
    if(($EXPERIMENTSUBJECT_TEMP[0]) !=0)
    {
      if ($counter>0)
	$str=$str . " and EXPERIMENTSUBJECT IN ($EXPERIMENTSUBJECT)";
      else
	$str=$str . " EXPERIMENTSUBJECT IN ($EXPERIMENTSUBJECT)";
      $counter=$counter+1;
      echo "<b>EXPERIMENTSUBJECT: </b>" . $EXPERIMENTSUBJECT . "<br>";
    }



    if(($EXPERIMENTSUBJECT_TEMP[0]) !=0)
    {

    $cmdstrRetrieve=$cmdstrRetrieve . " and EXPERIMENTSUBJECT IN ($EXPERIMENTSUBJECT)s";
    $cmdstrRetrieve2=$cmdstrRetrieve2 . " and EXPERIMENTSUBJECT IN ($EXPERIMENTSUBJECT)";
    echo "<b>EXPERIMENTSUBJECT: </b>" . $EXPERIMENTSUBJECT . "</b><br>";
    }

}
function add_active_species() {
    if(($ACTIVESPECIES_TEMP[0]) !=0)
    {
      if ($counter>0)
	$str=$str . " and ACTIVESPECIES IN ($ACTIVESPECIES)";
      else
	$str=$str . " ACTIVESPECIES IN ($ACTIVESPECIES)";
      $counter=$counter+1;
      echo "<b>ACTIVESPECIES: </b>" . $ACTIVESPECIES . "<br>";
    }

}




function add_go_number() {
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

}




function get_bio_function() {

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


  }
function get_experiment_name() {
    //get rest of the search criteria
    //-----------Experiment name--------------------
    $EXPERIMENTNAME_TEMP=$_POST['EXP_NAME'];
    $EXPERIMENTNAME_TEMP_SIZE=sizeof($EXPERIMENTNAME_TEMP);
    if ($EXPERIMENTNAME_TEMP_SIZE==1)
      $EXPERIMENTNAME="'" . $EXPERIMENTNAME_S[$EXPERIMENTNAME_TEMP[0]] . "'";
    elseif($EXPERIMENTNAME_TEMP_SIZE>1)
    {
      $EXPERIMENTNAME="'" . $EXPERIMENTNAME_S[$EXPERIMENTNAME_TEMP[0]] . "'";
      for($i=1;$i<$EXPERIMENTNAME_TEMP_SIZE;$i++)
	$EXPERIMENTNAME=$EXPERIMENTNAME ."," ."'" . $EXPERIMENTNAME_S[$EXPERIMENTNAME_TEMP[$i]] . "'";
    }

  }
function get_active_category()
{
    //---------------Active Category------------------------
    $ACTIVECATEGORY_TEMP=$_POST['CATG'];
    $ACTIVECATEGORY_TEMP_SIZE=sizeof($ACTIVECATEGORY_TEMP);
    if ($ACTIVECATEGORY_TEMP_SIZE==1)
      $ACTIVECATEGORY="'" . $ACTIVECATEGORY_S[$ACTIVECATEGORY_TEMP[0]] . "'";
    elseif($ACTIVECATEGORY_TEMP_SIZE>1)
    {
      $ACTIVECATEGORY="'" . $ACTIVECATEGORY_S[$ACTIVECATEGORY_TEMP[0]] . "'";
      for($i=1;$i<$ACTIVECATEGORY_TEMP_SIZE;$i++)
	$ACTIVECATEGORY=$ACTIVECATEGORY ."," ."'" . $ACTIVECATEGORY_S[$ACTIVECATEGORY_TEMP[$i]] . "'";
    }

}
function get_experiment_subj()
{
    //---------------Experiment Subject------------------------
    $EXPERIMENTSUBJECT_TEMP=$_POST['SUBJ'];
    $EXPERIMENTSUBJECT_TEMP_SIZE=sizeof($EXPERIMENTSUBJECT_TEMP);
    if ($EXPERIMENTSUBJECT_TEMP_SIZE==1)
      $EXPERIMENTSUBJECT="'" . $EXPERIMENTSUBJECT_S[$EXPERIMENTSUBJECT_TEMP[0]] . "'";
    elseif($EXPERIMENTSUBJECT_TEMP_SIZE>1)
    {
      $EXPERIMENTSUBJECT="'" . $EXPERIMENTSUBJECT_S[$EXPERIMENTSUBJECT_TEMP[0]] . "'";
      for($i=1;$i<$EXPERIMENTSUBJECT_TEMP_SIZE;$i++)
	$EXPERIMENTSUBJECT=$EXPERIMENTSUBJECT ."," ."'" . $EXPERIMENTSUBJECT_S[$EXPERIMENTSUBJECT_TEMP[$i]] . "'";
    }


}

function get_regulation_value() {

    //-------------Regulation Value-----------------------------------
    $REGULATIONVALUE_TEMP=$_POST['REG_VAL'];
    $REGULATIONVALUE_TEMP_SIZE=sizeof($REGULATIONVALUE_TEMP);
    if ($REGULATIONVALUE_TEMP_SIZE==1)
      $REGULATIONVALUE="'" . $REGULATIONVALUE_S[$REGULATIONVALUE_TEMP[0]] . "'";
    elseif($REGULATIONVALUE_TEMP_SIZE>1)
    {
      $REGULATIONVALUE="'" . $REGULATIONVALUE_S[$REGULATIONVALUE_TEMP[0]] . "'";
      for($i=1;$i<$REGULATIONVALUE_TEMP_SIZE;$i++)
	$REGULATIONVALUE=$REGULATIONVALUE ."," ."'" . $REGULATIONVALUE_S[$REGULATIONVALUE_TEMP[$i]] . "'";
    }


}

get_active_species() {
    //---------------Active Species------------------------
    $ACTIVESPECIES_TEMP=$_POST['SPEC'];
    $ACTIVESPECIES_TEMP_SIZE=sizeof($ACTIVESPECIES_TEMP);
    if ($ACTIVESPECIES_TEMP_SIZE==1)
      $ACTIVESPECIES="'" . $ACTIVESPECIES_S[$ACTIVESPECIES_TEMP[0]] . "'";
    elseif($ACTIVESPECIES_TEMP_SIZE>1)
    {
      $ACTIVESPECIES="'" . $ACTIVESPECIES_S[$ACTIVESPECIES_TEMP[0]] . "'";
      for($i=1;$i<$ACTIVESPECIES_TEMP_SIZE;$i++)
	$ACTIVESPECIES=$ACTIVESPECIES ."," ."'" . $ACTIVESPECIES_S[$ACTIVESPECIES_TEMP[$i]] . "'";
    }



}


*/
