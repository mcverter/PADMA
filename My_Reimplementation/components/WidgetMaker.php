<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/29/14
 * Time: 8:47 AM
 */

class WidgetMaker
{

    // GENERAL PURPOSE WIDGETS

    static function submit_button($name='', $value='Submit', $class='', $onclick='') {
        echo "\n<input type='submit' name='$name' value='$value' class='$class'
onclick='$onclick' />\n";
    }


    static function general_button($name='', $value='Submit', $class='', $onclick='') {
        echo "\n<input type='button' name='$name' value='$value' class='$class'
onclick='$onclick' />\n";
    }


    static function text_input($label, $widget_name, $class='') {
        echo <<< EOT
    <br>
      <label for='$widget_name'> $label </label>
      <input name='$widget_name' type='text' class='$class' />
     <br>
EOT;
    }

    static function file_input($label, $widget_name, $class='') {
        echo <<< EOT
    <br>
      <label for='$widget_name'> $label </label>
      <input name='$widget_name' type='file' class='$class' />
     <br>
EOT;
    }

    static function form_select($label, $widget_name,
                                $db_statement, $db_array_key,
                                $multiple=true,
                                $already_selected = '',
                                $class='') {
        echo "<br>\n";
        echo "<label for='$widget_name'> $label </label>";
        echo "<select name='$widget_name' class='$class' ";
        if ($multiple) {
            echo " multiple ";
        }
        echo " /> \n";

        while (($row = oci_fetch_array($db_statement)) != false) {
            $rowval = $row[$db_array_key];
            echo "<option value='$rowval' ";
            if ($rowval === $already_selected) {
                echo " selected ";
            }
            echo "> $rowval </option>\n";
        }
        echo "</select>\n";
        echo "<br>\n";
    }


    static function button_link($href, $button_text)
    {
        echo <<< EOT
    <div class="control">
      <a href="{$href}">
	    <input type='button' value='{$button_text}'/>
       </a>
    </div>
EOT;
    }



    // SPECIAL USE
    static function quicksearch_widget() {

    }

}