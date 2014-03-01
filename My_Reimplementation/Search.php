<?php
require ("../templates/WebPage.php");
require ("../widgets/search_widgets.php");

initialize_session();
$db_conn = connect_to_db();
$html_head("Search");
?>

<?php
include("control_functions.php");
initialize_session();
include("user_control_buttons.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />

    <script>
        function submit_form(action) {
            document.forms["PickSearch"].action = action + '.php';
            document.forms["PickSearch"].submit();
        }
    </script>
</head>

<body>
<?php
//include the header page
if (session_id() == "") session_start();
include("header.php");
?>

<h2> Explore the Database </h2>
<form class="central_widget" method="post" id="PickSearch">
    <legend> Pick One ... </legend>
    <?php search_panel() ?>

</form>

<?php
//include the footer page
include("footer.php");
?>
</body>
</html>



