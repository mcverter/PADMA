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
        echo <<< EOT
    <input name='$view_col' type='text' />
EOT;
    }

    function make_select_input_widget($db_conn, $userid="")
    {
        $table_col = $this->table_col;
        $table_name = $this->table_name;

        $view_col = $this->view_col;

        $query = "select distinct $table_col from $table_name where RESTRICTED ='0' ";
        if (isset($userid) && ! empty($userid)) {
            $query .= "  UNION select distinct $table_col from $table_name where RESTRICTED ='1' and CREATED_BY='$userid' order by 1";
        }


        echo "<select name='$view_col' multiple='multiple'>\n";
        echo "\t<option value=0>ALL</option>\n";


        $stdid= ociparse($db_conn, $query);
        ociexecute($stdid);

        $idx = 1;
        while ($row = oci_fetch_assoc($stdid))
        {
            echo "\t<option value=$idx>" . $row[$table_col] . "</option>\n";
        }
        echo "</select>";
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



