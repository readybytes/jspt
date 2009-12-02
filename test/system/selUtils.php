<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class XiSelTestCase extends PHPUnit_Extensions_SeleniumTestCase 
{
  var  $_DBO;
  protected $captureScreenshotOnFailure = TRUE;
  protected $screenshotPath = JOOMLA_FTP_LOCATION;
  protected $screenshotUrl  = JOOMLA_LOCATION;
  
  function assertPreConditions()
 {
    // this will be a assert for every test
    if(method_exists($this,'getSqlPath'))
        $this->assertEquals($this->_DBO->getErrorLog(),'');
  }

  function assertPostConditions()
  {
     // if we need DB based setup then do this
     if(method_exists($this,'getSqlPath'))
         $this->assertTrue($this->_DBO->verify());
  }
  
  function adminLogin()
  {
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    $this->waitForPageToLoad("30000");

    $this->type("modlgn_username", JOOMLA_ADMIN_USERNAME);
    $this->type("modlgn_passwd", JOOMLA_ADMIN_PASSWORD);
    $this->click("//form[@id='form-login']/div[1]/div/div/a");

    $this->waitForPageToLoad();
    $this->assertTrue($this->isTextPresent("Logout"));
  }
  
  function frontLogin($username=JOOMLA_ADMIN_USERNAME, $password= JOOMLA_ADMIN_PASSWORD)
  {
    $this->open(JOOMLA_LOCATION."/index.php");
    $this->waitForPageToLoad("30000");

    $this->type("modlgn_username", $username);
    $this->type("modlgn_passwd", $password);
    $this->click("//form[@id='form-login']/fieldset/input");
    $this->waitForPageToLoad();
    $this->assertEquals("Log out", $this->getValue("//form[@id='form-login']/div[2]/input"));
  }
  
  function waitPageLoad($time=TIMEOUT_SEC)
  {
      $this->waitForPageToLoad($time);
      // now we just want to verify that 
      // page does not have any type of error
      // XIPT SYSTEM ERROR
      // a call stack ping due to assert/notice etc.
      $this->assertFalse($this->isTextPresent("<span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span>"));
  }
}
