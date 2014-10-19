<?php

require_once(__DIR__ . "/../components/WidgetMaker.php");

class HeaderMaker
{

    private static function make_login_form() {
        $returnString = '';
        $returnString .= WidgetMaker::start_form("../functions/AuthorizeUserFunction.php")
                . WidgetMaker::text_input('User Id', WebPage::USERID_SESSVAR)
                . WidgetMaker::password_input('Password', WebPage::PASSWORD_POSTVAR)
                . WidgetMaker::submit_button('submit', 'Sign In', ' btn btn-primary ')
                . WidgetMaker::end_form();
/*
                <input id="user_remember_me" style="float: left; margin-right: 10px;" type="checkbox" name="user[remember_me]" value="1" />
                <label class="string optional" for="user_remember_me"> Remember me</label>
*/
        return $returnString;
    }

    /**
     * @return string
     */
    static function make_header($userid, $role)
    {
        $returnString = <<< EOT

<nav class="navbar navbar-default navbar-inverse" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img src="../images/PadmaPix/Padma238w150h.jpg"  alt="CCNY PADMA Logo" >
            </a>
        </div>


        <div class="">
            <ul class="nav navbar-nav">

                <li> <a href="../webpages/oniondex.php"> Main Page </a></li>
                <li><a href="../webpages/experiment_list.php" title="Experiment List"> Experiment List </a></li>
                <li><a href="../webpages/search_main.php" title="Search"> Search </a></li>
                <li class="divider"></li>


EOT;

        if ($role == WebPage::ADMINISTRATOR_ROLE ||
            $role == WebPage::RESEARCHER_ROLE ||
            $role == WebPage::USER_ROLE) {
            if ($role == WebPage::RESEARCHER_ROLE ||
                $role == WebPage::ADMINISTRATOR_ROLE) {
            $returnString .= <<<EOT
        <li><a href="../webpages/manage_data_main.php" title="Manage Data">Manage Data </a></li>

EOT;
     }
            if ($role == WebPage::ADMINISTRATOR_ROLE) {
                $returnString .= <<<EOT
        <li><a href="../webpages/manage_users.php" title="User Management">User Setup</a></li>

EOT;
            }
            $returnString .= <<<EOT
        </ul>
        <ul class="nav navbar-nav navbar-right">


            <li><a href="../webpages/edit_profile.php" title="Edit Profile">Edit Profile</a></li>
            <li style="color:red;" > Welcome $userid </li>
            <li><a href="../functions/LogoutUserFunction.php" title="Logout">Log Out</a></li>

EOT;
        } else {
            $returnString .= <<<EOT
</ul>
<ul class="nav navbar-nav navbar-right">
    <li><a href="/users/sign_up">Sign Up</a></li>
    <li class="divider-vertical"></li>
    <li class="dropdown">
        <a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <strong class="caret"></strong></a>
        <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
            <!-- Login form here -->
EOT;
            $returnString .= self::make_login_form();
            $returnString .= <<<EOT
        </div>
    </li>
</ul>
EOT;
        }

        /**
         *
         * $(function() {
        // Setup drop down menu
        $('.dropdown-toggle').dropdown();

        // Fix input element click problem
        $('.dropdown input, .dropdown label').click(function(e) {
        e.stopPropagation();
        });
        });
         *
         *  <!-- The drop down menu -->
        <ul class="nav pull-right">
        <li><a href="/users/sign_up">Sign Up</a></li>
        <li class="divider-vertical"></li>
        <li class="dropdown">
        <a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <strong class="caret"></strong></a>
        <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
        <!-- Login form here -->
        </div>
        </li>
        </ul>
         */

        $returnString .= <<<EOT
        </ul>
    </div>
  </div>
</nav>
<div class="main container">
EOT;

        return $returnString;
    }
}
