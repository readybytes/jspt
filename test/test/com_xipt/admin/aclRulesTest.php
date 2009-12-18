<?php

class AclRulesTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    
    $this->_DBO->addTable('#__xipt_profiletypes');
    $this->_DBO->filterColumn('#__xipt_profiletypes','id');
  }


  function testAddAclRules()
  {
    //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=aclrules");
    $this->waitPageLoad();
      
	// add Rule-1
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("rulename", "RULE-1");
    $this->select("profiletype", "value=1");
    $this->type("taskcount", "5");
    $this->type("message", "You are not allowed to access this resource ha ha hah");
    $this->type("redirecturl", "index.php?option=com_community&view=profile");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("RULE-1"));
  }
}
?>
