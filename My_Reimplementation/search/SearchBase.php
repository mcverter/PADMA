<?php
require_once(__DIR__ . "/../page_templates/DatabaseConnectionPage.php");

abstract class SearchBase extends DatabaseConnectionPage
{

    const CGNUMBER_LABEL = '';
    const EXPERIMENTNAME_LABEL = '';
    const FLYBASE_HEADING = '';
    const ACTIVECATEGORY_LABEL = '';
    const ACTIVESPECIES_LABEL = '';
    const EXPERIMENTSUBJECT_LABEL = '';

    const EXPERIMENT_LABEL = "Experiments";
    const CATEGORY_LABEL = "Categories";
    const SPECIES_LABEL = "Species";
    const SUBJECT_LABEL = "Experiments";
    const REGVAL_LABEL = "Regulation Values";
    const BIOFUNCTION_LABEL = "Biofunction";

    const PROBEID_LABEL = "Probe ID";
    const CGNUM_LABEL = "CG Number";
    const FLYBASE_LABEL = "FlyBase Number";
    const GONUMBER_LABEL = "GO Number";

    const GENENAME_LABEL = "Gene Name";


    const EXPERIMENT_SELECT_NAME = "Experiment[]";
    const CATEGORY_SELECT_NAME = "Category[]";
    const SPECIES_SELECT_NAME = "Species[]";
    const SUBJECT_SELECT_NAME = "Subject[]";
    const REGVAL_SELECT_NAME = "RegulationValue[]";
    const BIOFUNCTION_SELECT_NAME = "Biofunction[]";


    const EXPERIMENT_EXP_TBL_COL = "EXP_NAME";
    const CATEGORY_EXP_TBL_COL = "CATG";
    const SPECIES_EXP_TBL_COL = "SPEC";
    const SUBJECT_EXP_TBL_COL = "SUBJ";
    const REGVAL_EXP_TBL_COL = "REG_VAL";
    const BIOFUNCTION_EXP_TBL_COL = "BIOFUNCTION";


    const FLYBASE_EXP_TBL_COL = '';
    const FLYBASE_FULLVIEW_TBL_COL = '';

    const PROBEID_FULLVIEW_TBL_COL = "PROBEID";
    const CGNUMBER_FULLVIEW_TBL_COL = "CGNUMBER";
    const GENENAME_FULLVIEW_TBL_COL = "GENENAME";
    const FBCGNUMBER_FULLVIEW_TBL_COL = "FBCGNUMBER";
    const BIOFUNCTION_FULLVIEW_TBL_COL = "BIOFUNCTION";
    const GONUMBER_FULLVIEW_TBL_COL = "GONUMBER";
    const EXPERIMENTNAME_FULLVIEW_TBL_COL = "EXPERIMENTNAME";
    const ACTIVECATEGORY_FULLVIEW_TBL_COL = "ACTIVECATEGORY";
    const ACTIVESPECIES_FULLVIEW_TBL_COL = "ACTIVESPECIES";
    const EXPERIMENTSUBJECT_FULLVIEW_TBL_COL = "EXPERIMENTSUBJECT";
    const REGULATIONVALUE_FULLVIEW_TBL_COL = "REGULATIONVALUE";
    const ADDITIONALINFO_FULLVIEW_TBL_COL = "ADDITIONALINFO";
    const RESTRICTED_FULLVIEW_TBL_COL = "RESTRICTED";
    const CREATED_BY_FULLVIEW_TBL_COL = "CREATED_BY";
    const HOUR_FULLVIEW_TBL_COL = "HOUR";


    const PROBEID_HEADING = "Probe ID";
    const CGNUMBER_HEADING = "CG Number";
    const GENENAME_HEADING = "Gene Name";
    const FBCGNUMBER_HEADING = "FlyBase Number";
    const BIOFUNCTION_HEADING = "Bio Function";
    const GONUMBER_HEADING = "GO Number";
    const EXPERIMENTNAME_HEADING = "Experiment Name";
    const ACTIVECATEGORY_HEADING = "Active Category";
    const ACTIVESPECIES_HEADING = "Active Species";
    const EXPERIMENTSUBJECT_HEADING = "Experiment Subject";
    const REGULATIONVALUE_HEADING = "Regulation Value";
    const ADDITIONALINFO_HEADING = "Fold Induction";
    const HOUR_HEADING = "Hour";

    protected function make_probeid_text_input() {
        WidgetMaker::text_input("Probe Id:", 'probeid');
    }
    protected function make_cgnumber_text_input() {
        WidgetMaker::text_input("CG Number:", 'cgnum');
    }
    protected function make_flybasenumber_text_input() {
        WidgetMaker::text_input("Flybase Number:", 'flynum');
    }
    protected function make_genename_text_input() {
        WidgetMaker::text_input("Gene Name:", 'gene');
    }
    protected function make_gonumber_text_input() {
        WidgetMaker::text_input("GO Number:", 'gonum');
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_experiment_select($db_conn, $userid) {
        WidgetMaker::select_input(
            self::EXPERIMENT_LABEL,
            self::EXPERIMENT_SELECT_NAME,
            DBFunctions::selectAllUnrestrictedExperimentList($db_conn, $userid),
            self::EXPERIMENT_EXP_TBL_COL);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_category_select($db_conn, $userid) {
        WidgetMaker::select_input(
            self::CATEGORY_LABEL,
            self::CATEGORY_SELECT_NAME,
            DBFunctions::selectCategoryList($db_conn, $userid),
            self::CATEGORY_EXP_TBL_COL);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_species_select($db_conn, $userid) {
        WidgetMaker::select_input(
            self::SPECIES_LABEL,
            self::SPECIES_SELECT_NAME,
            DBFunctions::selectSpeciesList($db_conn, $userid),
            self::SPECIES_EXP_TBL_COL);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_subject_select($db_conn, $userid) {
        WidgetMaker::select_input(
            self::SUBJECT_LABEL,
            self::SUBJECT_SELECT_NAME,
            DBFunctions::selectSubjectList($db_conn, $userid),
            self::SUBJECT_EXP_TBL_COL);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_regval_select($db_conn, $userid) {
        WidgetMaker::select_input(
            self::REGVAL_LABEL,
            self::REGVAL_SELECT_NAME,
            DBFunctions::selectRegValList($db_conn, $userid),
            self::REGVAL_EXP_TBL_COL);
    }
    protected function make_biofunction_select($db_conn, $userid) {
        WidgetMaker::select_input(
            self::BIOFUNCTION_LABEL,
            self::BIOFUNCTION_SELECT_NAME,
            DBFunctions::selectBiofunctionList($db_conn, $userid),
            self::BIOFUNCTION_EXP_TBL_COL);
    }


    // Used for Search Results
    static private function extract_csv_from_array($arr)
    {

        $csv = " ( '" . PageControlFunctions::unescape_space(array_pop($arr)) . "'";
        foreach ($arr as $v)
        {
            $csv .= " , '" . PageControlFunctions::unescape_space($v) ."' ";
        }
        $csv .= ") ";
        return $csv;
    }

    static private function extract_csv_from_string ($str)
    {
        return self::extract_csv_from_array(explode(',', $str ));
    }


    function build_constraint($search_params ) {
        $constraint = " 1 ";
        foreach ($search_params as $param) {
            if ($param['type'] === 'quicksearch') {

            }
            else {
                if (isset($_POST[$param['postvar']]) &&
                    (! empty ($_POST[$param['postvar']]))) {
                    $constraint .= " AND " . $param['col'] . " IN  " ;
                    if ($param['type'] === 'string') {
                        $constraint .= " ( " . self::extract_csv_from_string($_POST[$param['postvar']]) . " ) ";
                    }
                    elseif ($param['type'] === 'array') {
                        {
                            $constraint .= " ( " . self::extract_csv_from_array($_POST[$param['postvar']]) . " ) ";
                        }
                    }
                    else {
                        throw new ErrorException();
                    }


                }
            }
        }
    }
}




/**
class SearchResultPage extends DatabaseConnectionPage {

function build_query() {
$result = read_search_results($db_conn);
$numrows = ocifetchstatement($parsed, $results);
if ($numrows > 1000) {

echo "<b>" .$numrows . " Results found</b><br>(Information listed below is partial view of search result)<br>";
$numrows=1000;
}
else
{
echo "<b>" .$numrows . " Results found</b><br><br>";
}

echo "<table>";
//        make_table_heading($selected_categories);

for ($i=0; $i<$numrows;$i++ )
{
if ($i % 2 == 0 ) {
echo "<tr class=''>  ";
}
else {
echo "<tr class=''>  ";
}

}
//      export();
}

function print_content() {
$this->build_query();
}
}




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
  $query_string = " SELECT ";
  $query_string .= join($multiple_select_inputs, " , " ) . " , " .
    join($text_field_inputs, " , " );
  $query_string .= " WHERE 1 ";




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


*/