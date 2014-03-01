<?php
require ("../templates/WebPage.php");
require ("../widgets/search_widgets.php");

initialize_session();
$db_conn = connect_to_db();
$html_head("Grid Search");
?>

<body>

<?php header_widget() />
  <form  action="SearchResult.php" method="post" name="index" onsubmit="return validate(index);"> 
    <input name="btn_submit" type="submit" value="Submit"/>

    <fieldset style="width:100%;padding:2">
      <legend style="color:#4682b4; font-weight:bold;font-family: Verdana; margin-bottom: 15">Search Result
      </legend>
      <center><br><br><br>Result<br><br><br></center>
    </fieldset>

    <input name="btn_submit" type="submit" value="Export"/>
  </form>
  <table class="footerImage"></table>
  <?php
  //include the header page
  include("footer.php");
  ?>
</body>
</html>










