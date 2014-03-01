<?php
require_once("WebPage.php");


$contact_page= new WebPage();
$contact_page->title = "Contact Us";
$contact_page->content =<<<EOT
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


$contact_page->display_page();

?>















