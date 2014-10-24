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
 * It is a bit crowded now, but works fine for now.
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
     * @param string $hidden:  Controls visibility of message.
     *
     * @return string:  HTML for widget
     */
    static function errorMessage ($id, $message, $hidden='hidden') {
            return <<< EOT
    <div id="$id" $hidden>
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
     * @param string string $class: CSS Class
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
     * @return string:  HTML for starting a form
     */
    static function start_form ($action, $method='POST', $name='', $class='', $onsubmit='') {
        return <<<EOT
        <form action='$action' method='$method' name='$name'
        id='$name'  class='$class' onsubmit='$onsubmit' >\n";
EOT;
    }

    /**
     *
     * Starts a form that can be used for uploading a file.
     *
     * @param string $action:  Action performed by form
     * @param string $class: CSS class
     * @param string $onsubmit:  Javascript to perform on Form Submission
     * @param string $method:  method used by form
     * @param string $name:  Name and ID of form
     *
     * @return string:  HTML for starting a file-uploading form
     */
    static function start_file_form ($action, $method='POST', $name='', $class='', $onsubmit='') {
        return <<<EOT
        <form action='$action' enctype='multipart/form-data' method='$method' name='$name'
        id='$name'  class='$class' onsubmit='$onsubmit' >\n";
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
        <input type='submit' name='$name' value='$value' class='$class' />
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
     * @return string:  HTML for Element
     */
    static function text_area($label, $name, $default_text='',  $cols=20, $rows=5, $class='')  {
        return <<< EOT
        <br>
        <label for='$name'> $label </label>
        <textarea name='$name' class='$class'  />
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
     * @return string:  HTML for element
     */
    static function text_input($label, $name, $default_text='', $class='') {
        return <<< EOT
    <br>
      <label for='$name'> $label </label>
      <input name='$name' id='$name' type='text' class='$class' value='$default_text' />
     <br>
EOT;
    }

    /**
     * Creates a password input box
     *
     * @param string $label: Label for Element
     * @param string $name:  Name and ID of element
     * @param string $class:  CSS class
     * @return string:  HTML for element
     */
    static function password_input($label, $name, $class='') {
        return <<< EOT
    <br>
      <label for='$name'> $label </label>
      <input name='$name' id='$name' type='passwword' class='$class'  />
     <br>
EOT;
    }


    /**
     *  Creates an input for uploading a file
     *
     * @param string $label:  Label for Input
     * @param string $name:  Name and ID
     * @param string $class : CSS class
     * @return string :  HTML for Element
     */
    static function file_input($label, $name, $class='') {
        return <<< EOT
    <br>
      <label for='$name'> $label </label>
      <input name='$name' type='file' class='$class' />
     <br>
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
     *
     * @return string:  HTML for Element
     */
    static function select_input($label, $name,
                                 $db_statement,
                                 $db_value_key, $db_shown_key,
                                 $multiple=true,
                                 $already_selected = '',
                                 $size=5,
                                 $class='') {
        $returnString = "<br>\n";
        $returnString .= "<label for='{$name}'> $label </label>";
        $returnString .= "<select name='{$name}' id='{$name}' class='$class' size=$size ";
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
     * Used on User Management Page to assign Access Right to Users
     * @param $db_conn
     * @param $ajax_button
     * @return string
     */
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
