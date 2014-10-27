
<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

/**
 * Class SearchBase
 */
abstract class SearchBase extends DatabaseConnectionPage
{
    // Widget Labels
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

    // Widget Names
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

    // Headings for Search Results
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

    /**
     * @var array
     */

    static $result_cols = array (
        array (
            'col' =>dbFn::FULL_VIEW_PROBE_ID,
            'type' =>'string',
            'postvar' => self::PROBEID_POSTVAR,
            'heading' => self::PROBEID_HEADING
        ),
        array (
            'col' =>dbFn::FULL_VIEW_CGNUMBER,
            'type' =>'string',
            'postvar' => self::CGNUM_POSTVAR,
            'heading' => self::CGNUMBER_HEADING
        ),
        array (
            'col' =>dbFn::FULL_VIEW_FBNUM,
            'type' =>'string',
            'postvar' => self::FLYBASE_POSTVAR,
            'heading' => self::FLYBASE_HEADING
        ),
        array (
            'col' => dbFn::GONUMBER_COL,
            'type' =>'string',
            'postvar' => self::GONUMBER_POSTVAR,
            'heading' => self::GONUMBER_HEADING
        ),
        array (
            'col' => dbFn::GENENAME_COL,
            'type' =>'array',
            'postvar' => self::GENENAME_POSTVAR,
            'heading' => self::GENENAME_HEADING

        ),
        array (
            'col' => dbFn::BIOFUNCTION_COL,
            'type' =>'array',
            'postvar' => self::BIOFUNCTION_POSTVAR,
            'heading' => self::BIOFUNCTION_HEADING
        ),
        array (
            'col' => dbFn::FULL_VIEW_NAME,
            'type' =>'array',
            'postvar' => self::EXPERIMENT_POSTVAR,
            'heading' => self::EXPERIMENTNAME_HEADING
        ),
        array (
            'col' =>dbFn::FULL_VIEW_CATG,
            'type' =>'array',
            'postvar' => self::CATEGORY_POSTVAR,
            'heading' => self::ACTIVECATEGORY_HEADING
        ),
        array (
            'col' =>dbFn::FULL_VIEW_SPEC,
            'type' =>'array',
            'postvar' => self::SPECIES_POSTVAR,
            'heading' => self::ACTIVESPECIES_HEADING
        ),
        array (
            'col' =>dbFn::FULL_VIEW_SUBJ,
            'type' =>'array',
            'postvar' => self::SUBJECT_POSTVAR,
            'heading' => self::EXPERIMENTSUBJECT_HEADING
        ),
    );


    /**
     * @return mixed
     */
    protected function make_probeid_text_input() {
       return  wMk::text_input("Probe Id:", self::PROBEID_POSTVAR);
    }

    /**
     * @return mixed
     */
    protected function make_cgnumber_text_input() {
        return wMk::text_input("CG Number:", self::CGNUM_POSTVAR);
    }

    /**
     * @return mixed
     */
    protected function make_flybasenumber_text_input() {
        return wMk::text_input("Flybase Number:", self::FLYBASE_POSTVAR);
    }

    /**
     * @return mixed
     */
    protected function make_genename_text_input() {
        return wMk::text_input("Gene Name:", self::GENENAME_POSTVAR);
    }

    /**
     * @return mixed
     */
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
            dbFn::EXP_NAME_COL,
            dbFn::EXP_NAME_COL
        );
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
            dbFn::CATG_COL,
            dbFn::CATG_COL
            );
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
            dbFn::SPEC_COL,
            dbFn::SPEC_COL
        );
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
            dbFn::SUBJ_COL,
            dbFn::SUBJ_COL

        );
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
            dbFn::REG_VAL_COL,
            dbFn::REG_VAL_COL

        );
    }

    /**
     * @param $db_conn
     * @param $userid
     * @return mixed
     */
    protected function make_biofunction_select($db_conn, $userid) {
        return wMk::select_input(
            self::BIOFUNCTION_LABEL,
            self::BIOFUNCTION_POSTVAR,
            dbFn::selectBiofunctionList($db_conn, $userid),
            dbFn::BIOFUNCTION_COL,
            dbFn::BIOFUNCTION_COL
        );
    }


    // Used for Search Results
    /**
     * @param $arr
     * @return string
     */
    static private function extract_csv_from_array($arr)
    {

        $csv = " ( '" . PageControlFunctionsAndConsts::unescape_space(array_pop($arr)) . "'";
        foreach ($arr as $v)
        {
            $csv .= " , '" . PageControlFunctionsAndConsts::unescape_space($v) ."' ";
        }
        $csv .= ") ";
        return $csv;
    }

    /**
     * @param $str
     * @return string
     */
    static private function extract_csv_from_string ($str)
    {
        return self::extract_csv_from_array(explode(',', $str ));
    }

    /**
     * @param $search_params
     * @return string
     * @throws ErrorException
     */
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




