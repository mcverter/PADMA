<?php
class PickSearch extends WebPage {
  public function __construct($title, $type) {
    parent::__construct($this->title);
    $this->title = "Pick Search";
    $this->search_type = new SearchType($search_type);
  }

    function add_js() {
    echo <<< EOT
    <script>
        function submit_form(action) {
            document.forms["PickSearch"].action = action + '.php';
            document.forms["PickSearch"].submit();
        }
    </script>
EOT;
    }



  }

