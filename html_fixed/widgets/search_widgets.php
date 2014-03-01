<?php


$EXP_TO_FULL_V = array( "BIOFUNCTION"     => "BIOFUNCTION",
			"EXP_NAME" => "EXPERIMENTNAME",
			"CATG"     => "ACTIVECATEGORY",
			"SPEC"     => "ACTIVESPECIES",
			"SUBJ"     =>"EXPERIMENTSUBJECT",
			"REG_VAL"   => "REGULATIONVALUE",
			);
function grid_search_widgets() {
  echo <<< EOT
 <h2>Grid Search...</h2>

 <?php  grid_search_widgets(); ?>
    <fieldset>
      Prob ID:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      CG Number:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      FBCG Number:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Gene Name:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      GO Number:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Bio Category:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Experiment Name:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Active Category:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Active Species:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Experiment Subject:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Regulation Value:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
    </fieldset>
       
EOT;
}

function quick_search_widgets($db_conn) {
  echo <<< EOT
        <fieldset>
	<legend> Quick Search </legend>
	<h3> Search Criteria</h3>

	<small>Search String</small>
	<input type="radio" name="searchCriteria" value="PROBEID">Prob ID<br>
	<input type="radio" name="searchCriteria" value="CGNUMBER">CG Number<br>
	<input type="radio" name="searchCriteria" value="GENENAME">Gene Name&nbsp;&nbsp;(<a href="javascript:openModalWindow(1);">list</a>)
	<input name="txt_searchToken" type="text" style="width: 150px" />
	<br>(example: aaa,bbb,ccc)
      </fieldset>
      <div>
	<br>
	<fieldset>
      get_quick_search_widgets();
	</fieldset>
      </div>
EOT;
}

function get_advanced_search_widgets($db_conn) 
{

  get_string_widgets($db_conn);
  get_advanced_select_widgets($db_conn);

}

function get_bio_function($db_conn, $type, $userid)
{
  $full_v_type = $EXP_TO_FULL_V = array($type);


  $query = "select distinct biofunction as BIOFUNCTION from REFERENCE_BIO order by biofunction";

  $select_box = "<select name='$full_v_type' multiple='multiple'>\n";
  $select_box .= "\t<option value=0>ALL</option>\n";


  error_log ($query);

  $stdid= ociparse($db_conn, $query);
  ociexecute($stdid);
  $idx = 1;
  while ($row = oci_fetch_array($stdid))
    {
      $select_box .= "\t<option_value=$idx>" . $row[0] . "</option>\n";
    }
  $select_box .= "</select>";
  print $select_box;

}

function make_widget($db_conn, $type, $userid)
{
  $full_v_type = $EXP_TO_FULL_V = array($type);


  $query = "select distinct $type from EXPERIMENT where RESTRICTED ='0' ";
  if (isset($userid) && ! empty($userid)) {
    $query .= "  UNION select distinct $type from EXPERIMENT where RESTRICTED ='1' and CREATED_BY='$userid' order by 1";
  }
  

  $select_box = "<select name='$full_v_type' multiple='multiple'>\n";
  $select_box .= "\t<option value=0>ALL</option>\n";


  error_log ($query);

  $stdid= ociparse($db_conn, $query);
  ociexecute($stdid);
  $idx = 1;
  while ($row = oci_fetch_assoc($stdid))
    {
      error_log(print_r($row, true));
     
      $select_box .= "\t<option value=$idx>" . $row[$type] . "</option>\n";
    }
  $select_box .= "</select>";
  print $select_box;
}


function get_quick_search_widgets($db_conn) {
  echo <<< EOT

      <div class="selector">
        <label> Experiment Name: </label>
EOT;
  make_widget($db_conn, "EXP_NAME", $userid) 
  echo <<< EOT
      </div>

      <div class="selector">
	<label>Active Category: </label>
echo <<< EOT
	<?php make_widget($db_conn, "CATG", $userid) ?>
      </div>

      <div class="selector">
	<label>Active Species: </label>
	<?php make_widget($db_conn, "SPEC", $userid) ?>
      </div>

      <div class="selector">
	<label> Experiment Subject: </label>
	<?php make_widget($db_conn, "SUBJ", $userid) ?>
      </div>

      <div class="selector">
	<label>Regulation Value: </label>
	<?php get_regulation_value($db_conn, "REG_VAL", $userid) ?>
      </div>


    
EOT;
  


}


function get_advanced_select_widgets($db_conn) 
{
  $userid = 0;
  echo <<< EOT

      <div class="selector">
	<label>Bio Function: </label>
	<?php get_bio_function($db_conn, "BIOFUNCTION", $userid) ?>
      </div>

      <div class="selector">
        <label> Experiment Name: </label>
	<?php make_widget($db_conn, "EXP_NAME", $userid) ?>
      </div>

      <div class="selector">
	<label>Active Category: </label>
	<?php make_widget($db_conn, "CATG", $userid) ?>
      </div>

      <div class="selector">
	<label>Active Species: </label>
	<?php make_widget($db_conn, "SPEC", $userid) ?>
      </div>

      <div class="selector">
	<label> Experiment Subject: </label>
	<?php make_widget($db_conn, "SUBJ", $userid) ?>
      </div>
    
EOT;
    }

function get_string_widgets() 
{
  echo <<< EOT
      <label for="PROBEID"> Prob ID: </label>
      <input name="PROBEID" type="text"> <br>

      <label for="CGNUMBER"> CG Number: </label>
      <input name="CGNUMBER" type="text"> <br>

      <label for="FBCGNUMBER"> FlyBase Number: </label>
      <input name="FBCGNUMBER" type="text"><br>

      <label for="GENENAME"> Gene Name:&nbsp;&nbsp;(<a href="javascript:openModalWindow(1);">list</a>)</label>
      <input name="GENENAME" type="text"><br>

      <label for="GONUMBER"> GO Number:</label>
      <input name="GONUMBER" type="text"><br>  
			       
EOT;
}

?>