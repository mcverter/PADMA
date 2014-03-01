<?php
require_once("WebPage.php");

class IndexPage extends WebPage {
    public function __construct() {
        $this->set_title("Index");
    }

    function content() {
        echo <<< EOT
    <div class="centered_form">
      <p class="instructions">&nbsp;&nbsp;Send your inquiry or problem &#8212; we will respond you!
      </p>
      <form action="FormToEmail.php" method="post">
	<fieldset>
	  <label for="name"> Your Name</label>
	  <input type="text" size="30" id="name"><br>
	  <label for="email">Email address</label>
	  <input type="text" size="30" id="email"><br>
	  <label for="comments"> Comments</label>
	  <textarea id="comments" rows="6" cols="50"></textarea><br>
	</fieldset>
	<input type="submit" value="Send">
      </form>
    </div>
EOT;

    }
}

$pg = new IndexPage() ;
$pg->display_page();

?>















