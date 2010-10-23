<?php

class ProfilefieldsTest extends XiSelTestCase 
{  
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testAllSupportForProfileFields()
  {
 //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profilefields&task=edit&id=2");
    $this->waitForPageToLoad("30000");
    $this->click("ptypeSelectAllALLOWED");
    //$this->click("allowedProfileType0");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitForPageToLoad("30000");

    // setup custom filters
    $this->_DBO->addTable('#__xipt_profilefields');
    $this->_DBO->filterColumn('#__xipt_profilefields','id');
  }
	
}