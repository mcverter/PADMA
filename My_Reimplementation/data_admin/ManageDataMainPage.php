<?php
require_once(__DIR__ . "/../templates/WebPage.php");

class ManageDataMainPage extends WebPage
{

    function make_main_frame($title, $userid, $role)
    {
        $returnString = '';
        $returnString .= <<< EOT
        <ul class="nav nav-pills nav-stacked">
            <li> <a href="../webpages/edit_experiment.php">Edit Experiment</a></li>
            <li> <a href="../webpages/upload_experiment.php">Upload Experiment</a></li>
            <li> <a href="../webpages/delete_experiment.php">Delete Experiment</a></li>

EOT;
        if ($role === WebPage::ADMINISTRATOR_ROLE) {
            $returnString .= <<< EOT
            <li> <a href="../webpages/upload_reference.php">Upload Reference</a></li>
            <li> <a href="../webpages/delete_reference.php">Delete Reference</a></li>
EOT;

            $returnString .= <<< EOT
        </ul>
EOT;
        return $returnString;

        }


    }

    function make_page_middle($title, $userid, $role) {
        return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
    }

    function get_title() {
        return "Manage Data";
    }
}


        /*
         * 		if ($role=="Researcher")
                        						{
													echo "<table cellpadding='5' cellspacing='0' width='100%' border='0'>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='uploadagreement.php' method='post' name='index'>";
													echo			"<input id='btnLogin' type='submit' value='Load Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";
													echo		"</td>";
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='deleteExpResearcher.php' method='post' name='index'>";
													echo			"<input id='btnLogin' type='submit' value='Delete Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";
													echo		"</td>";
													echo	"</tr>";
                    								echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='SelectExperimentResearcher.php' method='post' name='index'>";
													echo			"<input id='btnLogin' type='submit' value='Enter/Edit Experiment Detail' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";
													echo		"</td>";
													echo	"</tr>";
													echo "</table>";

												}

												if ($role=="Administrator")
                        						{
													echo "<table cellpadding='5' cellspacing='0' width='100%' border='0'>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='loaderStart.php' method='post' name='usermanagement'>";
													echo			"<input id='btnLogin' type='submit' value='Load Reference Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";
													echo		"</td>";
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='deleteRefAdministrator.php' method='post' name='index'>";
													echo			"<input id='btnLogin' type='submit' value='Delete Reference Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";
													echo		"</td>";
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='uploadagreement.php' method='post' name='index'>";
													echo			"<input id='btnLogin' type='submit' value='Load Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";
													echo		"</td>";
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='deleteExpAdministrator.php' method='post' name='index'>";
													echo			"<input id='btnLogin' type='submit' value='Delete Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";
													echo		"</td>";
													echo	"</tr>";
													echo	"<tr>";
													echo		"<td width='100%' align='center'>";
													echo		"<form  action='SelectExperiment.php' method='post' name='index'>";
													echo			"<input id='btnLogin' type='submit' value='Enter/Edit Experiment Detail' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>";
													echo		"</form>";
													echo		"</td>";
													echo	"</tr>";
													echo "</table>";

												}


}
        */