<?php
require_once("DatabaseConnectionPage.php");
$select_input_widgets = Array($biofunction, $exp_name,$category, $species, $subject);
$text_input_widgets = Array($probeid, $cgnumber, $fbcgnumber, $genename, $gonumber);

class QuickSearch extends DatabaseConnectionPage {
    function __construct() {
      parent::_construct();
        global $select_input_widgets, $text_input_widgets;
        $this->title= "Quick Search";
        $this->select_input_widgets = $select_input_widgets;
        $this->text_input_widgets = $text_input_widgets;

    }
}

$qs = new QuickSearch();
$qs->display_page();



/*
<?php
require ("../templates/WebPage.php");
require ("../widgets/search_widgets.php");

initialize_session();
$db_conn = connect_to_db();
$html_start_head("Quick Search");
?>

<body>
<?php header_widget(); ?>
<?php list_of_experiment_popup_widget();

<form class="central_widget" action="SearchResult.php" method="post" name="index" onsubmit="return validate(index);">
  <?php quick_search_widgets() ?>

<input name="btn_submit" type="submit" value="Submit"/>
<input type="hidden" name="searchtype" value="Quick" />
</form>

<?php   include("footer.php"); ?>

</body>
</html>


*/


?>