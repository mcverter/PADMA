<?php

class DB_Entity {
    public $table_name;
    public $table_col;

    public $view_name;
    public $view_col;

    public $html_label;

    public function __construct($vn, $vc, $hl, $tn="", $tc="" ) {
        $this->table_name = $tn;
        $this->table_col = $tc;
        $this->view_name = $vn;
        $this->view_col = $vc;
        $this->html_label = $hl;
    }


    function make_text_input_widget()
    {
        $view_col = $this->view_col;
        $label = $this->html_label;
        echo <<< EOT
    <label for='{$view_col}'> {$label} </label>
    <input name='{$view_col}' type='text' />
    <br />
EOT;
    }

    function make_select_input_widget($db_conn, $userid="")
    {
        $table_col = $this->table_col;
        $table_name = $this->table_name;

        $view_col = $this->view_col;

        $label = $this->html_label;

        $query = "select distinct $table_col from $table_name where RESTRICTED ='0' ";
        if (isset($userid) && ! empty($userid)) {
            $query .= "  UNION select distinct $table_col from $table_name where RESTRICTED ='1' and CREATED_BY='$userid' order by 1";
        }


        echo "<label for='{$view_col}'> {$label} </label>";
        echo "<select name='$view_col' multiple='multiple'>\n";
        echo "\t<option value=0>ALL</option>\n";


        $stdid= ociparse($db_conn, $query);
        ociexecute($stdid);

        $idx = 1;
        while ($row = oci_fetch_assoc($stdid))
        {
            echo "\t<option value=$idx>" . $row[$table_col] . "</option>\n";
        }
        echo "</select>\n<br />";
    }

    static function delete_experiment ($db_conn, $exName) {
        $cmdstr = "delete from EXPERIMENT where EXP_NAME='{$exName}'";
        $cmdstr2 = "delete from EXP_MASTER where EXP_NAME='{$exName}'";
        $parsed = ociparse($db_conn, $cmdstr);
        ociexecute($parsed);
        $parsed = ociparse($db_conn, $cmdstr2);
        ociexecute($parsed);

    }
    static function make_countries_widget($db_conn, $country) {
        echo <<< EOT
            <label for="country">Country:</label>c
            <select name="country" style="width:92%">

EOT;
        $cmdCountry = "select country,countryid from country order by countryid";
        $parsed = ociparse($db_conn, $cmdCountry);
        ociexecute($parsed);
        $totalCountry = ocifetchstatement($parsed, $results);

        for ($i=0 ; $i < $totalCountry; $i++) {
            echo "<option value=" . $results["COUNTRYID"][$i] ;
            if ($country == $results["COUNTRY"][$i]) { echo " selected ";}
            echo  ">" . $results["COUNTRY"][$i] . "</option>";
        }
        oci_free_statement($parsed);

        echo <<< EOT

        </select>
EOT;
    }


    static function get_user_data ($db_conn, $userid) {

        //obtain this user's profile
        $cmdName = "select title,fname, lname, mname,add_1,add_2,city,state,zip,country,phone,email,ind,prof,updated_by,updated_on from client where user_id = '".$userid."'";
        $parsed = ociparse($db_conn, $cmdName);
        ociexecute($parsed);
        $result = oci_fetch_array($parsed, OCI_ASSOC+OCI_RETURN_NULLS);
        if ($result == null) {
            echo "<font color='red'>";
            echo "<b>ERROR: invalid user ID (internal logic error), please contact PADMA administrator.</b>";
            echo "</font>";
            echo "<br /><a title='logout' href='index.php'>Click Here</a> to go back to home page";
            oci_free_statement($parsed);
            exit;
        }
        return $result;
    }

    static function make_experiment_list_widget($db_conn) {
        $cmdCountry = "select EXP_NAME from EXP_MASTER where RESTRICTED ='0' order by EXP_NAME";
        $parsed = ociparse($db_conn, $cmdCountry);
        ociexecute($parsed);
        $totalCountry = ocifetchstatement($parsed, $results);
        for ($i=0;$i<$totalCountry;$i++) {
            echo "<option value=\"" . $results["EXP_NAME"][$i] . "\">" . $results["EXP_NAME"][$i] . "</option>";
        }
    }

    static function make_new_users_widget($db_conn) {
        $cmdName = "select c_id,fname,lname from client where ACC_RIGHT_ID = 0 order by lname ";
        $parsed = ociparse($db_conn, $cmdName);
        ociexecute($parsed);
        $totalName = ocifetchstatement($parsed, $results);
        echo "<select name='country' style='width:92%' size='5' onchange='showUserInfo(this.value)'>";
        for ($i=0;$i<$totalName;$i++)
        {
            echo "<option value=" . $results["C_ID"][$i] . ">" . strtoupper($results["LNAME"][$i]) .", ". strtoupper($results["FNAME"][$i]). "</option>";
        }
        echo"</select>";
    }

    static function make_existing_users_widget($db_conn) {

        $cmdName = "select c_id,fname,lname from client where ACC_RIGHT_ID > 0 order by lname ";

        $parsed = ociparse($db_conn, $cmdName);
        ociexecute($parsed);
        $totalName = ocifetchstatement($parsed, $results);
        echo "<select name='country' style='width:92%' size='8' onchange='showUserInfo(this.value)'>";
        for ($i=0;$i<$totalName;$i++)
        {
            echo "<option value=" . $results["C_ID"][$i] . ">" . strtoupper($results["LNAME"][$i]) .", ". strtoupper($results["FNAME"][$i]). "</option>";
        }
        echo"</select>";
    }

    function make_access_right_widget($db_conn) {
        $cmdName = "select ACC_RIGHT_ID,ACC_RIGHT_DESC from ACCESS_RIGHT order by ACC_RIGHT_DESC ";
        $parsed = ociparse($db_conn, $cmdName);
        ociexecute($parsed);
        $totalName = ocifetchstatement($parsed, $results);
        echo "<select name='accright'>";

        for ($i=0;$i<$totalName;$i++)
        {
            echo "<option value=" . $results["ACC_RIGHT_ID"][$i] . ">" . ($results["ACC_RIGHT_DESC"][$i]). "</option>";
        }
        echo"</select>";
    }

}



$exp_name = new DB_Entity("FULL_V", "EXPERIMENTNAME", "Experiment Name",
    "EXPERIMENT", "EXP_NAME");
$category = new DB_Entity("FULL_V", "ACTIVECATEGORY", "Active Category",
    "EXPERIMENT", "CATG" );
$species = new DB_Entity ("FULL_V", "ACTIVESPECIES", "Active Species",
    "EXPERIMENT", "SPEC");
$subject = new DB_Entity ("FULL_V", "EXPERIMENTSUBJECT", "Experiment Subject",
    "EXPERIMENT", "SUBJ");
$biofunction = new DB_Entity("FULL_V", "BIOFUNCTION", "Bio Function",
    "REFERENCE_BIO", "BIOFUNCTION");
$regval = new DB_Entity("FULL_V", "REGULATIONVALUE", "Regulation Value",
    "EXPERIMENT",  "REG_VAL");

$cgnumber = new DB_Entity("FULL_V", "CGNUMBER", "CG Number");
$probeid = new DB_Entity("FULL_V", "PROBEID", "Probe Id");
$fbcgnumber = new DB_Entity("FULL_V", "FBCGNUMBER", "Flybase Number");
$genename = new DB_Entity("FULL_V", "GENENAME", "Gene Name");
$gonumber = new DB_Entity("FULL_V", "GONUMBER", "GO Number");







/*
 *
 *
 *
SQL> select owner, table_name from dba_tables where owner='DROSOPHILARC2';

OWNER			       TABLE_NAME
------------------------------ ------------------------------
DROSOPHILARC2		       ACCESS_RIGHT
DROSOPHILARC2		       CLIENT
DROSOPHILARC2		       COUNTRY
DROSOPHILARC2		       EXPERIMENT
DROSOPHILARC2		       EXP_MASTER
DROSOPHILARC2		       REFERENCE_BIO
DROSOPHILARC2		       REFERENCE_GO
DROSOPHILARC2		       REFERENCE_MAIN

8 rows selected.

SQL> Describe Access_right;
SP2-0565: Illegal identifier.
SQL> Describe Access_right;
 Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 ACC_RIGHT_ID				   NOT NULL NUMBER
 ACC_RIGHT_DESC 			   NOT NULL VARCHAR2(30)

SQL> describe client;
 Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 C_ID					   NOT NULL VARCHAR2(30)
 TITLE						    VARCHAR2(10)
 LNAME						    VARCHAR2(60)
 MNAME						    VARCHAR2(20)
 FNAME						    VARCHAR2(20)
 ADD_1						    VARCHAR2(40)
 ADD_2						    VARCHAR2(40)
 CITY						    VARCHAR2(20)
 STATE						    VARCHAR2(20)
 ZIP						    VARCHAR2(10)
 PHONE						    VARCHAR2(15)
 EMAIL						    VARCHAR2(30)
 IND						    VARCHAR2(100)
 PROF						    VARCHAR2(100)
 ACC_RIGHT_ID					    NUMBER
 DEL_FLAG					    VARCHAR2(1)
 CREATED_BY					    VARCHAR2(30)
 CREATED_ON					    DATE
 UPDATED_BY					    VARCHAR2(30)
 UPDATED_ON					    DATE
 USER_ID				   NOT NULL VARCHAR2(15)
 PASSWORD				   NOT NULL VARCHAR2(250)
 LAST_LOGIN					    DATE
 TOTAL_LOGIN				   NOT NULL NUMBER
 COUNTRY					    VARCHAR2(50)
 DATE_APPLIED					    DATE

SQL> describe country;
 Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 COUNTRYID					    NUMBER
 COUNTRY					    VARCHAR2(40)

SQL> describe experiment;
 Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 PROB_ID				   NOT NULL VARCHAR2(50)
 EXP_NAME				   NOT NULL VARCHAR2(50)
 CATG					   NOT NULL VARCHAR2(20)
 SPEC					   NOT NULL VARCHAR2(20)
 SUBJ					   NOT NULL VARCHAR2(20)
 REG_VAL					    VARCHAR2(2)
 OPEN						    VARCHAR2(20)
 CREATED_BY					    VARCHAR2(30)
 CREATED_ON				   NOT NULL VARCHAR2(15)
 RESTRICTED				   NOT NULL VARCHAR2(1)
 HOUR					   NOT NULL VARCHAR2(10)

SQL> describe  exp_master;
 Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 EXP_NAME				   NOT NULL VARCHAR2(50)
 EXP_DESC					    VARCHAR2(4000)
 CREATED_BY					    VARCHAR2(30)
 CREATED_ON				   NOT NULL VARCHAR2(15)
 RESTRICTED					    VARCHAR2(1)
 QUANTITY				   NOT NULL NUMBER

SQL> describe reference_bio;
 Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 GONUMBER				   NOT NULL VARCHAR2(15)
 BIOFUNCTION					    VARCHAR2(250)
 VERSION				   NOT NULL VARCHAR2(15)
 CREATED_BY				   NOT NULL VARCHAR2(15)
 CREATED_ON				   NOT NULL VARCHAR2(15)

SQL> describe reference_go;
 Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 PROB_ID				   NOT NULL VARCHAR2(25)
 GONUMBER				   NOT NULL VARCHAR2(15)
 VERSION				   NOT NULL VARCHAR2(15)
 CREATED_BY				   NOT NULL VARCHAR2(15)
 CREATED_ON				   NOT NULL VARCHAR2(15)

SQL> describe reference_main;
 Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 PROB_ID				   NOT NULL VARCHAR2(25)
 CGNUMBER					    VARCHAR2(25)
 GENENAME					    VARCHAR2(50)
 FBGNNUMBER					    VARCHAR2(25)
 VERSION				   NOT NULL VARCHAR2(15)
 CREATED_BY				   NOT NULL VARCHAR2(15)
 CREATED_ON				   NOT NULL VARCHAR2(15)

SQL> select owner, view_name from dba_views where owner='DROSOPHILARC2';

OWNER			       VIEW_NAME
------------------------------ ------------------------------
DROSOPHILARC2		       FULL_V

SQL> describe FULL_V;
 Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 PROBEID				   NOT NULL VARCHAR2(50)
 CGNUMBER					    VARCHAR2(25)
 GENENAME					    VARCHAR2(50)
 FBCGNUMBER					    VARCHAR2(25)
 BIOFUNCTION					    VARCHAR2(250)
 GONUMBER					    VARCHAR2(15)
 EXPERIMENTNAME 			   NOT NULL VARCHAR2(50)
 ACTIVECATEGORY 			   NOT NULL VARCHAR2(20)
 ACTIVESPECIES				   NOT NULL VARCHAR2(20)
 EXPERIMENTSUBJECT			   NOT NULL VARCHAR2(20)
 REGULATIONVALUE				    VARCHAR2(2)
 ADDITIONALINFO 				    VARCHAR2(20)
 RESTRICTED				   NOT NULL VARCHAR2(1)
 CREATED_BY					    VARCHAR2(30)
 HOUR					   NOT NULL VARCHAR2(10)


*/



