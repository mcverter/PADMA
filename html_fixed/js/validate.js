<script  type="text/javascript">
function validate(index)
{
  //Check if a search criteria is checked
  var found_it=null
  for (var i=0; i<document.forms.index.searchCriteria.length; i++)  {
    if (document.forms.index.searchCriteria[i].checked)  {
      found_it = document.forms.index.searchCriteria[i].value //set found_it equal to checked button's value
    }
  }
  if(found_it != null){}
  else{
    alert("Please select a search criteria.");
    return false;
  }
  //Check if the search field is empty
  if(""==document.forms.index.txt_searchToken.value)
  {
    alert("Please enter a valid search string.");
    return false;
  }

}

function validate_grid(index)
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
