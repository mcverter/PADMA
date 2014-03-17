<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/17/14
 * Time: 2:54 AM
 */

class PanelMaker {

    static function panel_experiment_list() {
        echo "<div id='experiment'>";
        self::panel_experiment_list_button();
        echo "</div>";
    }


    static function panel_edit_profile() {
    echo <<< EOT
<fieldset>
    <h2>YOUR PROFILE</h2>

    <div class="instructions">
        <h5>Please reflect your up-to-date information to the system. This  profile data will be inspected by the PADMA system  administrator only at the selection of your account  type.
        The collected information will never be  disclosed.</h5>
    </div>

    <div>
        <h2><font color="#4682B4">Your registered user ID</font></h2>
        "{$userid}" &#8212; to change password, click <a href="PassChange.php">here</a>
</div>
        <input name="btnSubmit" type="button" value="Submit" onClick="utility()"/>&nbsp;&nbsp;&nbsp;&nbsp;
EOT;

}
} 