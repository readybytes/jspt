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
  	$this->adminLogin();
  	//go to MI page
  	$this->open(JOOMLA_LOCATION.'/administrator/index.php?option=com_acctexp&task=showMicroIntegrations');

  	//try to edit one MI
  	$this->click("cb0");
  	if(TEST_XIPT_JOOMLA_15)
  		$this->click("//td[@id='toolbar-edit']/a/span");
  	else
  		$this->click("//li[@id='toolbar-edit']/a/span");
  	$this->waitPageLoad();
  	
  	$this->assertTrue($this->isTextPresent("mi_jomsocialjspt"));
  	
  	if(TEST_XIPT_JOOMLA_15){
  		$this->click("Settings");
  		$this->click("//td[@id='toolbar-save']/a/span");
  	}  		
    else{
  		$this->click("//dl[@id='createMicroIntegration']/dt[2]/span");
  		$this->click("//li[@id='toolbar-save']/a/span");
  	}
  	$this->waitPageLoad();
  	$this->assertTrue($this->isTextPresent("Changes successfully saved"));
  }
}
?>
