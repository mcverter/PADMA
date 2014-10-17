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


    const PROBEID_POSTVAR = "probeid";
    const CGNUM_POSTVAR = "cgnum";
    const FLYBASE_POSTVAR = "flybasenum";
    const GONUMBER_POSTVAR = "gonum";
    const GENENAME_POSTVAR = "genename";
    const EXPERIMENT_POSTVAR = "Experiment[]";
    const CATEGORY_POSTVAR = "Category[]";
    const SPECIES_POSTVAR = "Species[]";
    const SUBJECT_POSTVAR = "Subject[]";
    const REGVAL_POSTVAR = "RegulationValue[]";
    const BIOFUNCTION_POSTVAR = "Biofunction[]";


    const EXPERIMENT_EXP_TBL_COL = "EXP_NAME";
    const CATEGORY_EXP_TBL_COL = "CATG";
    const SPECIES_EXP_TBL_COL = "SPEC";
    const SUBJECT_EXP_TBL_COL = "SUBJ";
    const REGVAL_EXP_TBL_COL = "REG_VAL";
    const BIOFUNCTION_EXP_TBL_COL = "BIOFUNCTION";


    const FLYBASE_FULLVIEW_TBL_COL = 'FBCGNUMBER';

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


    static $result_cols = array (
        array (
            'col' =>self::PROBEID_FULLVIEW_TBL_COL,
            'type' =>'string',
            'postvar' => self::PROBEID_POSTVAR,
            'heading' => self::PROBEID_HEADING
        ),
        array (
            'col' =>self::CGNUMBER_FULLVIEW_TBL_COL,
            'type' =>'string',
            'postvar' => self::CGNUM_POSTVAR,
            'heading' => self::CGNUMBER_HEADING
        ),
        array (
            'col' =>self::FLYBASE_FULLVIEW_TBL_COL,
            'type' =>'string',
            'postvar' => self::FLYBASE_POSTVAR,
            'heading' => self::FLYBASE_HEADING
        ),
        array (
            'col' =>self::GONUMBER_FULLVIEW_TBL_COL,
            'type' =>'string',
            'postvar' => self::GONUMBER_POSTVAR,
            'heading' => self::GONUMBER_HEADING
        ),
        array (
            'col' =>self::GENENAME_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::GENENAME_POSTVAR,
            'heading' => self::GENENAME_HEADING

        ),
        array (
            'col' =>self::BIOFUNCTION_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::BIOFUNCTION_POSTVAR,
            'heading' => self::BIOFUNCTION_HEADING
        ),
        array (
            'col' =>self::EXPERIMENTNAME_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::EXPERIMENT_POSTVAR,
            'heading' => self::EXPERIMENTNAME_HEADING
        ),
        array (
            'col' =>self::ACTIVECATEGORY_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::CATEGORY_POSTVAR,
            'heading' => self::ACTIVECATEGORY_HEADING
        ),
        array (
            'col' =>self::ACTIVESPECIES_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::SPECIES_POSTVAR,
            'heading' => self::ACTIVESPECIES_HEADING
        ),
        array (
            'col' =>self::EXPERIMENTSUBJECT_FULLVIEW_TBL_COL,
            'type' =>'array',
            'postvar' => self::SUBJECT_POSTVAR,
            'heading' => self::EXPERIMENTSUBJECT_HEADING

        ),
    );




    protected function make_probeid_text_input() {
       return  wMk::text_input("Probe Id:", self::PROBEID_POSTVAR);
    }
    protected function make_cgnumber_text_input() {
        return wMk::text_input("CG Number:", self::CGNUM_POSTVAR);
    }
    protected function make_flybasenumber_text_input() {
        return wMk::text_input("Flybase Number:", self::FLYBASE_POSTVAR);
    }
    protected function make_genename_text_input() {
        return wMk::text_input("Gene Name:", self::GENENAME_POSTVAR);
    }
    protected function make_gonumber_text_input() {
        return wMk::text_input("GO Number:", self::GONUMBER_POSTVAR);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_experiment_select($db_conn, $userid) {
        return wMk::select_input(
            self::EXPERIMENT_LABEL,
            self::EXPERIMENT_POSTVAR,
            dbFn::selectAllUnrestrictedExperimentList($db_conn, $userid),
            self::EXPERIMENT_EXP_TBL_COL);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_category_select($db_conn, $userid) {
        return wMk::select_input(
            self::CATEGORY_LABEL,
            self::CATEGORY_POSTVAR,
            dbFn::selectCategoryList($db_conn, $userid),
            self::CATEGORY_EXP_TBL_COL);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_species_select($db_conn, $userid) {
        return wMk::select_input(
            self::SPECIES_LABEL,
            self::SPECIES_POSTVAR,
            dbFn::selectSpeciesList($db_conn, $userid),
            self::SPECIES_EXP_TBL_COL);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_subject_select($db_conn, $userid) {
        return wMk::select_input(
            self::SUBJECT_LABEL,
            self::SUBJECT_POSTVAR,
            dbFn::selectSubjectList($db_conn, $userid),
            self::SUBJECT_EXP_TBL_COL);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    protected function make_regval_select($db_conn, $userid) {
        return wMk::select_input(
            self::REGVAL_LABEL,
            self::REGVAL_POSTVAR,
            dbFn::selectRegValList($db_conn, $userid),
            self::REGVAL_EXP_TBL_COL);
    }
    protected function make_biofunction_select($db_conn, $userid) {
        return wMk::select_input(
            self::BIOFUNCTION_LABEL,
            self::BIOFUNCTION_POSTVAR,
            dbFn::selectBiofunctionList($db_conn, $userid),
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
        $constraint = " 1=1 ";
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
        return $constraint;
    }
}




