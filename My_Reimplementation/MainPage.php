<?php
require_once("WebPage.php");
require_once("WidgetMaker.php");

class MainPage extends WebPage {
    private $role;

    public function __construct ($title, $role) {
        parent::__construct($title);
        $this->role = $role;
    }

    public function prepare() {
        $role = $this->role;
        check_role($role);
        parent::prepare();
    }

    function print_content() {
        $role = $this->$role;

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
