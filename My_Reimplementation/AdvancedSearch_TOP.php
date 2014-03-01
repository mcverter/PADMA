<?php
class AdvancedSearch extends SearchPage {
  private $select_widgets = (new BIOFUNCTION(), new EXP_NAME(), new ACTIVECATEGORY(), new ACTIVESPECIES(), new EXPERIMENTSUBJECT());
  private $text_input_widgets = (new PROBEID(), new CGNUMBER, new FLYBASENUMBER(), new GENENAME(), new GONUMBER)

  }


class QuickSearch extends SearchPage {
  private $select_widgets = (new EXP_NAME(), new ACTIVECATEGORY(), new ACTIVESPECIES(), new EXPERIMENTSUBJECT(), new REGULATIONVALUE());
  private $text_input_widgets = ();
  
  public create_text_input_widgets() {
  }

}
?>