<?php
/**
Functions Below are divided into the following categories:
 * (1) General Functions
 * (2) Search-related functions
 * (3) Data Management functions
 * (4) User management functions
 *
 * Within each category, functions are divided into
 *(1) Select (2) Insert (3) Update (4) Delete
 *
 *
 * This file is also used to store CONST values used throughout
 *   the application. Wherever possible, the names and ids
 *   of FORM INPUT widgets are set to the name of the appropriate
 *   Database Columns.  This has been done to facilitate the
 *   sharing of element names betwen separate scripts and to
 *   reduce the probabily of errors caused by spelling discrepancies, etc.
 *
 *
 * Class aliased as dbFn
 */

class DBFunctionsAndConsts
{
    // Username, Password, DB
    const db_UN = "drosophilarc2";
    const db_PASS = "drosopivot";
    const db_DB = "//127.0.0.1/ORATIKI";


    // Time limit for DB transaction
    const TIME_LIMIT = 6000;



    // Names of PADMA Tables and Views
    const FULLVIEW_TBL = 'FULL_V';
    const EXPERIMENT_TBL = 'EXPERIMENT';
    const REFERENCE_MAIN_TBL = 'REFERENCE_MAIN';
    const EXPERIMENT_MASTER_TBL = 'EXPERIMENT_MASTER';
    const REFERENCE_GO_TBL = 'REFERENCE_GO';
    const REFERENCE_BIO_TBL = 'REFERENCE_BIO';
    const CLIENT_TBL = 'CLIENT';

    // Columns Names for the majority of the tables
    const EXP_NAME_COL = "EXP_NAME";
    const PROB_ID_COL  = "PROB_ID";
    const CATG_COL = 'CATG';
    const SPEC_COL = 'SPEC';
    const SUBJ_COL = 'SUBJ';
    const REG_VAL_COL = 'REG_VAL';
    const OPEN_COL = 'OPEN';
    const CREATED_BY_COL = 'CREATED_BY';
    const CREATED_ON_COL = 'CREATED_ON';
    const RESTRICTED_COL  = 'RESTRICTED';
    const HOUR_COL = 'HOUR';
    const CGNUMBER_COL = 'CGNUMBER';
    const GENENAME_COL = 'GENENAME';
    const FBGNNUMBER_COL = 'FBGNNUMBER';
    const VERSION_COL = 'VERSION';
    const GONUMBER_COL = 'GONUMBER';
    const BIOFUNCTION_COL = 'BIOFUNCTION';
    const EXP_DESC_COL = 'EXP_DESC';
    const QUANTITY_COL = 'QUANTITY';
    const C_ID_COL = 'C_ID';
    const TITLE_COL = 'TITLE';
    const LNAME_COL = 'LNAME';
    const MNAME_COL = 'MNAME';
    const FNAME_COL = 'FNAME';
    const ADD_1_COL = 'ADD_1';
    const ADD_2_COL = 'ADD_2';
    const CITY_COL = 'CITY';
    const STATE_COL = 'STATE';
    const ZIP_COL = 'ZIP';
    const PHONE_COL = 'PHONE';
    const EMAIL_COL = 'EMAIL';
    const IND_COL = 'IND';
    const PROF_COL = 'PROF';
    const ACC_RIGHT_ID_COL = 'ACC_RIGHT_ID';
    const DEL_FLAG_COL = 'DEL_FLAG';
    const UPDATED_BY_COL = 'UPDATED_BY';
    const UPDATED_ON_COL = 'UPDATED_ON' ;
    const USER_ID_COL = 'USER_ID';
    const PASSWORD_COL = 'PASSWORD';
    const LAST_LOGIN_COL = 'LAST_LOGIN';
    const TOTAL_LOGIN_COL = 'TOTAL_LOGIN';
    const COUNTRYNAME_COL = 'COUNTRY';
    const COUNTRYID_COL = 'COUNTRYID';
    const DATE_APPLIED_COL = 'DATE_APPLIED';

    // Many columns are different in Full View
    const FULL_VIEW_PROBE_ID = "PROBEID";
    const FULL_VIEW_CGNUMBER = "CGNUMBER";
    const FULL_VIEW_FBNUM = "FBCGNUMBER";
    const FULL_VIEW_SUBJ = "EXPERIMENTSUBJECT";
    const FULL_VIEW_NAME = "EXPERIMENTNAME";
    const FULL_VIEW_CATG = "ACTIVECATEGORY";
    const FULL_VIEW_SPEC = "ACTIVESPECIES";
    const FULL_VIEW_REG_VAL = "REGULATIONVALUE";
    const FULL_VIEW_ADDITIONALINFO = "ADDITIONALINFO";

    // Column aliases used in this file
    const RIGHT_ALIAS = 'RIGHT';
    const TOTAL_ALIAS = 'TOTAL';

    // For Date-Time Processing
    // Note that there is some confusion about
    // DateTime representation among the database tables
    // For this reason, two formats are used in this php file
    // This should be fixed when the DB is normalized
    const DEFAULT_TIME_ZONE = 'America/New_York';
    const DATE_TIME_FORMAT = "m/d/y";
    const DATE_TIME_APPLIED_FORMAT = "d-M-y";

    // Necessary for constructing names of
    // FORM SELECT widgets which allow "multiple"
    const POST_MULTIPLE = '[]';


    // row limit for Search query
    const SEARCH_RESULT_LIMIT = 1000;

    /**********************************************
     *
     * GENERAL FUNCTIONS
     *
     **********************************************/


    /**
     * Connects to the Database
     * Called from DatabaseconnectionPage and all Page.php subclasses
     *   as well as from several Script.php and AJAX.php files
     *
     * @return resource: Database connection
     */
    static function connect_to_db()
    {
        set_time_limit(self::TIME_LIMIT);

        $db_conn = oci_connect(self::db_UN, self::db_PASS, self::db_DB);
        if (!$db_conn) {
            self::db_conn_failure(oci_error());
        }
        return $db_conn;
    }

    /**
     * Used to handle the occurence of any database failures
     * Prints an error message to on the page
     *
     * @param $err: Database Error
     * @return string: invokes the creation of the Error Page
     */
    static function db_conn_failure($err)
    {
        $oci_error_message = htmlentities($err['message']);
        $error_message = <<<EOT
    <br>
    $oci_error_message
     <br>
     Error connecting to Database, Please try back later.
     <br>

EOT;
        PageControlFunctionsAndConsts::redirectDueToError($error_message);
        return;
    }


    /**
     * Used to create standard DateTime strings for the database
     *
     * Note that there is DateTimes are inconsistently represented
     *    among the DB tables.  This needs to be normalized
     *
     * @return string: Appropriate DateTime DB representation
     */
    static function now() {
        if (! date_default_timezone_get()) {
            date_default_timezone_set(self::DEFAULT_TIME_ZONE);
        }
        return date(self::DATE_TIME_FORMAT);
    }



    /**
     * Used to create standard DateTime strings for the database
     *
     * Note that there is DateTimes are inconsistently represented
     *    among the DB tables.  This needs to be normalized
     *
     * @return string: Appropriate DateTime DB representation
     */
    static function now_applied() {
        if (! date_default_timezone_get()) {
            date_default_timezone_set(self::DEFAULT_TIME_ZONE);
        }
        return date(self::DATE_TIME_APPLIED_FORMAT);
    }

    /**
     * Executes all INSERT, UPDATE, DELETE queries
     *
     * @param $db_conn:  Database connection
     * @param $query: Query string
     */
    private static function execute_NON_SELECT_query($db_conn, $query)
    {
        $parsed = oci_parse($db_conn, $query);
        oci_execute($parsed);
    }

    /**
     * Executes all SELECT queries and returns the RESULTS handle
     *
     * @param $db_conn:  Database connection
     * @param $query: Query string
     *
     * @return resource:  RESULTS handle
     */
    private static function execute_SELECT_query_and_return($db_conn, $query)
    {
        $parsed = oci_parse($db_conn, $query);
        oci_execute($parsed);
        return $parsed;
    }

    /**********************************************
     *
     * SEARCH QUERIES
     *
     **********************************************/


    /**
     * Used to populate BIOFUNCTION SELECT input on search form
     *
     * @param $db_conn: connection to DB
     *
     * @return resource: Handle to Results
     */
    static function selectBiofunctionList($db_conn)
    {
        $query = "select distinct " . self::BIOFUNCTION_COL . " as " . self::BIOFUNCTION_COL . " from " . self::REFERENCE_BIO_TBL . " order by " . self::BIOFUNCTION_COL ;
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used to populate CATEGORY SELECT input on search form
     *
     * @param $db_conn: connection to DB
     * @param $userid:  Some categories are restricted to certain users
     *
     * @return resource: Handle to Results
     */
    static function selectCategoryList($db_conn, $userid)
    {
        $query = "select distinct " . self::CATG_COL . " from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='0'	UNION select distinct " . self::CATG_COL . " from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='1' AND	CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used to populate SPECIES SELECT input on search form
     *
     * @param $db_conn: connection to DB
     * @param $userid:  Some species are restricted to certain users
     *
     * @return resource: Handle to Results
     */
    static function selectSpeciesList($db_conn, $userid)
    {
        $query = "select distinct SPEC from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='0'	UNION select distinct SPEC from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='1' AND	CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used to populate SUBJECT SELECT input on search form
     *
     * @param $db_conn: connection to DB
     * @param $userid:  Some subjects are restricted to certain users
     *
     * @return resource: Handle to Results
     */
    static function selectSubjectList($db_conn, $userid)
    {
        $query = "select distinct SUBJ from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='0'	UNION select distinct SUBJ from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='1' AND	CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used to populate REGULATION VALUE SELECT input on search form
     *
     * @param $db_conn: connection to DB
     * @param $userid:  Some regulation values are restricted to certain users
     *
     * @return resource: Handle to Results
     */
    static function selectRegValList($db_conn, $userid)
    {
        $query = "select distinct " . self::REG_VAL_COL . " from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='0'	UNION select distinct " . self::REG_VAL_COL . " from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='1' AND	CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @unused
     * Could be used to populate GENENAME SELECT input on search form
     *
     * However, GENENAME is now only a TEXTAREA input.
     *   so this is unused
     *
     * @param $db_conn: connection to DB
     *
     * @return resource: Handle to Results
     */
    static function selectGeneNameList($db_conn)
    {
        $query = "select distinct " . self::GENENAME_COL . " from " . self::FULLVIEW_TBL . " where " . self::RESTRICTED_COL . " ='0' order by GENENAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }


    /**
     * Used to retrieve RESULTS of a database search
     *
     * @param $db_conn: connection to DB
     * @param $userid:  Some regulation values are restricted to certain users
     * @param $constraint
     *
     * @return resource: Handle to Results
     */

    static function selectSearchResult($db_conn, $userid, $constraint) {
        $query = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,
GONUMBER, " . self::BIOFUNCTION_COL . ",REGULATIONVALUE,ADDITIONALINFO,HOUR FROM  " . self::FULLVIEW_TBL . " where  {$constraint}  AND
RESTRICTED='0' AND rownum <= ". self::SEARCH_RESULT_LIMIT . " UNION SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES,
        EXPERIMENTSUBJECT,GONUMBER, " . self::BIOFUNCTION_COL . ",REGULATIONVALUE,ADDITIONALINFO,HOUR FROM " .self::FULLVIEW_TBL . " where  {$constraint} AND RESTRICTED='1' and CREATED_BY='{$userid}'  AND rownum <= ". self::SEARCH_RESULT_LIMIT . " ORDER BY 5,1 " ;
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**********************************************
     *
     * DATA ADMIN AND SEARCH SHARED FUNCTIONS
     *
     **********************************************/

    /**
     * Used in SEARCH to populate EXPERIMENT SELECT input on search form
     * Used in DATA ADMIN for Administrative User to Delete Experiments
     * Populates SELECT input
     *
     * @param $db_conn: connection to DB
     * @param $userid:  Some regulation values are restricted to certain users
     *
     * @return resource: Handle to Results
     */
    static function selectAllUnrestrictedExperimentList($db_conn, $userid)
    {
        $query = "select distinct " . self::EXP_NAME_COL . " from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='0' UNION select distinct " . self::EXP_NAME_COL . " from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='1' AND CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**********************************************
     *
     * DATA ADMIN FUNCTIONS
     *
     **********************************************/

    /**
     * Checks to see whether Experiment is in the Database.
     * Used when uploading a new experiment to the DB
     *
     * @param $db_conn: Database connection
     * @param $exp_name: Name of Experiment
     *
     * @return bool: Whether experiment is in Database
     */
    static function isExperimentInDB($db_conn, $exp_name) {

        $query =   "SELECT  count(*) as " . self::TOTAL_ALIAS . " FROM " . self::EXPERIMENT_TBL . "  WHERE EXP_NAME='$exp_name'";
        $stid  =  self::execute_SELECT_query_and_return($db_conn, $query);
        $row = oci_fetch_assoc($stid);
        $count = $row[self::TOTAL_ALIAS];
        return ($count != 0);
    }

    /**
     * Checks to see whether Version is in the Database.
     * Used when uploading a new experiment to the DB
     *
     * @param $db_conn: Database connection
     * @param $version_name: Name of Version
     *
     * @return bool: Whether experiment is in Database
     */
    static function isVersionInDB($db_conn, $version_name) {

        $query =   "SELECT  count(*) as " . self::TOTAL_ALIAS . " FROM " . self::REFERENCE_MAIN_TBL . "  WHERE " . self::VERSION_COL . "='$version_name'";
        $stid  =  self::execute_SELECT_query_and_return($db_conn, $query);
        $row = oci_fetch_assoc($stid);
        $count = $row[self::TOTAL_ALIAS];
        return ($count != 0);
    }

    /**
     * Used in DATA ADMIN for Researcher to Delete Experiments
     * Populates SELECT input
     *
     * @param $db_conn: connection to DB
     * @param $userid:  Some regulation values are restricted to certain users
     *
     * @return resource: Handle to Results
     */
    static function selectUserRestrictedExperimentList($db_conn, $userid)
    {
        $query = "select distinct " . self::EXP_NAME_COL . " from " . self::EXPERIMENT_TBL . " where " . self::RESTRICTED_COL . " ='1' AND CREATED_BY='" . $userid . "' order by EXP_NAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used in DATA ADMIN by Administrator for Editing Experiment Names
     *
     * Populates SELECT input

     * @param $db_conn: connection to DB
     *
     * @return resource: Handle to Results
     */
    static function selectUnrestrictedExperimentListFromMaster($db_conn)
    {
        $query = "select " . self::EXP_NAME_COL . " from EXP_MASTER where " . self::RESTRICTED_COL . " ='0' order by EXP_NAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used in DATA ADMIN by Researcher for Editing Experiment Names
     * Populates SELECT input
     *
     * @param $db_conn: connection to DB
     * @param userid:  Id of Researcher
     *
     * @return resource: Handle to Results
     */
    static function selectRestrictedExperimentListFromMaster($db_conn, $userid)
    {
        $query = "select " . self::EXP_NAME_COL . " from " . self::EXPERIMENT_MASTER_TBL . " where " . self::RESTRICTED_COL . " ='0' and CREATED_BY='{$userid}' order by EXP_NAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used in DATA ADMIN by Researcher for Editing Experiment Names
     * Populates SELECT input
     *
     * @param $db_conn: connection to DB
     * @param userid:  Id of Researcher
     *
     * @return resource: Handle to Results
     */
    static function selectExperimentDescription($db_conn, $name)
    {
        $query = "SELECT EXP_MASTER.* FROM " . self::EXPERIMENT_MASTER_TBL . " WHERE EXP_MASTER.EXP_NAME = '{$name}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used in DATA ADMIN for Deleting Versions
     * Populates SELECT input
     *
     * @param $db_conn: connection to DB
     *
     * @return resource: Handle to Results
     */
    static function selectVersionList($db_conn)
    {
        $query = "select distinct " . self::VERSION_COL . " from " . self::REFERENCE_MAIN_TBL . " order by " . self::VERSION_COL ;
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used to Insert a new Experiment in EXPERIMENT table
     *
     * @param $db_conn: DB connection
     * @param $prob_id: Probe ID
     * @param $exp_name: Experiment Name
     * @param $catg:  Category
     * @param $spec: Species
     * @param $subj:  Subject
     * @param $reg_val: Regulation Value
     * @param $open: ?
     * @param $userid:  User ID
     * @param $date:  Date of insertion
     * @param $restricted:  Whether restricted to user
     * @param $hour: ?
     */
    static function insertIntoExpTbl($db_conn, $prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $userid,
                                     $date, $restricted, $hour)
    {
        $query = "insert into " . self::EXPERIMENT_TBL . " VALUES('{$prob_id}','{$exp_name}','{$catg}' ,'{$spec}','{$subj}','{$reg_val}','{$open}','{$userid}', '{$date}','{$restricted}','{$hour}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Used to Insert a new Experiment in EXPERIMENT_MASTER table
     * @param $db_conn:  Database table
     * @param $name:  Name of Experiment
     * @param $description: Description
     * @param $userid:  User who inserted
     * @param $date:  Date of insertion
     * @param $restricted:  Whether Restricted
     * @param $recNum:  Count of records in the EXPERIMENT table
     */
    static function insertIntoExpMasterTbl($db_conn, $name, $description, $userid, $date, $restricted, $recNum)
    {
        $query = "insert into " . self::EXPERIMENT_MASTER_TBL . " VALUES('$name', '$description', '$userid', '$date', '$restricted', $recNum)";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Inserts Reference Version in REFERENCE_MAIN table
     *
     * @param $db_conn: Database COnnection
     * @param $probeid:  Probe ID
     * @param $cgname:  ?
     * @param $genename:  Gene Name
     * @param $flybasenum:  Flybase ID
     * @param $version:   Database Verion
     * @param $userid:   User who inserted
     * @param $date:  Date of Insertion
     */
    static function insertReference($db_conn, $probeid, $cgname, $genename, $flybasenum, $version, $userid, $date)
    {
        $query = "insert into " . self::REFERENCE_MAIN_TBL . " VALUES('{$probeid}', '{$cgname}', '{$genename}' ,'{$flybasenum}', '{$version}', '{$userid}', '{$date}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Inserts Reference Version into REFERENCE_GO table
     *
     * @param $db_conn: Databaase Connection
     * @param $probeid: Probe ID
     * @param $gonumber: GO number
     * @param $version: Reference Version
     * @param $userid: User who inserted
     * @param $date:  Date of insertion
     */
    static function insertReferenceGo($db_conn, $probeid, $gonumber, $version, $userid, $date)
    {
        $query = "insert into " . self::REFERENCE_GO_TBL . " VALUES('{$probeid}', '{$gonumber}', '{$version}', '{$userid}', '{$date}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Inserts into REFERENCE_BIO table
     * @param $db_conn:  Database connection
     * @param $gonumber:  GO number
     * @param $biofunction: Biological function
     * @param $version:  Reference Version
     * @param $userid:  User who inserted
     * @param $date:  Date of insertion
     */
    static function insertReferenceBio($db_conn, $gonumber, $biofunction, $version, $userid, $date)
    {
        $query = "insert into " . self::REFERENCE_BIO_TBL . " VALUES('{$gonumber}', '{$biofunction}', '{$version}', '{$userid}', '{$date}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Used to Edit Experiment Description
     *
     * @param $db_conn: Database connection
     * @param $name:  Name of Experiment
     * @param $description:  Description of experiment
     */
    static function updateExperimentDescription($db_conn, $name, $description)
    {
        $query = "update " . self::EXPERIMENT_MASTER_TBL . " set EXP_DESC='{$description}' WHERE EXP_MASTER.EXP_NAME = '{$name}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Deletes Experiment from EXPERIMENT table
     *
     * @param $db_conn: Database Connection
     * @param $name:  Name of Experiment
     */
    static function deleteExperiment($db_conn, $name)
    {
        self::deleteExpFromExpTbl($db_conn, $name);
        self::deleteExpFromExMasterTbl($db_conn, $name);
    }

    /**
     * Deletes Experiment from EXPERIMENT table
     *
     * @param $db_conn: Database Connection
     * @param $name:  Name of Experiment
     */
    static function deleteExpFromExpTbl($db_conn, $name)
    {
        $query = "delete from " . self::EXPERIMENT_TBL . " where EXP_NAME='{$name}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Deletes Experiment from EXPERIMENT_MASTER table
     *
     * @param $db_conn: Database Connection
     * @param $name:  Name of Experiment
     */
    static function deleteExpFromExMasterTbl($db_conn, $name)
    {
        $query = "delete from " . self::EXPERIMENT_MASTER_TBL . " where EXP_NAME='{$name}'";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

    /**
     * Deletes Reference Version from
     *   REFERENCE_MAIN, REFERENCE_GO, and REFERENCE_BIO
     *
     * @param $db_conn:  Database Connection
     * @param $version:  Reference Version
     */
    static function deleteReference($db_conn, $version)
    {
        self::deleteReferenceFromMain($db_conn, $version);
        self::deleteReferenceFromGo($db_conn, $version);
        self::deleteReferenceFromBio($db_conn, $version);
    }

    /**
     * Deletes Reference Version from REFERENCE_MAIN
     *
     * @param $db_conn:  Database Connection
     * @param $version:  Reference Version
     */
    static function deleteReferenceFromMain($db_conn, $version)
    {
        $query = "delete from " . self::REFERENCE_MAIN_TBL . " where " . self::VERSION_COL . "='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Deletes Reference Version from REFERENCE_GO
     *
     * @param $db_conn:  Database Connection
     * @param $version:  Reference Version
     */
    static function deleteReferenceFromGo($db_conn, $version)
    {
        $query = "delete from " . self::REFERENCE_GO_TBL . " where " . self::VERSION_COL . "='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Deletes Reference Version from REFERENCE_BIO
     *
     * @param $db_conn:  Database Connection
     * @param $version:  Reference Version
     */
    static function deleteReferenceFromBio($db_conn, $version)
    {
        $query = "delete from " . self::REFERENCE_BIO_TBL . " where " . self::VERSION_COL . "='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**********************************************
     *
     * USER ADMIN FUNCTIONS
     *
     **********************************************/


    /**
     * Used to check whether UserID is already being used
     *
     * @param $db_conn: database connection
     * @param $userid: UserID being checked
     *
     * @return bool: Whether it is already in use
     */
     static function isUserInDB_byID($db_conn, $userid)
    {
        $userid = strtoupper(trim($userid));
        $query = "select COUNT(*) AS " . self::TOTAL_ALIAS . " from " . self::CLIENT_TBL . " WHERE USER_ID = '{$userid}'";

        $db_statement = self::execute_SELECT_query_and_return($db_conn, $query);
        $row = oci_fetch_assoc($db_statement);

        $count = $row[self::TOTAL_ALIAS];
        return ($count != 0);
    }

    /**
     * Checks for a User/Password match when Password change is requested
     *
     * @param $db_conn: Database connection
     * @param $userid : User id
     * @param $password : Password
     *
     * @return bool : Whether there is a match
     */
    static function isUserInDB_ByIDAndPW($db_conn, $userid, $password)
    {
        $userid = strtoupper(trim($userid));
        $password = sha1($password);
        $query = "select count(*) as " . self::TOTAL_ALIAS . " from " . self::CLIENT_TBL . " WHERE USER_ID = '{$userid}' and PASSWORD='{$password}'";
        $db_statement = self::execute_SELECT_query_and_return($db_conn, $query);
        $row = oci_fetch_assoc($db_statement);

        $count = $row[self::TOTAL_ALIAS];
        return ($count != 0);
    }


    /**
     * Used in Profile Creation and Update to populate TITLE SELECT
     *
     * @param $db_conn
     *
     * @return resource: Handle to Results
     */
    static function selectTitleList($db_conn) {
        $query = "select distinct title from client";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }


    /**
     * Used in Profile Creation and Update to populate COUNTRY select input
     *
     * @param $db_conn: Database connection
     *
     * @return resource: Handle to Results
     */
    static function selectCountryList($db_conn)
    {
        $query = "select distinct country, countryid from country order by countryid";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used to Populate UserAdmin SELECT input
     *
     * @param $db_conn: Database connection
     *
     * @return resource: Handle to Results
     */
    static function selectNewUserList($db_conn)
    {
        $query = "select c_id,fname,lname from client where ACC_RIGHT_ID = 0 order by lname ";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used to Populate UserAdmin SELECT input
     *
     * @param $db_conn: Database connection
     *
     * @return resource: Handle to Results
     */
    static function selectExistingUserList($db_conn)
    {
        $query = "select c_id,fname,lname from client where ACC_RIGHT_ID > 0 order by lname ";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used in UserAdmin to Populate Access Right SELECT input
     *
     * @param $db_conn: Database connection
     *
     * @return resource: Handle to Results
     */
    static function selectAccessRightList($db_conn)
    {
        $query = "select ACC_RIGHT_ID,ACC_RIGHT_DESC from ACCESS_RIGHT order by ACC_RIGHT_DESC ";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * For User to edit her own Profile
     *
     * @param $db_conn: Database connection
     * @param user:  USER_ID of current logged-in User
     *
     * @return resource: Handle to Results
     */
    static function selectProfileInfoByUserID($db_conn, $userid)
    {
        $userid = strtoupper($userid);
        $query = "select " . self::TITLE_COL ."," . self::FNAME_COL .",". self::LNAME_COL .",".
            self::MNAME_COL .",". self::ADD_1_COL .",". self::ADD_2_COL .",". self::CITY_COL .",".
            self::STATE_COL .",". self::ZIP_COL .",". self::COUNTRYNAME_COL .",". self::PHONE_COL .",".
            self::EMAIL_COL .",". self::IND_COL .",". self::PROF_COL .",".
            self::UPDATED_BY_COL .",". self::UPDATED_ON_COL .
            " from client where user_id = '{$userid}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used in UserMangement to get UserProfile
     *
     * @param $db_conn: Database connection
     * @param $cid:  Client ID of User
     *
     * @return resource: Handle to Results
     */
    static function selectProfileInfoByCID($db_conn, $cid)
    {
        $query = "SELECT CLIENT.*, ACCESS_RIGHT.ACC_RIGHT_DESC as RIGHT FROM " . self::CLIENT_TBL . " INNER JOIN ACCESS_RIGHT ON CLIENT.ACC_RIGHT_ID = ACCESS_RIGHT.ACC_RIGHT_ID WHERE CLIENT.c_id = '{$cid}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Updates User Profile with new data entered
     *
     * @param $db_conn : Database Connection
     * @param $title : Name title
     * @param $lname:  Last name
     * @param $fname:  First Name
     * @param $mname :  Middle name
     * @param $address1 :  First line of Address
     * @param $address2 : Second line of Address
     * @param $city : City
     * @param $state : State
     * @param $zip : Zip Code
     * @param $country : Country
     * @param $phone : Phone
     * @param $email : Email
     * @param $industry : Industry
     * @param $profession : Profession
     * @param $userid : Id of User
     */
    static function updateUserProfile($db_conn, $title, $lname, $fname, $mname,
                                      $address1, $address2, $city, $state, $zip, $country,
                                      $phone, $email, $industry, $profession, $userid)
    {
        $email = strtoupper($email);
        $userid = strtoupper($userid);
        $query = "update " . self::CLIENT_TBL . " set TITLE='{$title}',LNAME='{$lname}',FNAME='{$fname}',MNAME='{$mname}'," .
            "ADD_1=' {$address1}',
ADD_2='{$address2}',CITY='{$city}',STATE= '{$state}',ZIP ='{$zip}',COUNTRY='{$country}'," .
            "PHONE= '{$phone}',EMAIL='{$email}',IND='{$industry}',PROF='{$profession}'," .
            "UPDATED_BY='{$userid}',UPDATED_ON=SYSDATE WHERE USER_ID='{$userid}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Updates User Profile with new data entered
     *
     * @param $db_conn : Database Connection
     * @param $title : Name title
     * @param $lname:  Last name
     * @param $fname:  First Name
     * @param $mname :  Middle name
     * @param $address1 :  First line of Address
     * @param $address2 : Second line of Address
     * @param $city : City
     * @param $state : State
     * @param $zip : Zip Code
     * @param $country : Country
     * @param $phone : Phone
     * @param $email : Email
     * @param $industry : Industry
     * @param $profession : Profession
     * @param $userid : Id of User
     */
    static function insertUserProfile($db_conn, $title, $lname, $mname, $fname,
                                      $address1, $address2, $city, $state, $zip, $country,
                                      $phone, $email, $industry, $profession, $userid, $password, $date)
    {
        $query = "INSERT INTO " . self::CLIENT_TBL . " (C_ID,TITLE,LNAME,MNAME,FNAME,ADD_1,ADD_2,CITY,STATE,ZIP,COUNTRY," .
            "PHONE,EMAIL,IND,PROF,USER_ID,PASSWORD," .
            "DATE_APPLIED,TOTAL_LOGIN,ACC_RIGHT_ID,DEL_FLAG) " .
            "VALUES(CLIENT_ID.NEXTVAL,'$title', '$lname', '$mname', '$fname', " .
            "'$address1', '$address2', '$city', '$state', '$zip', '$country'," .
            "'$phone', '$email', '$industry', '$profession', '$userid', '$password', '$date',0,0,0)";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * For the User to edit her own Password
     *
     * @param $db_conn : Database Connection
     * @param $userid : USER_ID of User
     * @param $password:  Password of user
     */
    static function updatePasswordByUserID($db_conn, $userid, $password) {
        $password = sha1($password);
        $userid = strtoupper($userid);
        $query = "update " . self::CLIENT_TBL . " set PASSWORD= '{$password}' WHERE USER_ID = '{$userid}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }
    /**
     * For an admin to edit a user's Password
     *
     * @param $db_conn : Database Connection
     * @param $cid : CLIENT_ID of User
     * @param $password:  Password of user
     */
    static function updatePasswordByCID($db_conn, $cid, $password)
    {
        $password = sha1($password);
        $query = "update " . self::CLIENT_TBL . " set PASSWORD= '{$password}' WHERE C_ID = $cid";
        self::execute_NON_SELECT_query($db_conn, $query);
    }


    /**
     * Used to retrieve an email when sending her a new password
     *
     * @param $db_conn: Database connection
     * @param $cid: Client ID
     *
     * @return resource:  Handle to results
     */
    static function selectEmailFromCID($db_conn, $cid) {
        $query = "select EMAIL from " . self::CLIENT_TBL . " WHERE C_ID=$cid";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * Used in UserAdmin to update a User's access right
     * @param $db_conn:  Database Connection
     * @param $cid :  CLient Connection
     * @param $accessright :  User's access
     * @param $updatedby : Person who updates
     * @param $date : Date of updating
     */
    static function updateUserRight($db_conn, $cid, $accessright, $updatedby, $date)
    {
        $query = "UPDATE " . self::CLIENT_TBL . " SET ACC_RIGHT_ID='$accessright', UPDATED_BY='$updatedby',updated_on='$date' WHERE C_ID='$cid'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Used in UserAdmin to turn on Delete Flag
     *
     * NOTE:  THIS DOES NOT ACTUALLY DELETE USER FROM DB
     *
     * @param $db_conn:  Database Connection
     * @param $cid :  CLient Connection
     * @param $updatedby : Person who updates
     * @param $date : Date of updating
     */
    static function deleteUser($db_conn, $cid, $updatedby, $date)
    {
        $query = "UPDATE " . self::CLIENT_TBL . " SET DEL_FLAG='1', UPDATED_BY='$updatedby',UPDATED_ON='$date' WHERE C_ID=$cid";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * Used in UserAdmin to turn off Delete Flag
     *
     * @param $db_conn:  Database Connection
     * @param $cid :  CLient Connection
     * @param $updatedby : Person who updates
     * @param $date : Date of updating
     */
    static function updateUserActivation($db_conn, $cid, $updatedby, $date)
    {
        $query = "UPDATE " . self::CLIENT_TBL . " SET DEL_FLAG='0', UPDATED_BY='$updatedby',UPDATED_ON='$date' WHERE C_ID=$cid";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

}

class_alias('DBFunctionsAndConsts', 'dbFn');