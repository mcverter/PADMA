<?php
require_once("WebPage.php");
require_once("WidgetMaker.php");
class SearchPage extends WebPage {
    function __construct() {
        parent::__construct();
        $this->title=" Search The Database ";
    }

    function print_js() {
        echo <<< EOT
        <script>
        function submit_form(action) {
            document.forms["PickSearch"].action = action + '.php';
            document.forms["PickSearch"].submit();
        }
    </script>
EOT;

    }
    function print_content() {
        echo <<< EOT

<h2> Explore the Database </h2>
<form class="central_widget" method="post" id="PickSearch">
    <legend> Pick One ... </legend>
EOT;

    make_search_panel();
        echo <<< EOT

</form>
EOT;
    }
}
$sp = new SearchPage();
$sp->display_page();