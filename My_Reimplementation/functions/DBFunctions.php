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
    private static function execute_NON_SELECT_query($db_conn, $query)
    {
        $parsed = ociparse($db_conn, $query);
        oci_execute($parsed);
    }

    private static function execute_SELECT_query_and_return($db_conn, $query)
    {
        $parsed = ociparse($db_conn, $query);
        oci_execute($parsed);
        return $parsed;
    }

// Multiple Categories
    static function selectAllUnrestrictedExperimentList($db_conn, $userid)
    {
        $query = "select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='0' UNION select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='1' AND CREATED_BY='{$userid}' order by 1";
        return execute_SELECT_query_and_return($db_conn, $query);
    }


    static function selectUserRestrictedExperimentList($db_conn, $userid)
    {
        $query = "select distinct EXP_NAME from EXPERIMENT where RESTRICTED ='1' AND CREATED_BY='" . $userid . "' order by EXP_NAME";
        return execute_SELECT_query_and_return($db_conn, $query);
    }

// Search Functions
    static function selectBiofunctionList($db_conn)
    {
        $query = "select distinct biofunction as BIOFUNCTION from REFERENCE_BIO order by biofunction";
        return execute_SELECT_query_and_return($db_conn, $query);
    }

    static function selectCategoryList($db_conn, $userid)
    {
        $query = "select distinct CATG from EXPERIMENT where RESTRICTED ='0'	UNION select distinct CATG from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='{$userid}' order by 1";
        return execute_SELECT_query_and_return($db_conn, $query);
    }

    static function selectSpeciesList($db_conn, $userid)
    {
        $query = "select distinct SPEC from EXPERIMENT where RESTRICTED ='0'	UNION select distinct SPEC from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='{$userid}' order by 1";
        return execute_SELECT_query_and_return($db_conn, $query);
    }

    static function selectSubjectList($db_conn, $userid)
    {
        $query = "select distinct SUBJ from EXPERIMENT where RESTRICTED ='0'	UNION select distinct SUBJ from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='{$userid}' order by 1";
        return execute_SELECT_query_and_return($db_conn, $query);
    }

    static function selectRegValList($db_conn, $userid)
    {
        $query = "select distinct REG_VAL from EXPERIMENT where RESTRICTED ='0'	UNION select distinct REG_VAL from EXPERIMENT where RESTRICTED ='1' AND	CREATED_BY='{$userid}' order by 1";
        return execute_SELECT_query_and_return($db_conn, $query);
    }
    /*
    static function SELECTAdvancedQueryResult() {
        $query = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  where RESTRICTED='" .$notRestricted}' union SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  where RESTRICTED='" .$restricted}' and CREATED_BY='{$userid}' ORDER BY 5,1";
        // $cmdstrRetrieve = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW where "  . $str . " AND RESTRICTED='" .$notRestricted}' UNION SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT,GONUMBER, BIOFUNCTION,REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW where "  . $str . " AND RESTRICTED='" .$restricted}' and CREATED_BY='{$userid}' ORDER BY 5,1";
    }
    
    function SELECTQuickSearchResultList() {
        $cmdstrRetrieve = "SELECT DISTINCT PROBEID, CGNUMBER, GENENAME, FBCGNUMBER,EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  WHERE RESTRICTED='" .$notRestricted}' and $searchCriteria IN ($newSearchToken)";
        QuickSearchResult.php:	$cmdstrRetrieve2="SELECT DISTINCT PROBEID, CGNUMBER, GENENAME, FBCGNUMBER,EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  WHERE RESTRICTED='" .$restricted}' and CREATED_BY='{$userid}' and $searchCriteria IN ($newSearchToken)";
    }
    
    function SELECTRefineSearchResultList() {
        $cmdstrRetrieve = "SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  WHERE RESTRICTED='" .$notRestricted}' $str union SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  WHERE RESTRICTED='" .$restricted}' and CREATED_BY='{$userid}' $str order by 5,1";
    }
    
    function SELECTRefineSearchResultRefinedList() {
        $cmdstrRetrieve ="SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  WHERE RESTRICTED='" .$notRestricted}' $str union SELECT  PROBEID, CGNUMBER, GENENAME, FBCGNUMBER, EXPERIMENTNAME, ACTIVECATEGORY, ACTIVESPECIES, EXPERIMENTSUBJECT, GONUMBER, BIOFUNCTION, REGULATIONVALUE,ADDITIONALINFO,HOUR FROM FULL_VIEW  WHERE RESTRICTED='" .$restricted}' and CREATED_BY='{$userid}' $str order by 5,1";
    }
    */
    /*
     *  Data Management
     */
//Check if the experimrnt exist into the database
// expUploader.php:
    static function selectExperimentByName($name)
    {
        $query = "SELECT  * FROM EXPERIMENT  WHERE EXP_NAME='{$name}'";
    }


//SelectExperiment.php:
    static function selectUnrestrictedExperimentListFromMaster()
    {
        $query = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0' order by EXP_NAME";
    }

//SelectExperimentResearcher.php:
    static function selectRestrictedExperimentListFromMaster($db_conn, $userid)
    {
        $query = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0' and CREATED_BY='{$userid}' order by EXP_NAME";
    }

// EditDescription.php
    static function selectExperimentDescription($name)
    {
        $query = "SELECT EXP_MASTER.* FROM EXP_MASTER WHERE EXP_MASTER.EXP_NAME = '{$name}'";
    }

    static function selectVersionList()
    {
//    deleteRefAdministrator.php:
        $query = "select distinct VERSION from REFERENCE_MAIN order by VERSION";

    }

//    uploader.php:

    static function selectFromReferenceByVersion($version)
    {
        $query = "SELECT  * FROM REFERENCE_MAIN  WHERE VERSION='{$version}'";

    }

    static function okay_to_insert_into_master()
    {

    }

    static function experimentInDB($name)
    {

    }

//insertExperiment.php:
    static function insertIntoExpTbl($prob_id, $exp_name, $catg, $spec, $subj, $reg_val, $open, $userid, $date, $restricted, $hour)
    {
        $query = "insert into EXPERIMENT VALUES('{$prob_id}','{$exp_name}','{$catg}' ,'{$spec}','{$subj}','{$reg_val}','{$open}','{$userid}', '{$date}','{$restricted}','{$hour}')";
        exec_insert_query($query);
    }

    static function insertIntoExpMasterTbl($name, $description, $userid, $date, $restricted, $recNum)
    {
        $query = "insert into EXP_MASTER VALUES($name, $description, $userid, $date, $restricted, $recNum)";
        exec_insert_query($query);
    }


    static function insertReference($probeid, $cgname, $genename, $flybasenum, $version, $userid, $date)
    {
        // insertReference.php:
        $query = "insert into REFERENCE_MAIN VALUES('{$probeid}', '{$cgname}', '{$genename}' ,'{$flybasenum}', '{$version}', '{$userid}', '{$date}')";
        exec_insert_query($query);
    }

    static function insertReferenceGo($probeid, $gonumber, $version, $userid, $date)
    {
        $query = "insert into REFERENCE_GO VALUES('{$probeid}', '{$gonumber}', '{$version}', '{$userid}', '{$date}')";
        exec_insert_query($query);

    }

    static function insertReferenceBio($gonumber, $biofunction, $version, $userid, $date)
    {
        $query = "insert into REFERENCE_BIO VALUES('{$gonumber}', '{$biofunction}', '{$version}', '{$userid}', '{$date}')";
        exec_insert_query($query);
    }

//insertExperiment.php:
    static function DELETEFromExpTblAfterFailedInsertion($name)
    {
        $strDel = "delete from EXPERIMENT where EXP_NAME='$name'";
    }

// insertExperiment.php:
    static function DELETEFromExpMasterTblAfterFailedInsertion($name)
    {
        $strDel = "delete from EXP_MASTER where EXP_NAME='$name'";
    }

    static function DELETEReferenceMainAfterFailedInsertion($version)
    {
        $strDel = "delete from REFERENCE_MAIN where VERSION='{$version}'";
    }

    static function DELETEReferenceGoAfterFailedInsertion($version)
    {
        $query = "delete from REFERENCE_GO where VERSION='{$version}'";
    }

    static function DELETEReferenceBioAfterFailedInsertion($version)
    {
        $query = "delete from REFERENCE_BIO where VERSION='{$version}'";
    }

    static function UPDATEExperimentDescription($name, $description)
    {
        //ConfirmEditDescription.php:
        $query = "update EXP_MASTER set EXP_DESC='{$description}' WHERE EXP_MASTER.EXP_NAME = '{$name}'";
    }

// deleteExpAdministrator . php:$
    static function DELETEExpFromExpTbl($name)
    {
        $query = "delete from EXPERIMENT where EXP_NAME='{$name}'";
    }

//deleteExpAdministrator.php:
    static function DELETEExpFromExMasterTbl($name)
    {
        $cmdstr2 = "delete from EXP_MASTER where EXP_NAME='{$name}'";
    }

    static function DELETEExperiment($name)
    {
        deleteExpFromExpTbl($name);
        deleteExpFromExMasterTbl($name);
    }

//deleteRefAdministrator.php:
    static function DELETEReferenceFromMain($version)
    {
        $cmdstr = "delete from REFERENCE_MAIN where VERSION='{$version}'";
    }

//deleteRefAdministrator.php:
    static function DELETEReferenceFromGo($version)
    {
        $query = "delete from REFERENCE_GO where VERSION='{$version}'";
    }

    static function DELETEReferenceFromBio($version)
    {
        $query = "delete from REFERENCE_BIO where VERSION='{$version}'";
    }

    static function DELETEReference($version)
    {
        deleteReferenceFromMain($version);
        deleteReferenceFromGo($version);
        deleteReferenceFromBio($version);
    }


// User
    static function SELECTCountryList()
    {
        $query = "select country,countryid from country order by countryid";
    }

// newprofileSubmit.php:
    static function SELECTCountryById($countryID)
    {
        $query = "select country from country where countryid = {$countryID}";
    }

//get user information from database
//usermanagement.php:
    static function SELECTNewUserList()
    {
        $query = "select c_id,fname,lname from client where ACC_RIGHT_ID = 0 order by lname ";
    }

    static function SELECTExistingUserList()
    {
        $query = "select c_id,fname,lname from client where ACC_RIGHT_ID > 0 order by lname ";

    }

//    usermanagement.php:
    static function SELECTAccessRightList()
    {
        $query = "select ACC_RIGHT_ID,ACC_RIGHT_DESC from ACCESS_RIGHT order by ACC_RIGHT_DESC ";
    }

// getUserInfo.php
    static function SELECTUserInfo($clientid)
    {
        $query = "SELECT CLIENT.*, ACCESS_RIGHT.ACC_RIGHT_DESC as RIGHT FROM CLIENT INNER JOIN ACCESS_RIGHT ON CLIENT.ACC_RIGHT_ID = ACCESS_RIGHT.ACC_RIGHT_ID WHERE CLIENT.c_id = '{$clientid}'";
    }

//newprofile.php
    static function SELECTProfileInfo($db_conn, $userid)
    {
        $query = "select title,fname,lname,mname,add_1,add_2,city,state,zip,country,phone,email,ind,prof,updated_by,updated_on from client where user_id = '{$userid}'";

    }

// newprofileSubmit.php
    static function UPDATEUserProfile($title, $lname, $fname, $mname,
                               $address1, $address2, $city, $state, $zip, $country,
                               $phone, $email, $industry, $profession, $userid)
    {
        $country = $country["COUNTRY"][0];
        $email = strtoupper($email);
//update user profile
        $query = "update CLIENT set TITLE='{$title}',LNAME='{$lname}',FNAME='{$fname}',MNAME='{$mname}'," .
            "ADD_1='{$address1}',ADD_2='{$address2}',CITY='{$city}',STATE= '{$state}',ZIP ='{$zip}',COUNTRY='{$country}'," .
            "PHONE= '{$phone}',EMAIL='{$email}',IND='{$industry}',PROF='{$profession}'," .
            "UPDATED_BY='{$userid}',UPDATED_ON=SYSDATE WHERE USER_ID='{ $userid }'";
    }


    static function INSERTUserProfile($title, $lname, $mname, $fname,
                               $address1, $address2, $city, $state, $zip, $country,
                               $phone, $email, $industry, $profession, $userid, $password, $date)
    {
        $query = "INSERT INTO CLIENT (C_ID,TITLE,LNAME,MNAME,FNAME,ADD_1,ADD_2,CITY,STATE,ZIP,COUNTRY," .
            "PHONE,EMAIL,IND,PROF,USER_ID,PASSWORD," .
            "DATE_APPLIED,TOTAL_LOGIN,ACC_RIGHT_ID,DEL_FLAG) " .
            "VALUES(NULL,$title,$lname, $mname, $fname, " .
            " $address1,$address2, $city, $state, $zip, $country," .
            "$phone, $email, $industry, $profession, $userid, $password,$date,0,0,0)";
    }

    static function SELECTUserByIDAndPW($db_conn, $userid, $password)
    {
        $cmdstr = "select USER_ID from CLIENT WHERE USER_ID = '{$userid}' and PASSWORD='{$password}'";
    }

    static function UPDATE_password($db_conn, $userid, $password)
    {
        $query = "update CLIENT set PASSWORD= '{$password}' WHERE USER_ID = '{$userid}'";
    }

//newuserSubmit.php:
// to see if user already exists
    static function SELECTUserIdFromModifiedUserId($modifiedID)
    {
        $cmdstr = "select USER_ID from CLIENT WHERE USER_ID = '{$modifiedID}'";
    }

//newuserSubmit.php:
    static function SELECTUserIdFromModifiedEmail($modifiedEmail)
    {
        $cmdstr = "select USER_ID from CLIENT WHERE EMAIL='{$modifiedEmail}'";
    }

    static function UPDATEUserRight($cid, $accessright, $createdby, $date)
    {
        $query = "UPDATE CLIENT SET ACC_RIGHT_ID='$accessright', CREATED_BY='$createdby',created_on='$date' WHERE C_ID='$cid'";
    }

    static function DELETEUser($cid, $updatedby, $date)
    {
        $query = "UPDATE CLIENT SET DEL_FLAG='1', UPDATED_BY=$updatedby,UPDATED_ON=$date WHERE C_ID=$cid";
    }

    static function UPDATEUserActivation($cid, $updatedby, $date)
    {
        $query = "UPDATE CLIENT SET DEL_FLAG='0', UPDATED_BY=$updatedby,UPDATED_ON=$date WHERE C_ID=$cid";

    }

    static function SELECTGeneName()
    {
        $query = "select distinct GENENAME from FULL_VIEW where RESTRICTED ='0' order by GENENAME";

    }

}