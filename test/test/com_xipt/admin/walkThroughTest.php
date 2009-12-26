<?php

class WalkThroughTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testAECMI()
  {
  	//go to MI page
  	$this->open(JOOMLA_LOCATION.'/index.php?option=com_acctexp&task=showMicroIntegrations');

  	//try to edit one MI
  	$this->click("cb0");
  	$this->click("//td[@id='toolbar-edit']/a/span");
  	$this->waitPageLoad();
  	
  	$this->assertTrue($this->isTextPresent("mi_jomsocialjspt"));
  	$this->click("Settings");
  	$this->click("//td[@id='toolbar-save']/a/span");
  	$this->waitPageLoad();
  	$this->assertTrue($this->isTextPresent("Changes successfully saved"));
  }
}
?>
