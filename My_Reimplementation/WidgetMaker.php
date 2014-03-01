<?php

function make_search_panel() {
  $string = <<<HERE
    <div id='search_panel'> 
       %s
       %s
       %s
    </div>
HERE;

  printf($string, 
	 make_quick_search_button(),
	 make_advanced_query_button(),
	 make_refined_search_button());

  }

function make_quick_search_button() {
  echo <<< EOT
    <input id='QuickSearch'  type='button' value='Quick Gene Search' class="search_button" onclick="submit_form(this.id)"><br>
EOT;
}

function make_advanced_query_button() {
  echo <<< EOT
    <input id='AdvancedQuery'  type='button' value='Advanced Query' class="search_button" onclick="submit_form(this.id)"><br>
EOT;
}

function make_refined_search_button(){
  echo <<< EOT
    <input id='RefineSearch'    type='button' value='Refined Search' class='search_button' onclick="submit_form(this.id)">
EOT;
}

function make_experiment_list_panel() {
    $string = <<<HERE
    <div id='experiment_panel'> 
       %s
    </div>
HERE;
  printf($string, 
	 experiment_list_button());
}


function make_experiment_list_button() {
  echo <<< EOT
    <input id='ListOfExperiment'    type='button' value='Experiment List' class='search_button' onclick="submit_form(this.id)">
EOT;
}





function make_update_profile_btn () {
  echo <<< EOT
  <form  action='newprofile.php' method='post' name='profilemanagement'>
	    <input id='btnLogin' type='submit' value='Your Profile Update' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>;
	  </form>
EOT;
}






/*************************
*
*
*************************/

function make_user_mgmt_button() {
  echo <<< EOT
    <form  action='usermanagement.php' method='post' name='usermanagement'>
    <input id='btnLogin' type='submit' value='User Setup' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
    </form>
EOT;
}

function make_data_mgmt_button() {
  echo <<< EOT

    <form  action='DataManagement.php' method='post' name='index'>
	    <input id='DataManagement' type='submit' value='Data Management' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>

EOT;
}



?>