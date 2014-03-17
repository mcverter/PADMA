<?php

class WidgetMaker {


  static function make_load_reference_button() {
    self::make_control_button("load_reference.php", " Load Reference ");
  }

  static function make_delete_reference_button() {
    self::make_control_button("delete_reference.php", " Delete Reference ");
  }


  static function make_load_experiment_button() {
    self::make_control_button("experiment_loader_start.php", " Load Reference ");
  }

  static function make_delete_experiment_button() {
    self::make_control_button("delete_experiment.php", " Delete Reference ");
  }

  static function make_edit_experiment_button() {
    self::make_control_button("edit_experiment.php", " Delete Reference ");
  }

 
static function make_control_button ($href, $button_text) {
    echo <<< EOT
    <div class="control_button">
      <a href="{$href}">
	    <input type='button' value='{$button_text}'/>
       </a>
    </div>
EOT;

}
static function make_update_profile_btn () {
    self::make_control_button("edit_profile.php", "Edit Profile");
}


static function make_user_mgmt_button() {
    self::make_control_button("usermanagement.php", "User Setup");
}

static function make_data_mgmt_button() {
    self::make_control_button("DataManagement.php", 'Data Management');
}

static function make_quick_search_button() {
    self::make_control_button("QuickSearch.php", "Quick Search");
}

static function make_advanced_query_button() {
    self::make_control_button("advanced_search.php", "Advanced Search");
}

static function make_refined_search_button(){
    self::make_control_button("RefinedSearch.php", "Refined Search");
}


static function make_experiment_list_panel() {
    echo "<div id='experiment_panel'>";
    self::make_experiment_list_button();
    echo "</div>";
}


static function make_experiment_list_button() {
  echo <<< EOT
    <input id='ListOfExperiment'    type='button' value='Experiment List' class='search_button' onclick="submit_form(this.id)">
EOT;
}


static function make_search_panel() {

    echo "<div id='search_panel'>";
    self::make_quick_search_button();
    self::make_advanced_query_button();
    self::make_refined_search_button();
    echo "</div>";

}



static function make_upload_experiment_widget() {
    echo <<< EOT
    <form  action='uploadagreement.php' method='post' name='index'>
	<input id='btnLogin' type='submit' value='Load Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
EOT;
}
static function make_delete_experiment_widget() {
    echo <<< EOT
    <form  action='deleteExpResearcher.php' method='post' name='index'>
	<input id='btnLogin' type='submit' value='Delete Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
EOT;
}

static function make_edit_experiment_widget() {
    echo <<< EOT
    <form  action='SelectExperimentResearcher.php' method='post' name='index'>
	<input id='btnLogin' type='submit' value='Enter/Edit Experiment Detail' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
EOT;

}
static function make_upload_reference_data_widget() {
    echo <<< EOT

    <form  action='loaderStart.php' method='post' name='usermanagement'>
	<input id='btnLogin' type='submit' value='Load Reference Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
EOT;
    }

static function make_delete_reference_data_widget() {
    echo <<< EOT

	<form  action='deleteRefAdministrator.php' method='post' name='index'>
	<input id='btnLogin' type='submit' value='Delete Reference Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
EOT;
}

  }






?>