<?php

/**
 * Class WidgetMaker
 */
class WidgetMaker
{

    // GENERAL PURPOSE WIDGETS

    static function hidden_input($name, $value) {
        $returnString = "\n<input type='hidden' name='$name' value='$value' />\n";
        return $returnString;
    }
    static function navigation_button() {

    }

    /**
     * @param string $name
     * @param string $value
     * @param string $class
     * @param string $onclick
     * @return string
     */
    static function submit_button($name='', $value='Submit', $class='', $onclick='') {
        $returnString = "\n<input type='submit' name='$name' value='$value' class='$class'
onclick='$onclick' />\n";
        return $returnString;
    }


    /**
     * @param string $name
     * @param string $value
     * @param string $class
     * @param string $onclick
     * @return string
     */
    static function general_button($name='', $value='Submit', $class='', $onclick='') {
        $returnString = "\n<input type='button' name='$name' value='$value' class='$class'
onclick='$onclick' />\n";
        return $returnString;
    }

static function text_area($label, $widget_name, $default_text='', $class='')  {
    $returnString = <<< EOT
        <br>
      <label for='$widget_name'> $label </label>
      <textarea name='$widget_name'class='$class'  />
         $default_text
      </textarea>
     <br>
EOT;

}

    /**
     * @param $label
     * @param $widget_name
     * @param string $default_text
     * @param string $class
     * @return string
     */
    static function text_input($label, $widget_name, $default_text='', $class='') {
        $returnString = <<< EOT
    <br>
      <label for='$widget_name'> $label </label>
      <input name='$widget_name' type='text' class='$class' value='$default_text' />
     <br>
EOT;
        return $returnString;
    }

    /**
     * @param $action
     * @param string $class
     * @param string $onsubmit
     * @return string
     */
    static function start_form ($action, $method='POST', $class='', $onsubmit='') {
        $returnString = "\n<form action='$action' method='$method' ";
        if (! empty($class)) {
            $returnString .= " class='$class' ";
        }
        if (! empty($onsubmit)) {
            $returnString .= " onsubmit='$onsubmit' ";
        }
        $returnString .= " >";
        return $returnString;
    }

    /**
     * @return string
     */
    static function end_form() {
        $returnString = "\n</form>\n";
        return $returnString;
    }

    /**
     * @param $label
     * @param $widget_name
     * @param string $class
     * @return string
     */
    static function file_input($label, $widget_name, $class='') {
        $returnString = <<< EOT
    <br>
      <label for='$widget_name'> $label </label>
      <input name='$widget_name' type='file' class='$class' />
     <br>
EOT;
        return $returnString;
    }

    /**
     * @param $label
     * @param $widget_name
     * @param $db_statement
     * @param $db_array_key
     * @param bool $multiple
     * @param string $already_selected
     * @param string $class
     * @return string
     */
    static function select_input($label, $widget_name,
                                $db_statement, $db_array_key,
                                $multiple=true,
                                $already_selected = '',
                                $class='') {
        $returnString = "<br>\n";
        $returnString .= "<label for='{$widget_name}'> $label </label>";
        $returnString .= "<select name='{$widget_name}' class='$class' ";
        if ($multiple) {
            $returnString .= " multiple ";
        }
        $returnString .= " /> \n";

        while (($row = oci_fetch_array($db_statement)) != false) {
            $rowval = $row[$db_array_key];
            $returnString .= "<option value='$rowval' ";
            if ($rowval === $already_selected) {
                $returnString .= " selected ";
            }
            $returnString .= "> $rowval </option>\n";
        }
        $returnString .= "</select>\n";
        $returnString .= "<br>\n";
        return $returnString;
    }


    /**
     * @param $href
     * @param $button_text
     * @return string
     */
    static function button_link($href, $button_text)
    {
        $returnString = <<< EOT
    <div class="control">
      <a href="{$href}">
	    <input type='button' value='{$button_text}'/>
       </a>
    </div>
EOT;
        return $returnString;
    }



    // SPECIAL USE

    static function quicksearch_widget() {

    }

}