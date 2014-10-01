<?php

function showExperimentMasterList() {
    if ($role == 'Administrator') {
        db_selectUnrestrictedExperimentListFromMaster();
    }
    elseif ($role == 'Researcher') {
        db_selectRestrictedExperimentListFromMaster($userid);
    }
    else {
        throw new ErrorException();
    }
}

function showExperimentDescription($name) {
    db_selectExperimentDescription($name);
}

function changeExperimentDescription ($name, $description) {
    updateExperimentDescription($name, $description);
}