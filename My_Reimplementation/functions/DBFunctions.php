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
class DBFunctions
{

    const FULLVIEW_TABLE = 'FULL_V';





    static function connect_to_db()
    {
        $db_UN = "drosophilarc2";
        $db_PASS = "drosopivot";
        $db_DB = "//127.0.0.1/ORATIKI";

        set_time_limit(6000);
        $db_conn = ocilogon($db_UN, $db_PASS, $db_DB);
        if (!$db_conn) {
            self::db_conn_failure(oci_error());
        }
        return $db_conn;
    }

    static function db_conn_failure($err)
    {
        $error_message = htmlentities($err['message']);
        echo <<<EOT
      echo "<font color='red'>";
      $error_message
    <br>ERROR: Connecting to Database, Please try back later<br>;
    <a title='logout' href='index.php'>Click Here</a> to go back to home page
EOT;
        exit;

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
     * @return
     */
    private static function execute_SELECT_query_and_return($db_conn, $query)
    {
        $parsed = ociparse($db_conn, $query);
        oci_execute($parsed);
        return $parsed;
    }

// Multiple Categories
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

// Search Functions
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
GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM  " . self::FULLVIEW_TABLE . " where  {$constraint}  AND
RESTRICTED='0' UNION SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES,
        EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM " .self::FULLVIEW_TABLE . "
            where  {$constraint} AND RESTRICTED='1' and CREATED_BY='{$userid}' ORDER BY 5,1";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    /*
    function selectRefineSearchResultList($db_conn) {
        $queryRetrieve = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM " . self::FULLVIEW_TABLE . "  WHERE RESTRICTED='" .$notRestricted}' $str union SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM " . self::FULLVIEW_TABLE . "  WHERE RESTRICTED='" .$restricted}' and CREATED_BY='{$userid}' $str order by 5,1";
    }

    function selectRefineSearchResultRefinedList($db_conn) {
        $queryRetrieve ="SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM " . self::FULLVIEW_TABLE . "  WHERE RESTRICTED='" .$notRestricted}' $str union SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM " . self::FULLVIEW_TABLE . "  WHERE RESTRICTED='" .$restricted}' and CREATED_BY='{$userid}' $str order by 5,1";
    }
    */
    /*
     *  Data Management
     */
//Check if the experimrnt exist into the database
// expUploader.php:
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


//SelectExperiment.php:
    static function selectUnrestrictedExperimentListFromMaster($db_conn)
    {
        $query = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0' order by EXP_NAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

//SelectExperimentResearcher.php:
    static function selectRestrictedExperimentListFromMaster($db_conn, $userid)
    {
        $query = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0' and CREATED_BY='{$userid}' order by EXP_NAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

// EditDescription.php
    static function selectExperimentDescription($db_conn, $name)
    {
        $query = "SELECT EXP_MASTER.* FROM EXP_MASTER WHERE EXP_MASTER.EXP_NAME = '{$name}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    static function selectVersionList($db_conn)
    {
//    deleteRefAdministrator.php:
        $query = "select distinct VERSION from REFERENCE_MAIN order by VERSION";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

//    uploader.php:


    static function selectTitleList($db_conn) {
        $query = "select distinct title from client";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    static function selectFromReferenceByVersion($db_conn, $version)
    {
        $query = "SELECT  * FROM REFERENCE_MAIN  WHERE VERSION='{$version}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    static function okay_to_insert_into_master($db_conn)
    {

    }

    static function experimentInDB($db_conn, $name)
    {

    }

//insertExperiment.php:
    static function insertIntoExpTbl($db_conn, $prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $userid,
                                     $date, $restricted, $hour)
    {
        $query = "insert into EXPERIMENT VALUES('{$prob_id}','{$exp_name}','{$catg}' ,'{$spec}','{$subj}','{$reg_val}','{$open}','{$userid}', '{$date}','{$restricted}','{$hour}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    static function insertIntoExpMasterTbl($db_conn, $name, $description, $userid, $date, $restricted, $recNum)
    {
        $query = "insert into EXP_MASTER VALUES($name, $description, $userid, $date, $restricted, $recNum)";
        self::execute_NON_SELECT_query($db_conn, $query);
    }


    static function insertReference($db_conn, $probeid, $cgname, $genename, $flybasenum, $version, $userid, $date)
    {
        // insertReference.php:
        $query = "insert into REFERENCE_MAIN VALUES('{$probeid}', '{$cgname}', '{$genename}' ,'{$flybasenum}', '{$version}', '{$userid}', '{$date}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    static function insertReferenceGo($db_conn, $probeid, $gonumber, $version, $userid, $date)
    {
        $query = "insert into REFERENCE_GO VALUES('{$probeid}', '{$gonumber}', '{$version}', '{$userid}', '{$date}')";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

    static function insertReferenceBio($db_conn, $gonumber, $biofunction, $version, $userid, $date)
    {
        $query = "insert into REFERENCE_BIO VALUES('{$gonumber}', '{$biofunction}', '{$version}', '{$userid}', '{$date}')";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

//insertExperiment.php:
    static function deleteFromExpTblAfterFailedInsertion($db_conn, $name)
    {
        $query = "delete from EXPERIMENT where EXP_NAME='$name'";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

// insertExperiment.php:
    static function deleteFromExpMasterTblAfterFailedInsertion($db_conn, $name)
    {
        $query = "delete from EXP_MASTER where EXP_NAME='$name'";
        self::execute_NON_SELECT_query($db_conn, $query);

    }
//$cmdName = "select title,fname,lname,mname,add_1,add_2,city,state,zip,country,phone,email,ind,prof,updated_by,updated_on from client where user_id = '".$userid."'";

    static function deleteReferenceMainAfterFailedInsertion($db_conn, $version)
    {
        $query = "delete from REFERENCE_MAIN where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    static function deleteReferenceGoAfterFailedInsertion($db_conn, $version)
    {
        $query = "delete from REFERENCE_GO where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

    static function deleteReferenceBioAfterFailedInsertion($db_conn, $version)
    {
        $query = "delete from REFERENCE_BIO where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    static function updateExperimentDescription($db_conn, $name, $description)
    {
        //ConfirmEditDescription.php:
        $query = "update EXP_MASTER set EXP_DESC='{$description}' WHERE EXP_MASTER.EXP_NAME = '{$name}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

// deleteExpAdministrator . php:$
    static function deleteExpFromExpTbl($db_conn, $name)
    {
        $query = "delete from EXPERIMENT where EXP_NAME='{$name}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

//deleteExpAdministrator.php:
    static function deleteExpFromExMasterTbl($db_conn, $name)
    {
        $query = "delete from EXP_MASTER where EXP_NAME='{$name}'";
        self::execute_NON_SELECT_query($db_conn, $query);

    }

    static function deleteExperiment($db_conn, $name)
    {
        self::deleteExpFromExpTbl($db_conn, $name);
        self::deleteExpFromExMasterTbl($db_conn, $name);
    }

//deleteRefAdministrator.php:
    static function deleteReferenceFromMain($db_conn, $version)
    {
        $query = "delete from REFERENCE_MAIN where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

//deleteRefAdministrator.php:
    static function deleteReferenceFromGo($db_conn, $version)
    {
        $query = "delete from REFERENCE_GO where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    static function deleteReferenceFromBio($db_conn, $version)
    {
        $query = "delete from REFERENCE_BIO where VERSION='{$version}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    static function deleteReference($db_conn, $version)
    {
        self::deleteReferenceFromMain($db_conn, $version);
        self::deleteReferenceFromGo($db_conn, $version);
        self::deleteReferenceFromBio($db_conn, $version);
    }


// User
    static function selectCountryList($db_conn)
    {
        $query = "select distinct country, countryid from country order by countryid";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

// newprofileSubmit.php:
    static function selectCountryById($db_conn, $countryID)
    {
        $query = "select country from country where countryid = {$countryID}";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

//get user information from database
//usermanagement.php:
    static function selectNewUserList($db_conn)
    {
        $query = "select c_id,fname,lname from client where ACC_RIGHT_ID = 0 order by lname ";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    static function selectExistingUserList($db_conn)
    {
        $query = "select c_id,fname,lname from client where ACC_RIGHT_ID > 0 order by lname ";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

//    usermanagement.php:
    static function selectAccessRightList($db_conn)
    {
        $query = "select ACC_RIGHT_ID,ACC_RIGHT_DESC from ACCESS_RIGHT order by ACC_RIGHT_DESC ";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

/* getUserInfo.php
    static function selectUserInfo($db_conn, $clientid)
    {
        $query = "SELECT CLIENT.*, ACCESS_RIGHT.ACC_RIGHT_DESC as RIGHT FROM CLIENT INNER JOIN ACCESS_RIGHT ON CLIENT.ACC_RIGHT_ID = ACCESS_RIGHT.ACC_RIGHT_ID WHERE CLIENT.c_id = '{$clientid}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }
*/
//newprofile.php
    static function selectProfileInfoByUserID($db_conn, $userid)
    {
        $userid = strtoupper($userid);
        $query = "select title,fname,lname,mname,add_1,add_2,city,state,zip,country,phone,email,ind,prof,updated_by, updated_on from client where user_id = '{$userid}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    static function selectProfileInfoByCID($db_conn, $cid)
    {
        $query = "SELECT CLIENT.*, ACCESS_RIGHT.ACC_RIGHT_DESC as RIGHT FROM CLIENT INNER JOIN ACCESS_RIGHT ON CLIENT.ACC_RIGHT_ID = ACCESS_RIGHT.ACC_RIGHT_ID WHERE CLIENT.c_id = '{$cid}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }


// newprofileSubmit.php
    static function updateUserProfile($db_conn, $title, $lname, $fname, $mname,
                                      $address1, $address2, $city, $state, $zip, $country,
                                      $phone, $email, $industry, $profession, $userid)
    {
        $email = strtoupper($email);
        $userid = strtoupper($userid);
//update user profile
        $query = "update CLIENT set TITLE='{$title}',LNAME='{$lname}',FNAME='{$fname}',MNAME='{$mname}'," .
            "ADD_1=' {$address1}',
ADD_2='{$address2}',CITY='{$city}',STATE= '{$state}',ZIP ='{$zip}',COUNTRY='{$country}'," .
            "PHONE= '{$phone}',EMAIL='{$email}',IND='{$industry}',PROF='{$profession}'," .
            "UPDATED_BY='{$userid}',UPDATED_ON=SYSDATE WHERE USER_ID='{ $userid }'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

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

    static function selectUserByIDAndPW($db_conn, $userid, $password)
    {
        $query = "select USER_ID from CLIENT WHERE USER_ID = '{$userid}' and PASSWORD='{$password}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    static function updateUserPassword($db_conn, $userid, $password)
    {
        $query = "update CLIENT set PASSWORD= '{$password}' WHERE USER_ID = '{$userid}'";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

//newuserSubmit.php:
// to see if user already exists
    static function selectUserIdFromModifiedUserId($db_conn, $modifiedID)
    {
        $query = "select USER_ID from CLIENT WHERE USER_ID = '{$modifiedID}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

//newuserSubmit.php:
    static function selectUserIdFromModifiedEmail($db_conn, $modifiedEmail)
    {
        $query = "select USER_ID from CLIENT WHERE EMAIL='{$modifiedEmail}'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    static function updateUserRight($db_conn, $cid, $accessright, $createdby, $date)
    {
        $query = "UPDATE CLIENT SET ACC_RIGHT_ID='$accessright', CREATED_BY='$createdby',created_on='$date' WHERE C_ID='$cid'";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

    static function deleteUser($db_conn, $cid, $updatedby, $date)
    {
        $query = "UPDATE CLIENT SET DEL_FLAG='1', UPDATED_BY=$updatedby,UPDATED_ON=$date WHERE C_ID=$cid";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    static function updateUserActivation($db_conn, $cid, $updatedby, $date)
    {
        $query = "UPDATE CLIENT SET DEL_FLAG='0', UPDATED_BY=$updatedby,UPDATED_ON=$date WHERE C_ID=$cid";
        self::execute_NON_SELECT_query($db_conn, $query);
    }

    static function selectGeneName($db_conn)
    {
        $query = "select distinct GENENAME from " . self::FULLVIEW_TABLE . " where RESTRICTED ='0' order by GENENAME";
        return self::execute_SELECT_query_and_return($db_conn, $query);
    }

}