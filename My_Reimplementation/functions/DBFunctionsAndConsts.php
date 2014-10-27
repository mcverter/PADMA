<?php
/**
Functions Below are divided into the following categories:
 * (1) Used for Multiple categories
 * (2) Search-related functions
 * (3) Data Management functions
 * (4) User management functions
 *
 * Within each category, functions are divided into
 *(1) Select (2) Insert (3) Update (4) Delete
 *
 * Naming convention:
 * To make it clear that these functions make direct database
 * calls and to avoid accidental name clobbering, all functions
 * will begin with the name of the CRUD function in ALLCAPS

 */
class DBFunctionsAndConsts
{

    const FULLVIEW_TBL = 'FULL_V';
    const EXPERIMENT_TBL = 'EXPERIMENT';
    const REFERENCE_MAIN_TBL = 'REFERENCE_MAIN';
    const EXPERIMENT_MASTER_TBL = 'EXPERIMENT_MASTER';
    const REFERENCE_GO_TBL = 'REFERENCE_GO';
    const REFERENCE_BIO_TBL = 'REFERENCE_BIO';
    const CLIENT_TBL = 'CLIENT';

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
    const COUNTRY_COL = 'COUNTRY';
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


    const TIME_LIMIT = 6000;
    const SEARCH_RESULT_LIMIT = 1000;

    /**
     * @return resource
     */
    static function connect_to_db()
    {
        $db_UN = "drosophilarc2";
        $db_PASS = "drosopivot";
        $db_DB = "//127.0.0.1/ORATIKI";

        set_time_limit(6000);
        $db_conn = oci_connect($db_UN, $db_PASS, $db_DB);
        if (!$db_conn) {
            self::db_conn_failure(oci_error());
        }
        return $db_conn;
    }

    /**
     * @param $err
     * @return string
     */
    static function db_conn_failure($err)
    {
        $error_message = htmlentities($err['message']);
        $returnString = <<<EOT

      $error_message
    <br>ERROR: Connecting to Database, Please try back later<br>;
    <a title='logout' href='oniondex.php'>Click Here</a> to go back to home page
EOT;
        return $returnString;
    }


    /**
     * @return bool|string
     */
    static function now() {
        return date("m/d/y");
    }

    /**
     * @param $db_conn
     * @param $query
     */
    private static function execute_NON_SELECT_query($db_conn, $query)
    {
        $parsed = ociparse($db_conn, $query);
        oci_execute($parsed);
    }

    /**
     * @param $db_conn
     * @param $query
     */
    private static function execute_SELECT_query_and_return($db_conn, $query)
    {
        $parsed = ociparse($db_conn, $query);
        oci_execute($parsed);
        return $parsed;
    }

    /**
     * @param $db_conn
     * @param $exp_name
     * @return bool
     */
    static function experimentInDB($db_conn, $exp_name) {

        $query =   "SELECT  count(*) as TOTAL FROM EXPERIMENT  WHERE EXP_NAME='$exp_name'";
        $stid  =  self::execute_SELECT_query_and_return($db_conn, $query);
        $row = oci_fetch_assoc($stid);
        $count = $row["TOTAL"];
        return ($count != 0);
    }

    /**
     * @param $db_conn
     * @param $version_name
     * @return bool
     */
    static function versionInDB($db_conn, $version_name) {

        $query =   "SELECT  count(*) as TOTAL FROM REFERENCE_MAIN  WHERE VERSION='$version_name'";
        $stid  =  self::execute_SELECT_query_and_return($db_conn, $query);
        $row = oci_fetch_assoc($stid);
        $count = $row["TOTAL"];
        return ($count != 0);
    }


    /**
     * @param $db_conn
     * @param $userid
     * @return resource
     */
    static function selectAllUnrestrictedExperimentList($db_conn, $userid)
    {
        $query = "select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='0' UNION select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='1' AND CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }


    /**
     * @param $db_conn
     * @param $userid
     * @return resource
     */
    static function selectUserRestrictedExperimentList($db_conn, $userid)
    {
        $query = "select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='1' AND CREATED_BY='" . $userid . "' order by EXP_NAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @return resource
     */
    static function selectBiofunctionList($db_conn)
    {
        $query = "select distinct biofunction as BIOFUNCTION from REFERENCE_BIO order by biofunction";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $userid
     * @return resource
     */
    static function selectCategoryList($db_conn, $userid)
    {
        $query = "select distinct CATG from EXPERIMENT where RESTRICTED ='0'	UNION select distinct CATG from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $userid
     * @return resource
     */
    static function selectSpeciesList($db_conn, $userid)
    {
        $query = "select distinct SPEC from EXPERIMENT where RESTRICTED ='0'	UNION select distinct SPEC from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $userid
     * @return resource
     */
    static function selectSubjectList($db_conn, $userid)
    {
        $query = "select distinct SUBJ from EXPERIMENT where RESTRICTED ='0'	UNION select distinct SUBJ from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $userid
     * @return resource
     */
    static function selectRegValList($db_conn, $userid)
    {
        $query = "select distinct REG_VAL from EXPERIMENT where RESTRICTED ='0'	UNION select distinct REG_VAL from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='{$userid}' order by 1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $userid
     * @param $constraint
     * @return resource
     */
    static function selectSearchResult($db_conn, $userid, $constraint) {
        $query = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,
GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM  " . self::FULLVIEW_TBL . " where  {$constraint}  AND
RESTRICTED='0' AND rownum <= ". self::SEARCH_RESULT_LIMIT . " UNION SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES,
        EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM " .self::FULLVIEW_TBL . " where  {$constraint} AND RESTRICTED='1' and CREATED_BY='{$userid}'  AND rownum <= ". self::SEARCH_RESULT_LIMIT . " ORDER BY 5,1 " ;
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $name
     * @return resource
     */
    static function selectExperimentByName($db_conn, $name)
    {
        $query = "SELECT  * FROM EXPERIMENT  WHERE EXP_NAME='{$name}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     */
    static function selectUnrestrictedExperimentListFromMaster($db_conn)
    {
        $query = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0' order by EXP_NAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    static function selectRestrictedExperimentListFromMaster($db_conn, $userid)
    {
        $query = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0' and CREATED_BY='{$userid}' order by EXP_NAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $name
     */
    static function selectExperimentDescription($db_conn, $name)
    {
        $query = "SELECT EXP_MASTER.* FROM EXP_MASTER WHERE EXP_MASTER.EXP_NAME = '{$name}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     */
    static function selectVersionList($db_conn)
    {
        $query = "select distinct VERSION from REFERENCE_MAIN order by VERSION";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     */
    static function selectTitleList($db_conn) {
        $query = "select distinct title from client";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $version
     */
    static function selectFromReferenceByVersion($db_conn, $version)
    {
        $query = "SELECT  * FROM REFERENCE_MAIN  WHERE VERSION='{$version}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $prob_id
     * @param $exp_name
     * @param $catg
     * @param $spec
     * @param $subj
     * @param $reg_val
     * @param $open
     * @param $userid
     * @param $date
     * @param $restricted
     * @param $hour
     */
    static function insertIntoExpTbl($db_conn, $prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $userid,
                                     $date, $restricted, $hour)
    {
        $query = "insert into EXPERIMENT VALUES('{$prob_id}','{$exp_name}','{$catg}' ,'{$spec}','{$subj}','{$reg_val}','{$open}','{$userid}', '{$date}','{$restricted}','{$hour}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $name
     * @param $description
     * @param $userid
     * @param $date
     * @param $restricted
     * @param $recNum
     */
    static function insertIntoExpMasterTbl($db_conn, $name, $description, $userid, $date, $restricted, $recNum)
    {
        $query = "insert into EXP_MASTER VALUES('$name', '$description', '$userid', '$date', '$restricted', $recNum)";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $probeid
     * @param $cgname
     * @param $genename
     * @param $flybasenum
     * @param $version
     * @param $userid
     * @param $date
     */
    static function insertReference($db_conn, $probeid, $cgname, $genename, $flybasenum, $version, $userid, $date)
    {
        $query = "insert into REFERENCE_MAIN VALUES('{$probeid}', '{$cgname}', '{$genename}' ,'{$flybasenum}', '{$version}', '{$userid}', '{$date}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $probeid
     * @param $gonumber
     * @param $version
     * @param $userid
     * @param $date
     */
    static function insertReferenceGo($db_conn, $probeid, $gonumber, $version, $userid, $date)
    {
        $query = "insert into REFERENCE_GO VALUES('{$probeid}', '{$gonumber}', '{$version}', '{$userid}', '{$date}')";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

    /**
     * @param $db_conn
     * @param $gonumber
     * @param $biofunction
     * @param $version
     * @param $userid
     * @param $date
     */
    static function insertReferenceBio($db_conn, $gonumber, $biofunction, $version, $userid, $date)
    {
        $query = "insert into REFERENCE_BIO VALUES('{$gonumber}', '{$biofunction}', '{$version}', '{$userid}', '{$date}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $name
     */
    static function deleteFromExpTblAfterFailedInsertion($db_conn, $name)
    {
        $query = "delete from EXPERIMENT where EXP_NAME='$name'";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

    /**
     * @param $db_conn
     * @param $name
     */
    static function deleteFromExpMasterTblAfterFailedInsertion($db_conn, $name)
    {
        $query = "delete from EXP_MASTER where EXP_NAME='$name'";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

    /**
     * @param $db_conn
     * @param $version
     */
    static function deleteReferenceMainAfterFailedInsertion($db_conn, $version)
    {
        $query = "delete from REFERENCE_MAIN where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $version
     */
    static function deleteReferenceGoAfterFailedInsertion($db_conn, $version)
    {
        $query = "delete from REFERENCE_GO where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

    /**
     * @param $db_conn
     * @param $version
     */
    static function deleteReferenceBioAfterFailedInsertion($db_conn, $version)
    {
        $query = "delete from REFERENCE_BIO where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $name
     * @param $description
     */
    static function updateExperimentDescription($db_conn, $name, $description)
    {
        $query = "update EXP_MASTER set EXP_DESC='{$description}' WHERE EXP_MASTER.EXP_NAME = '{$name}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $name
     */
    static function deleteExpFromExpTbl($db_conn, $name)
    {
        $query = "delete from EXPERIMENT where EXP_NAME='{$name}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $name
     */
    static function deleteExpFromExMasterTbl($db_conn, $name)
    {
        $query = "delete from EXP_MASTER where EXP_NAME='{$name}'";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

    /**
     * @param $db_conn
     * @param $name
     */
    static function deleteExperiment($db_conn, $name)
    {
        self::deleteExpFromExpTbl($db_conn, $name);
        self::deleteExpFromExMasterTbl($db_conn, $name);
    }

    /**
     * @param $db_conn
     * @param $version
     */
    static function deleteReferenceFromMain($db_conn, $version)
    {
        $query = "delete from REFERENCE_MAIN where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $version
     */
    static function deleteReferenceFromGo($db_conn, $version)
    {
        $query = "delete from REFERENCE_GO where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $version
     */
    static function deleteReferenceFromBio($db_conn, $version)
    {
        $query = "delete from REFERENCE_BIO where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $version
     */
    static function deleteReference($db_conn, $version)
    {
        self::deleteReferenceFromMain($db_conn, $version);
        self::deleteReferenceFromGo($db_conn, $version);
        self::deleteReferenceFromBio($db_conn, $version);
    }

    /**
     * @param $db_conn
     */
    static function selectCountryList($db_conn)
    {
        $query = "select distinct country, countryid from country order by countryid";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $countryID
     */
    static function selectCountryById($db_conn, $countryID)
    {
        $query = "select country from country where countryid = {$countryID}";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     */
    static function selectNewUserList($db_conn)
    {
        $query = "select c_id,fname,lname from client where ACC_RIGHT_ID = 0 order by lname ";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     */
    static function selectExistingUserList($db_conn)
    {
        $query = "select c_id,fname,lname from client where ACC_RIGHT_ID > 0 order by lname ";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     */
    static function selectAccessRightList($db_conn)
    {
        $query = "select ACC_RIGHT_ID,ACC_RIGHT_DESC from ACCESS_RIGHT order by ACC_RIGHT_DESC ";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $userid
     */
    static function selectProfileInfoByUserID($db_conn, $userid)
    {
        $userid = strtoupper($userid);
        $query = "select title,fname,lname,mname,add_1,add_2,city,state,zip,country,phone,email,ind,prof,updated_by, updated_on from client where user_id = '{$userid}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $cid
     */
    static function selectProfileInfoByCID($db_conn, $cid)
    {
        $query = "SELECT CLIENT.*, ACCESS_RIGHT.ACC_RIGHT_DESC as RIGHT FROM CLIENT INNER JOIN ACCESS_RIGHT ON CLIENT.ACC_RIGHT_ID = ACCESS_RIGHT.ACC_RIGHT_ID WHERE CLIENT.c_id = '{$cid}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $title
     * @param $db_conn
     * @param $lname
     * @param $fname
     * @param $mname
     * @param $address1
     * @param $address2
     * @param $city
     * @param $state
     * @param $zip
     * @param $country
     * @param $phone
     * @param $email
     * @param $industry
     * @param $profession
     * @param $userid
     */
    static function updateUserProfile($db_conn, $title, $lname, $fname, $mname,
                                      $address1, $address2, $city, $state, $zip, $country,
                                      $phone, $email, $industry, $profession, $userid)
    {
        $email = strtoupper($email);
        $userid = strtoupper($userid);
        $query = "update CLIENT set TITLE='{$title}',LNAME='{$lname}',FNAME='{$fname}',MNAME='{$mname}'," .
            "ADD_1=' {$address1}',
ADD_2='{$address2}',CITY='{$city}',STATE= '{$state}',ZIP ='{$zip}',COUNTRY='{$country}'," .
            "PHONE= '{$phone}',EMAIL='{$email}',IND='{$industry}',PROF='{$profession}'," .
            "UPDATED_BY='{$userid}',UPDATED_ON=SYSDATE WHERE USER_ID='{$userid}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $title
     * @param $db_conn
     * @param $lname
     * @param $mname
     * @param $fname
     * @param $address1
     * @param $address2
     * @param $city
     * @param $state
     * @param $zip
     * @param $country
     * @param $phone
     * @param $email
     * @param $industry
     * @param $profession
     * @param $userid
     * @param $password
     * @param $date
     */
    static function insertUserProfile($db_conn, $title, $lname, $mname, $fname,
                                      $address1, $address2, $city, $state, $zip, $country,
                                      $phone, $email, $industry, $profession, $userid, $password, $date)
    {
        $query = "INSERT INTO CLIENT (C_ID,TITLE,LNAME,MNAME,FNAME,ADD_1,ADD_2,CITY,STATE,ZIP,COUNTRY," .
            "PHONE,EMAIL,IND,PROF,USER_ID,PASSWORD," .
            "DATE_APPLIED,TOTAL_LOGIN,ACC_RIGHT_ID,DEL_FLAG) " .
            "VALUES(NULL,$title,$lname, $mname, $fname, " .
            " $address1,$address2, $city, $state, $zip, $country," .
            "$phone, $email, $industry, $profession, $userid, $password,$date,0,0,0)";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $userid
     * @param $password
     */
    static function selectUserByIDAndPW($db_conn, $userid, $password)
    {
        $query = "select USER_ID from CLIENT WHERE USER_ID = '{$userid}' and PASSWORD='{$password}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $userid
     * @param $password
     */
    static function updateUserPassword($db_conn, $userid, $password)
    {
        $query = "update CLIENT set PASSWORD= '{$password}' WHERE USER_ID = '{$userid}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $modifiedID
     */
    static function selectUserIdFromModifiedUserId($db_conn, $modifiedID)
    {
        $query = "select USER_ID from CLIENT WHERE USER_ID = '{$modifiedID}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $modifiedEmail
     */
    static function selectUserIdFromModifiedEmail($db_conn, $modifiedEmail)
    {
        $query = "select USER_ID from CLIENT WHERE EMAIL='{$modifiedEmail}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $cid
     * @param $accessright
     * @param $createdby
     * @param $date
     */
    static function updateUserRight($db_conn, $cid, $accessright, $createdby, $date)
    {
        $query = "UPDATE CLIENT SET ACC_RIGHT_ID='$accessright', CREATED_BY='$createdby',created_on='$date' WHERE C_ID='$cid'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $cid
     * @param $updatedby
     * @param $date
     */
    static function deleteUser($db_conn, $cid, $updatedby, $date)
    {
        $query = "UPDATE CLIENT SET DEL_FLAG='1', UPDATED_BY=$updatedby,UPDATED_ON=$date WHERE C_ID=$cid";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     * @param $cid
     * @param $updatedby
     * @param $date
     */
    static function updateUserActivation($db_conn, $cid, $updatedby, $date)
    {
        $query = "UPDATE CLIENT SET DEL_FLAG='0', UPDATED_BY=$updatedby,UPDATED_ON=$date WHERE C_ID=$cid";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    /**
     * @param $db_conn
     */
    static function selectGeneName($db_conn)
    {
        $query = "select distinct GENENAME from " . self::FULLVIEW_TBL . " where RESTRICTED ='0' order by GENENAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }
}

class_alias('DBFunctionsAndConsts', 'dbFn');