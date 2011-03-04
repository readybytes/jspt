<?php

class AclRulesTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }


  function testAddAclRules()
  {
    //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=aclrules");
    $this->waitPageLoad();
      
	// add Rule-1
  	if(TEST_XIPT_JOOMLA_15){
		$this->click("//td[@id='toolbar-new']/a");
    }
    if(TEST_XIPT_JOOMLA_16){
    	$this->click("//li[@id='toolbar-new']/a/span");
    }
    $this->waitPageLoad();
    
    $this->select("//select[@id='acl']", "value=addalbums");
    $this->click("//input[@type='submit']");
    $this->waitPageLoad();
    $this->type("rulename", "Can not Add Album more than 5");
    $this->type("aclparamsaddalbums_limit", "5");
    $this->select("coreparams[core_profiletype]", "label=PROFILETYPE-1");
    if(TEST_XIPT_JOOMLA_15){
		$this->click("//td[@id='toolbar-save']/a/span");
    }
    if(TEST_XIPT_JOOMLA_16){
    	$this->click("//li[@id='toolbar-save']/a/span");
    }
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Can not Add Album more than 5"));
    $this->_DBO->addTable('#__xipt_aclrules');
    $this->_DBO->filterColumn('#__xipt_aclrules','id');
  }
}
?>
