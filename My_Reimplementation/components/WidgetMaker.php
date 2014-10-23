<?php

/**
 * Class WidgetMaker
 */

class FormWidget {
    protected $id_name;
    protected $value;
    protected $attrs;
    protected $input_tag;

     function FormWidget($id_name, $value, $attrs, $input_tag='input') {
        $this->id_name = $id_name;
        $this->value = $value;
        $this->$attrs = $attrs;
        $this->input_tag = $input_tag;
    }

     function toString() {
        return "< $this->input_tag $this->id_name $this->value $this->attrs >" ;
    }

};

class WidgetMaker extends FormWidget
{


    // GENERAL PURPOSE WIDGETS

    static function hidden_input($name, $value) {
        $returnString = "\n<input type='hidden' name='$name' value='$value' />\n";
        return $returnString;
    }
    static function navigation_button() {

    }

static function successMessage($id, $message, $hidden='') {
    $returnString = <<< EOT
    <div id="$id" $hidden>
    <div class="alert alert-success">
        <span class="close" data-dismiss="alert">&times;</span>
        <strong>Success!</strong> $message
    </div>
    </div>
EOT;
    return $returnString;
}

    static function errorMessage ($id, $message, $hidden='hidden') {
    $returnString = <<< EOT
    <div id="$id" $hidden>
    <div class="alert alert-danger">
        <span class="close" data-dismiss="alert">&times;</span>
        <strong>Error!</strong> $message
    </div>
    </div>
EOT;
        return $returnString;

}


/**
     * @param string $name
     * @param string $value
     * @param string $class
     * @param string $onclick
     * @return string
     */
    static function submit_button($name='', $value='Submit', $class='') {
        $returnString = "\n<input type='submit' name='$name' value='$value' class='$class' />\n";
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


    static function password_input($label, $widget_name, $class='') {
        $returnString = <<< EOT
    <br>
      <label for='$widget_name'> $label </label>
      <input name='$widget_name' type='passwword' class='$class'  />
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


    static function start_file_form ($action, $method='POST', $class='', $onsubmit='') {
        $returnString = "\n<form enctype='multipart/form-data' action='$action' method='$method' ";
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
     * @param $db_array_shown_key
     * @param bool $multiple
     * @param string $already_selected
     * @param string $class
     * @return string
     */
    static function select_input($label, $widget_name,
                                $db_statement,
                                $db_value_key, $db_shown_key,
                                $multiple=true,
                                $already_selected = '',
                                $class='') {
        $returnString = "<br>\n";
        $returnString .= "<label for='{$widget_name}'> $label </label>";
        $returnString .= "<select name='{$widget_name}' id='{$widget_name}' class='$class' size=5 ";
        if ($multiple) {
            $returnString .= " multiple ";
        }
        $returnString .= " > \n";

        while (($row = oci_fetch_array($db_statement)) != false) {
            $rowval = $row[$db_value_key];
            $rowshown = $row[$db_shown_key];
            $returnString .= "<option value='$rowval' ";
            if ($rowval === $already_selected) {
                $returnString .= " selected ";
            }
            $returnString .= "> $rowshown </option>\n";
        }
        $returnString .= "</select>\n";
        $returnString .= "<br>\n";
        return $returnString;
    }


    static function button_ajax($id, $buttontext) {
        $returnString = <<< EOT
	    <input type='button' id='{$id}' value='{$buttontext}'/>
EOT;
        return $returnString;


    }




    // SPECIAL USE

    static function access_right_panel($db_conn, $ajax_button) {
        $returnString = '';
        $returnString . <<< EOT
        <div border=1px>
        <fieldset>
        <legend> Assign Access Right </legend>
EOT;

        $returnString .=
            self::select_input('Access Right', 'accessright', DBFunctions::selectAccessRightList($db_conn),
                'ACC_RIGHT_ID', 'ACC_RIGHT_DESC', false) .
            self::button_ajax($ajax_button, "Update Access Right");
        return $returnString;
    }
    static function quicksearch_widget() {

    }

    const ID_COL = "C_ID";
    const FNAME_COL = "FNAME";
    const LNAME_COL = "LNAME";

    static function old_user_pick_widget($label, $widget_name, $db_statement,$class='UserSelect') {
        $returnString = "<br>\n" .
             "<label for='{$widget_name}'> $label </label>\n " .
            "<select name='{$widget_name}'
 id='{$widget_name}' class='$class'  > \n";

        while (($row = oci_fetch_array($db_statement)) != false) {
            $value = $row[self::ID_COL];
            $text = $row[self::LNAME_COL] . ", " . $row[self::FNAME_COL];
            $returnString .= "<option value='$value' > $text </option>\n";
        }
        $returnString .= "</select>\n";
        $returnString .= "<br>\n";
        return $returnString;

    }

    static function start_horizontal_d_list($label, $widget_name, $class='') {
        $returnString = '';
        $returnString .= <<<EOT
            <label for='$widget_name'> $label </label>
            <dl id='$widget_name' name='$widget_name' class='dl-horizontal $class '>
EOT;
        return $returnString;
    }

    static function d_list_entry ($dt, $dd) {
        $returnString = '';
        $returnString .= <<<EOT

            <dt>$dt</dt>
            <dd>$dd</dd>

EOT;
        return $returnString;

    }
    static function end_d_list($label, $widget_name, $class='') {
        $returnString = '';
        $returnString .= <<<EOT
            </dl>
EOT;
        return $returnString;
    }

    static function user_pick_widget($label, $widget_name,$db_conn, $class='') {
        $returnString = '';
        $returnString .= <<<EOT
        <br>
        <label for='{$widget_name}'> $label </label>
        <select name='{$widget_name}' id='{$widget_name}' class='$class' size=5>
            <option disabled>-- EXISTING USERS --</option>
            <option disabled>--------------------</option>
EOT;

        $existing_user_statement = DBFunctions::selectExistingUserList($db_conn);
        while (($row = oci_fetch_array($existing_user_statement)) != false) {
            $value = $row[self::ID_COL];
            $text = $row[self::LNAME_COL] . ", " . $row[self::FNAME_COL];
            $returnString .= "<option value='$value' > $text </option>\n";
        }
        $returnString .= <<<EOT

            <option disabled>--------------------</option>
            <option disabled>--    NEW USERS   --</option>
            <option disabled>--------------------</option>

EOT;
        $new_user_statement = DBFunctions::selectNewUserList($db_conn);
        while (($row = oci_fetch_array($new_user_statement)) != false) {
            $value = $row[self::ID_COL];
            $text = $row[self::LNAME_COL] . ", " . $row[self::FNAME_COL];
            $returnString .= "<option value='$value' > $text </option>\n";
        }

        $returnString .= <<<EOT

            </select>
            <br>

EOT;
        return $returnString;

    }

}


class_alias('WidgetMaker', 'wMk');
