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


} 