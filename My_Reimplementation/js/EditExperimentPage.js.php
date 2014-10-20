<?php
$experiment_select_name = self::EXPERIMENT_SELECT_NAME;
$description_script = self::DESCRIPTION_SCRIPT;

$innerHTML =
    wMk::start_form($_SERVER['PHP_SELF']) .
    wMk::text_area() .
    wMk::submit_button() .
    wMk::end_form();
?>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function(event) {
        event.preventDefault();
        $('#{$experiment_select_name}').change(function() {
            var experimentData = {expName : $(this).name }
            $.post('{$descriptionScript}', experimentData, function(data) {
                $('#description').innerHTML({$innerHTML});
            });
        });
    });
</script>
