<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

abstract class SearchBase extends DatabaseConnectionPage {

    const EXPERIMENT_LABEL = "Experiments";
    const EXPERIMENT_SELECT_NAME = "Experiment[]";
    const EXPERIMENT_KEYVAL = "EXP_NAME";
    const CATEGORY_LABEL = "Categories";
    const CATEGORY_SELECT_NAME = "Category[]";
    const CATEGORY_KEYVAL = "CATG";
    const SPECIES_LABEL = "Species";
    const SPECIES_SELECT_NAME = "Species[]";
    const SPECIES_KEYVAL = "SPEC";
    const SUBJECT_LABEL = "Experiments";
    const SUBJECT_SELECT_NAME = "Subject[]";
    const SUBJECT_KEYVAL = "SUBJ";
    const REGVAL_LABEL = "Regulation Values";
    const REGVAL_SELECT_NAME = "RegulationValue[]";
    const REGVAL_KEYVAL = "REG_VAL";
    const BIOFUNCTION_LABEL = "Biofunction";
    const BIOFUNCTION_SELECT_NAME = "Biofunction[]";
    const BIOFUNCTION_KEYVAL = "BIOFUNCTION";


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

    protected function make_experiment_select($db_conn, $userid) {
        WidgetMaker::form_select(
            self::EXPERIMENT_LABEL,
            self::EXPERIMENT_SELECT_NAME,
            db_selectAllUnrestrictedExperimentList($db_conn, $userid),
            self::EXPERIMENT_KEYVAL);
    }
    protected function make_category_select($db_conn, $userid) {
        WidgetMaker::form_select(
            self::CATEGORY_LABEL,
            self::CATEGORY_SELECT_NAME,
            db_selectCategoryList($db_conn, $userid),
            self::CATEGORY_KEYVAL);
    }

    protected function make_species_select($db_conn, $userid) {
        WidgetMaker::form_select(
            self::SPECIES_LABEL,
            self::SPECIES_SELECT_NAME,
            db_selectSpeciesList($db_conn, $userid),
            self::SPECIES_KEYVAL);
    }
    protected function make_subject_select($db_conn, $userid) {
        WidgetMaker::form_select(
            self::SUBJECT_LABEL,
            self::SUBJECT_SELECT_NAME,
            db_selectSubjectList($db_conn, $userid),
            self::SUBJECT_KEYVAL);
    }
    protected function make_regval_select($db_conn, $userid) {
        WidgetMaker::form_select(
            self::REGVAL_LABEL,
            self::REGVAL_SELECT_NAME,
            db_selectRegValList($db_conn, $userid),
            self::REGVAL_KEYVAL);
    }
    protected function make_biofunction_select($db_conn, $userid) {
        WidgetMaker::form_select(
            self::BIOFUNCTION_LABEL,
            self::BIOFUNCTION_SELECT_NAME,
            db_selectBiofunctionList($db_conn, $userid),
            self::BIOFUNCTION_KEYVAL);
    }
}

