<?php
require_once(__DIR__ . "/../templates/WebPage.php");
require_once(__DIR__ . "/../widgets/WidgetMaker.php");

class MainPage extends WebPage {

    private $role;

    public function __construct ($title, $role) {
        parent::__construct();
        check_role($role);
	    $this->title = $title;
        $this->role = $role;
    }


    function print_content() {
        $role = $this->role;

        echo <<< EOT
    <div class="central_widget">
EOT;

        switch ($role) {
            case "a":
                make_user_mgmt_button();
            case "r":
                make_data_mgmt_button();
            case "u":
                make_update_profile_btn();
            default:
                make_search_panel();


        }
        echo <<< EOT
    </div>
EOT;

    }
}
