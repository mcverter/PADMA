<?php
require_once(__DIR__ . "/../templates/WebPage.php");
require_once(__DIR__ . "/../templates/WidgetMaker.php");

class SelectSearchPage extends WebPage {
    function __construct() {
        parent::__construct();
        $this->title=" Search The Database ";
    }

    function print_content() {
        echo <<< EOT

<h2> Explore the Database </h2>
<form class="central_widget" method="post" id="PickSearch">
    <legend> Pick One ... </legend>
EOT;

	WidgetMaker::make_search_panel();
        echo <<< EOT

</form>
EOT;
    }
}
