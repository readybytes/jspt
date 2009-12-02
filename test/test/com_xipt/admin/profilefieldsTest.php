<?php

class ProfileFieldsTest extends XiSelTestCase 
{  
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");
  }

  function testAllSupportForProfileFields()
  {
    //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profilefields&task=edit&editId=2");
    $this->waitForPageToLoad("30000");
    $this->click("profileTypes0");
    $this->click("profileTypes0");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitForPageToLoad("30000");

    // setup custom filters
    $this->_DBO->addTable('#__xipt_profilefields');
    $this->_DBO->filterColumn('#__xipt_profilefields','id');
  }
	
}
?>
