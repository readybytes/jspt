<?php

class InstallTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
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
    $this->type("install_url", COM_XIPT_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
   
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));
    
    //check migration tables
    $this->_DBO->addTable('#__community_fields');
    $this->_DBO->addTable('#__community_register');
    $this->_DBO->addTable('#__community_users');
    $this->_DBO->addTable('#__xipt_aclrules');
    $this->_DBO->addTable('#__xipt_aec');
    $this->_DBO->addTable('#__xipt_applications');
    $this->_DBO->addTable('#__xipt_profilefields');
    $this->_DBO->addTable('#__xipt_profiletypes'); 
    $this->_DBO->addTable('#__xipt_users');
    $this->_DBO->addTable('#__xipt_users');
    $this->_DBO->addTable('#__components');
    $this->_DBO->filterRow('#__components',"`parent`='0' AND `option` ='com_xipt'");
    $this->_DBO->filterColumn('#__components','id');
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
	    $this->type("install_url", JOMSOCIAL_PKG);
	    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
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
  
  function testCommunityAppsInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
      
	// add profiletype-one
    $this->type("install_url", JOMSOCIAL_APPS1);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    $this->type("install_url", JOMSOCIAL_APPS2);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    $this->type("install_url", JOMSOCIAL_APPS3);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    
    $this->type("install_url", JOMSOCIAL_APPS4);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    $this->type("install_url", JOMSOCIAL_APPS5);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    $this->type("install_url", JOMSOCIAL_APPS6);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    
    
    $sql = "UPDATE `#__plugins` SET `published` = '1' WHERE `folder` ='community';";
    $this->_DBO->execSql($sql);
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
    $this->type("install_url", PLG_XIPT_SYS_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
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
    $this->type("install_url", PLG_XIPT_COM_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
  } 
}
