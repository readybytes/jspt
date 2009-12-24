<?php

class ApplicationTest extends XiSelTestCase 
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


  function testAllSupportForApplication()
  {
    //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=applications");
    $this->waitPageLoad();
    
    //db verification settings
    $this->_DBO->addTable('#__xipt_applications');
    $this->_DBO->filterColumn('#__xipt_applications','id');
    
    // now check for showing application
    $this->click("//span[@id='name42']/a");
    $this->waitPageLoad();
    $this->click("profileTypes1");
    $this->click("profileTypes0");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    // for 2
    $this->click("//span[@id='name43']/a");
    $this->waitPageLoad();
    $this->click("profileTypes2");
    $this->click("profileTypes0");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    //for 1,2
    $this->click("//span[@id='name44']/a");
    $this->waitPageLoad();
    $this->click("profileTypes1");
    $this->click("profileTypes2");
    $this->click("profileTypes0");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    //still ALL should reflect
    $this->click("//span[@id='name45']/a");
    $this->waitPageLoad();
    $this->click("profileTypes1");
    $this->click("profileTypes2");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    //For core application
    $this->click("//span[@id='name47']/a");
    $this->waitPageLoad();
    $this->click("profileTypes0");
    $this->click("profileTypes1");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    //still ALL should reflect
    $this->click("//span[@id='name48']/a");
    $this->waitPageLoad();
    $this->click("profileTypes0");
    $this->click("profileTypes2");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
  }
	
}
?>
