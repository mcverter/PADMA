<?php

/**
 * Class WidgetMaker
 *
 * General purpose class for creating all HTML display components,
 * including
 * (1)  form inputs,
 * (2) lists,
 * (3) bootstrap alert messages.
 * (4) AJAX Buttons
 * (5) Widgets for specific pages
 *
 * This class should probably be refactored and simplified and subdivided in a future release.
 * It is a bit crowded, but works fine for now.
 *
 * All functions return a  string which can be concatenated to the output string
 *
 * Class is aliased as "wMk"
 */

class WidgetMaker
{
    /***************************
     * BOOTSTRAP ALERTS
     ***************************/

    /**
     * Creates a Message indicating successful completion of task
     *
     * @param string $id: Element Name and ID
     * @param string $message:  Feedback Message.
     * @param string $hidden:  Controls visibility of message.
     *
     * @return string:  HTML for widget
     */
    static function successMessage($id, $message, $hidden='') {
        return <<< EOT
    <div id="$id" $hidden>
    <div class="alert alert-success">
        <span class="close" data-dismiss="alert">&times;</span>
        <strong>Success!</strong> $message
    </div>
    </div>
EOT;
    }

    /**
     * Creates a Message indicating an Error
     *
     * @param string $id: Element Name and ID
     * @param string $message:  Feedback Message.
     *
     * @return string:  HTML for widget
     */
    static function errorMessage ($id, $message) {
            return <<< EOT
    <div id="$id" >
    <div class="alert alert-danger">
        <span class="close" data-dismiss="alert">&times;</span>
        <strong>Error!</strong> $message
    </div>
    </div>
EOT;
    }



    /****************************
     * LISTS
     ****************************/

    /**
     * Begins a horizontal Definition List
     *
     * @param string $label : Label for List
     * @param string $name: Name and ID
     * @param string $class: CSS Class
     * @return string: HTML for list
     */
    static function start_horizontal_d_list($label, $name, $class='') {
        return <<<EOT
            <label for='$name'> $label </label>
            <dl id='$name' name='$name' class='dl-horizontal $class '>
EOT;
    }

    /**
     * Creates an entry for a Definition List
     *
     * @param string $dt:  Term
     * @param string $dd:  Definition
     * @return string:  HTML for Defnition Entry
     */
    static function d_list_entry ($dt, $dd) {
        return <<<EOT
            <dt>$dt</dt>
            <dd>$dd</dd>
EOT;
    }

    /**
     * Ends Defintion List
     * @return string:  HTML for ending definition List
     */
    static function end_d_list() {
        return  <<<EOT
            </dl>
EOT;
    }

    /****************************
     * FORMS
     ****************************/

    /**
     * Starts an HTML form
     *
     * @param string $action:  Action performed by form
     * @param string $class: CSS class
     * @param string $onsubmit:  Javascript to perform on Form Submission
     * @param string $method:  method used by form
     * @param string $name:  Name and ID of form
     * @param string $attrs:
     *
     * @return string:  HTML for starting a form
     */
    static function start_form ($action, $method='POST', $name='form', $class='', $onsubmit='', $attrs='') {
        $returnString =<<< EOT

        <form action='$action' method='$method' $attrs name='$name' id='$name'
EOT;
        if ($class) {
            $returnString .= " class='$class' ";
        }
        if ($onsubmit) {
            $returnString .= " onsubmit='$onsubmit' ";
        }
        $returnString .=<<< EOT
        >

EOT;
        return $returnString;
    }

    /**
     *
     * Starts a form that can be used for uploading a file.
     *
     * @param string $action:  Action performed by form
     * @param string $class: CSS class
     * @param string $method:  method used by form
     * @param string $name:  Name and ID of form
     * @param string $attrs: Additional Attributes
     *
     * @return string:  HTML for starting a file-uploading form
     */
    static function start_file_form ($action, $method='POST', $name='', $class='', $attrs='') {
        return <<<EOT

        <form action='$action' enctype='multipart/form-data' method='$method' name='$name' id='$name'  class='$class' $attrs >

EOT;
    }


    /**
     * Terminates HTML Form
     *
     * @return string: HTML for completing Form
     */
    static function end_form() {
        return <<<EOT

        </form>

EOT;
    }




    /**
     * Creates a hidden input value
     * @param string $name: Name of input
     * @param string $value: value of input
     * @return string:  HTML string
     */
    static function hidden_input($name, $value) {
        return <<<EOT

        <input type='hidden' name='$name' value='$value' />

EOT;
    }



    /**
     * Creates a Submit button for a form.
     * 
     * @param string $name:  Button name and ID
     * @param string $value:  Displayed value of Button
     * @param string $class:  CSS class
     * 
     * @return string: HTML for element
     */
    static function submit_button($name='', $value='Submit', $class='') {
        return <<<EOT
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
      <button type="submit" name='$name' class=" $class btn btn-default">$value</button>
    </div>
  </div>

EOT;
    }

    /**
     * Creates a text area
     *
     * @param string $label: Label for element
     * @param string $name:  Name and ID
     * @param string $default_text: Displayed Text
     * @param integer $cols:  width
     * @param integer $rows: height
     * @param string $class: CSS class
     * @param string $attrs: Additional Attributes
     *
     * @return string:  HTML for Element
     */
    static function text_area($label, $name, $default_text='',  $cols=20, $rows=5, $class='', $attrs='')  {
        return <<< EOT
        <br>
        <label for='$name'> $label </label>
        <textarea name='$name' id='$name' class='$class' rows=$rows cols=$cols $attrs >
         $default_text
        </textarea>
        <br>
EOT;
    }

    /**
     * Creates a text input box
     *
     * @param string $label:  Label for element
     * @param string $name:  Name and ID of element
     * @param string $default_text: Default text
     * @param string $class:  CSS Class
     * @param string $attrs: Additional Attributes
     *
     * @return string:  HTML for element
     */
    static function text_input($label, $name, $default_text='', $class='', $attrs='') {
        return <<< EOT

        <div class="form-group">
            <label for="$name" class="col-sm-2  col-sm-offset-1 control-label">$label</label>
            <div class="col-sm-8">
                <input type="text" class="form-control $class" id="$name" name="$name" $attrs value="$default_text">
            </div>
        </div>

EOT;
    }

    /**
     * Creates a password input box
     *
     * @param string $label: Label for Element
     * @param string $name:  Name and ID of element
     * @param string $class:  CSS class
     * @param string $attrs: Additional Attributes
     *
     * @return string:  HTML for element
     */
    static function password_input($label, $name, $class='', $attrs='' ) {
        return <<< EOT

      <div class="form-group">
            <label for="$name" class="col-sm-2  col-sm-offset-1 control-label">$label</label>
            <div class="col-sm-8">
                <input type="password" class="form-control $class" id="$name" name="$name" $attrs >
            </div>
        </div>

EOT;
    }

    /**
     * @param $label
     * @param $name
     * @param $value
     * @param string $checked
     * @param string $class
     * @param string $attrs: Additional Attributes
     *
     * @return string
     */
    static function radio_input($label, $name, $value, $checked='', $class='', $attrs='') {
        return <<< EOT

    <label class="radio-inline">
        <input type="radio" name="$name" id="$name" value="$value" $checked class='$class' $attrs> $label
    </label>

EOT;
    }

    /**
     *  Creates an input for uploading a file
     *
     * @param string $label:  Label for Input
     * @param string $name:  Name and ID
     * @param string $class : CSS class
     * @param string $attrs: Extra Attributes
     *
     * @return string :  HTML for Element
     */
    static function file_input($label, $name, $class='', $attrs='') {
        return <<< EOT

    <br>
      <label for='$name'> $label </label>
      <input name='$name' type='file' class='$class' $attrs />
     <br>

EOT;
    }

    /**
     * For making a fieldset.
     * This marks off a div region, enclosed in a border, with a title
     *
     * @param $legend:  Title for the fieldset div
     *
     * @return string : HTML for fieldset
     */
    static function  start_fieldset($legend) {
        return <<< EOT

        <fieldset>
            <legend> $legend </legend>
EOT;

    }

    /**
     * Ends fieldset
     *
     * @return string: HTML for fieldset
     */
    static function end_fieldset() {
        return <<< EOT

        </fieldset>

EOT;

    }

    /**
     * Creates a select form input
     * @param string $label:  Label for input
     * @param string $name:  Name and ID
     * @param resource $db_statement:  Database SELECT used to populate HTML options
     * @param $db_value_key:  Option value
     * @param $db_shown_key:  Option displayed text
     * @param bool $multiple: Whether to allow multiple selections
     * @param string $already_selected:  Already selected option
     * @param integer $size:   Number of rows to show
     * @param string $class:  CSS class
     * @param string $attrs: Additional Attributes
     *
     * @return string:  HTML for Element
     */
    static function select_input($label, $name,
                                 $db_statement,
                                 $db_value_key, $db_shown_key,
                                 $multiple=true,
                                 $already_selected = '',
                                 $size=5,
                                 $class='',
                                 $attrs='') {
        $returnString = <<< EOT

      <div class="form-group">
            <label for="$name" class="col-sm-2  col-sm-offset-1 control-label">$label</label>
            <div class="col-sm-8">
EOT;

        $returnString .= "<select name='{$name}' id='{$name}' $attrs class='form-control $class' size=$size ";
        if ($multiple) {
            $returnString .= " multiple ";
        }
        $returnString .= " > \n";

        while (($row = oci_fetch_assoc($db_statement)) != false) {
            $rowval = $row[$db_value_key];
            $rowshown = $row[$db_shown_key];
            $returnString .= "<option value='$rowval' ";
            if ($rowval === $already_selected) {
                $returnString .= " selected ";
            }
            $returnString .= "> $rowshown </option>\n";
        }
        $returnString .= <<<EOT
                </select>
            </div>
        </div>

EOT;
        return $returnString;
    }

    /****************************
     * AJAX
     ****************************/

    /***
     * Creates a Button that is used to trigger an AJAX action
     * @param string $id: ID of button
     * @param string $buttontext: Displayed Text
     *
     * @return string: HTML for element
     */
    static function button_ajax($id, $buttontext) {
        return <<< EOT
	    <input type='button' id='{$id}' value='{$buttontext}'/>
EOT;
    }


    /****************************
     * SPECIAL USAGE
     ****************************/


    /**
     * Used on User Management Page to display list of New and Existing Users
     *
     * @param $label
     * @param $name
     * @param $db_conn
     * @param string $class
     * @return string
     */
    static function user_pick_widget($label, $name,$db_conn, $class='') {
        $returnString = '';
        $returnString .= <<<EOT
        <br>
        <label for='{$name}'> $label </label>
        <select name='{$name}' id='{$name}' class='$class' size=5>
            <option disabled>-- EXISTING USERS --</option>
            <option disabled>--------------------</option>
EOT;

        $existing_user_statement = DBFunctionsAndConsts::selectExistingUserList($db_conn);
        while (($row = oci_fetch_assoc($existing_user_statement)) != false) {
            $value = $row[DBFunctionsAndConsts::C_ID_COL];
            $text = $row[DBFunctionsAndConsts::LNAME_COL] . ", " . $row[DBFunctionsAndConsts::FNAME_COL];
            $returnString .= "<option value='$value' > $text </option>\n";
        }
        $returnString .= <<<EOT

            <option disabled>--------------------</option>
            <option disabled>--    NEW USERS   --</option>
            <option disabled>--------------------</option>

EOT;
        $new_user_statement = DBFunctionsAndConsts::selectNewUserList($db_conn);
        while (($row = oci_fetch_assoc($new_user_statement)) != false) {
            $value = $row[DBFunctionsAndConsts::C_ID_COL];
            $text = $row[DBFunctionsAndConsts::LNAME_COL] . ", " . $row[DBFunctionsAndConsts::FNAME_COL];
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
