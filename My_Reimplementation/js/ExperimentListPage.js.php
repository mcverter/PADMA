<?php

require_once(__DIR__ . "/../search/ExperimentListPage.php");

list ($experiment_select, $description_area, $save_button) =
    array (ExperimentListPage::EXPERIMENT_SELECT_ID,
        ExperimentListPage::DESCRIPTION_TEXTAREA_ID,
        ExperimentListPage::SAVE_BUTTON_ID);
?>


<script>
    $(document).ready( function () {
        $('#{$experiment_select}').change(function() {
            var selected = this.value;
            $.ajax({
                url: '../search/SearchAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    experimentid : selected, command: $showExperimentDescription
                 },
                success: function(experimentDesc) {
                    $('#{$description_area}').html(experimentDesc);
                }
            });
        });
        $('#{saveButton}').click(function() {
            $.ajax({
                url: '../search/SearchAJAX.php',
                type: 'POST',
                datype: "html",
                data : {
                    experimentid : selected, description: $newDescription, command: $saveExperimentDescription
                },
                success: function(userData) {
                    console.log(" Data", userData);
                }
            });
        });
    });
</script>
