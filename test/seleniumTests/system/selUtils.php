<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class XiSelTestCase extends PHPUnit_Extensions_SeleniumTestCase 
{
  var  $_DBO;
  protected $captureScreenshotOnFailure = TRUE;
  protected $screenshotPath = JOOMLA_FTP_LOCATION;
  protected $screenshotUrl  = JOOMLA_LOCATION;
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    
    // this will be a assert for every test
    if(method_exists(self,'getSqlPath'))
        $this->assertEquals($this->_DBO->getErrorLog(),'');
  }

  function tearDown()
  {
     // if we need DB based setup then do this
     if(method_exists(self,'getSqlPath'))
         $this->assertTrue($this->_DBO->verify());
  }
  
  function adminLogin()
  {
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    $this->waitForPageToLoad("30000");

    $this->type("modlgn_username", JOOMLA_ADMIN_USERNAME);
    $this->type("modlgn_passwd", JOOMLA_ADMIN_PASSWORD);
    $this->click("link=Login");

    $this->waitForPageToLoad("30000");
    $this->assertTrue($this->isTextPresent("Logout"));
  }
}