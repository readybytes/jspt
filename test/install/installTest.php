<?php

class InstallTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'';
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    
    //verify tables setup
    $this->assertEquals($this->_DBO->getErrorLog(),'');
  }

  /**
   * We will upgrade JomSocial from existing 1.5.248 + JSPT installation
   * @return unknown_type
   */
  function testCommunityInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
      
	// add profiletype-one
    $this->type("install_package", JOMSOCIAL_PKG);
    $this->click("//form[@name='adminForm']/table[1]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();

  $this->click("//div[@id='element-box']/div[2]/table/tbody/tr[2]/td/table/tbody/tr[2]/td/input");
  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");

  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");
  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");
  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");
  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");
  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");
  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");
  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");
  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");
  $this->waitForPageToLoad("30000");
  $this->click("//form[@id='installform']/div/div/input");
  $this->waitForPageToLoad("30000");
  $this->assertTrue($this->isTextPresent("Jom Social"));



  }
  
  /**
   */
  function testXiptInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
      
	// add profiletype-one
    $this->type("install_package", COM_XIPT_PKG);
    $this->click("//form[@name='adminForm']/table[1]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));
  }
  
  /**
   */
  function testXiptSystemPluginInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
      
	// add profiletype-one
    $this->type("install_package", PLG_XIPT_SYS_PKG);
    $this->click("//form[@name='adminForm']/table[1]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
  }
  
  /**
   */
  function testXiptCommunityPluginInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
      
	// add profiletype-one
    $this->type("install_package", PLG_XIPT_COM_PKG);
    $this->click("//form[@name='adminForm']/table[1]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
  }
  
}