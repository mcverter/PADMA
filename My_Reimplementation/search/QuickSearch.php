<?php
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");

class QuickSearch extends DatabaseConnectionPage {
    function __construct() {
      parent::_construct();
        $this->title= "Quick Search";
    }
    function print_content() {}
}




/*
<?php
require_once ("../templates/WebPage.php");
require_once ("../widgets/search_widgets.php");

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