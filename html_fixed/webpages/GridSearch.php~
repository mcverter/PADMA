<!DOCTYPE html>


<head>
  <title>PADMA Database</title>
  <link rel="stylesheet" href="css/style.css" type="text/css" />
  <script  type="text/javascript">


   function validate(index)
   {

     //Check if more than three box is selected
     var selected=0;
     if(document.index.PROBEID.checked==true)
     selected=selected+1;

     if(document.index.CGNUMBER.checked==true)
     selected=selected+1;

     if(document.index.FBCGNUMBER.checked==true)
     selected=selected+1;

     if(document.index.GENENAME.checked==true)
     selected=selected+1;

     if(document.index.GONUMBER.checked==true)
     selected=selected+1;

     if(document.index.BIOFUNCTION.checked==true)
     selected=selected+1;

     if(document.index.EXPERIMENTNAME.checked==true)
     selected=selected+1;

     if(document.index.ACTIVECATEGORY.checked==true)
     selected=selected+1;

     if(document.index.ACTIVESPECIES.checked==true)
     selected=selected+1;

     if(document.index.EXPERIMENTSUBJECT.checked==true)
     selected=selected+1;

     if(document.index.REGULATIONVALUE.checked==true)
     selected=selected+1;

     if(document.index.ADDITIONALINFO.checked==true)
     selected=selected+1;

     if(selected >3)
     {
       alert("Please select three or less checkbox.");
       return false;
     }

   }

  </script>


</head>
<body>

  <?php

  if (session_id() == "") session_start();

  //include the header page
  include("header.php");
  ?>



  <table class="headerImage"></table>
  <h2>Grid Search...</h2>
  <form  action="QuickSearchResult.php" method="post" name="index" onsubmit="return validate(index);">
    <fieldset>
      Prob ID:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      CG Number:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      FBCG Number:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Gene Name:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      GO Number:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Bio Category:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Experiment Name:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Active Category:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Active Species:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Experiment Subject:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
      Regulation Value:
      <select name="title" style="width:90%">
        <option>All</option>
      </select>
    </fieldset>
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










