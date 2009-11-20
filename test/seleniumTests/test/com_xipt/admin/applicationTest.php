<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class ApplicationTest extends XiSelTestCase 
{

  var  $_DBO;
  protected $captureScreenshotOnFailure = TRUE;
  protected $screenshotPath = JOOMLA_FTP_LOCATION;
  protected $screenshotUrl  = JOOMLA_LOCATION;

  
  function getSqlPath()
  {
      return dirname(__FILE__);
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    
    //verify tables setup
    $this->assertEquals($this->_DBO->getErrorLog(),'');
    $this->_DBO->addTable('#__xipt_application');
    $this->_DBO->filterColumn('#__xipt_application','id');
  }


  function testAllSupportForApplication()
  {
      //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=applications");
    $this->waitForPageToLoad("30000");
      
    //check what happen when we add application for all ptypes
    $this->open("/root1285/administrator/index.php?option=com_xipt&view=applications");
    $this->click("rowid38");
    $this->waitForPageToLoad("30000");
    $this->click("profileTypes0");
    $this->click("profileTypes0");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitForPageToLoad("30000");
  }
	
}
?>
