<?php

function load_experiment_widget() {
	<form  action='uploadagreement.php' method='post' name='index'>
	<input id='btnLogin' type='submit' value='Load Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
  
}

function delete_researcher_widget() {
	<form  action='deleteExpResearcher.php' method='post' name='index'>
	<input id='btnLogin' type='submit' value='Delete Experiment Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>

}

function edit_researcher_widget() {
	<form  action='SelectExperimentResearcher.php' method='post' name='index'>
	<input id='btnLogin' type='submit' value='Enter/Edit Experiment Detail' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
    }
function load_reference_data_widget() {
	<form  action='loaderStart.php' method='post' name='usermanagement'>
	<input id='btnLogin' type='submit' value='Load Reference Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
    }

funciton delete_reference_data() {
	<form  action='deleteRefAdministrator.php' method='post' name='index'>
	<input id='btnLogin' type='submit' value='Delete Reference Data' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
    }

}
?>