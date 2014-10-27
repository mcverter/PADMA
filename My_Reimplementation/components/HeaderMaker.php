<?php

require_once(__DIR__ . "/../components/WidgetMaker.php");


/**
 * Class HeaderMaker
 *
 * Creates the top navbar.
 * The options available on the navbar will vary according to the user $role
 */

class HeaderMaker
{

    /**
     * Creates the login dropdown form on the navbar
     *
     * @return string:  HTML for Login Foirm
     */
    private static function make_login_form() {
        $returnString = '';
        $returnString .= wMk::start_form("../functions/AuthorizeUserFunction.php")
                . wMk::text_input('User Id', pgFn::USERID_SESSVAR)
                . wMk::password_input('Password', pgFn::PASSWORD_POSTVAR)
                . wMk::submit_button('submit', 'Sign In', ' btn btn-primary ')
                . wMk::end_form();
        return $returnString;
    }

    /**
     * Creates the header navbar
     *
     * In all cases, a user will be able to search the database
     *
     * The navbar will appear differently, depending upon the user's $role
     * (1) Not logged in:  User can login or register
     * (2) General User:  User can edit her own profile
     * (3) Researcher:  User can also Manage Data
     * (4) Administrator:  User can also Manage User accounts
     *
     * @param $userid:  Id of logged in user
     * @param $role:  Role of logged in user
     * @return string
     */
    static function make_header($userid, $role)
    {
        $formatted_userid = ucwords(strtolower($userid));
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

                <li> <a href="../webpages/index.php"> Main Page </a></li>
                <li><a href="../webpages/search_main.php" title="Search"> Search </a></li>
                <li class="divider"></li>


EOT;

        if ($role == pgFn::ADMINISTRATOR_ROLE ||
            $role == pgFn::RESEARCHER_ROLE ||
            $role == pgFn::USER_ROLE) {
            if ($role == pgFn::RESEARCHER_ROLE ||
                $role == pgFn::ADMINISTRATOR_ROLE) {
            $returnString .= <<<EOT
        <li><a href="../webpages/manage_data_main.php" title="Manage Data">Manage Data </a></li>

EOT;
     }
            if ($role == pgFn::ADMINISTRATOR_ROLE) {
                $returnString .= <<<EOT
        <li><a href="../webpages/manage_users.php" title="User Management">User Setup</a></li>

EOT;
            }
            $returnString .= <<<EOT
        </ul>
        <ul class="nav navbar-nav navbar-right">


            <li><a href="../webpages/edit_profile.php" title="Edit Profile">Edit Profile</a></li>
            <li style="color:red;" > Welcome $formatted_userid </li>
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

        $returnString .= <<<EOT
        </ul>
    </div>
  </div>
</nav>
EOT;

        return $returnString;
    }
}
