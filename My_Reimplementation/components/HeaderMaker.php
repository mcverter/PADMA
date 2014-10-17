<?php

/**
 * Class HeaderMaker
ion]# cd webpages/
[root@localhost webpages]# ls
advanced_search.php       oniondex.php
change_password_page.php  manage_users.php
delete_experiment.php     quick_search.php
delete_reference.php      search_result.php
edit_experiment.php       upload_experiment.php
edit_profile.php          upload_reference.php


 */
class HeaderMaker
{

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
        <li><a href="../webpages/manage_data.php" title="Manage Data">Manage Data </a></li>

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
            <li> Welcome $userid </li>
            <li><a href="../webpages/logout.php" title="Logout">Log Out</a></li>

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
            <form action="[YOUR ACTION]" method="post" accept-charset="UTF-8">
                <input id="user_username" style="margin-bottom: 15px;" type="text" name="user[username]" size="30" />
                <input id="user_password" style="margin-bottom: 15px;" type="password" name="user[password]" size="30" />
                <input id="user_remember_me" style="float: left; margin-right: 10px;" type="checkbox" name="user[remember_me]" value="1" />
                <label class="string optional" for="user_remember_me"> Remember me</label>
                <input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="commit" value="Sign In" />
            </form>
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
