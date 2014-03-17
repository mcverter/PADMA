<?php

class ButtonMaker {

    static function button_link ($href, $button_text) {
        echo <<< EOT
    <div class="control">
      <a href="{$href}">
	    <input type='button' value='{$button_text}'/>
       </a>
    </div>
EOT;

    }


    static function button_load_reference() {
        self::button_link("load_reference.php", " Load Reference ");
    }

    static function button_delete_reference() {
        self::button_link("delete_reference.php", " Delete Reference ");
    }


    static function button_load_experiment() {
        self::button_link("experiment_loader_start.php", " Load Reference ");
    }

    static function button_delete_experiment() {
        self::button_link("delete_experiment.php", " Delete Reference ");
    }

    static function button_edit_experiment() {
        self::button_link("edit_experiment.php", " Delete Reference ");
    }

    static function button_update_profile () {
        self::button_control("edit_profile.php", "Edit Profile");
    }


    static function button_user_mgmt() {
        self::button_control("usermanagement.php", "User Setup");
    }

    static function button_data_mgmt() {
        self::button_control("DataManagement.php", 'Data Management');
    }

    static function button_quick_search() {
        self::button_control("QuickSearch.php", "Quick Search");
    }

    static function button_advanced_query() {
        self::button_control("advanced_search.php", "Advanced Search");
    }

    static function button_refined_search(){
        self::button_control("RefinedSearch.php", "Refined Search");
    }


    static function button_experiment_list() {
        echo <<< EOT
    <input id='ListOfExperiment'    type='button' value='Experiment List' class='search' onclick="submit_form(this.id)">
EOT;
    }

} 