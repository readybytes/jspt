<?php

/* This testcase should run on fresh install */
class SetupTest extends XiSelTestCase 
{

  
  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function communityUnInstall()
  {
	    // go to installation
	    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
	    $this->waitPageLoad("60000");
	    $this->click("//a[@onclick=\"javascript:document.adminForm.type.value='components';submitbutton('manage');\"]");
		$this->waitPageLoad("30000");
		$this->click("cb2");
		$this->click("//td[@id='toolbar-delete']/a/span");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Uninstall Component Success"));
  }
  
  function testCommunityInstall()
  {
	    // setup default location 
	    $this->adminLogin();
	    // uninstall community first
	    $this->communityUnInstall();
	    // go to installation
	    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
	    $this->waitPageLoad("60000");

		// add profiletype-one
	    $this->type("install_url", JOMSOCIAL_PKG);
	    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
	    $this->waitPageLoad();

	    $this->click("//div[@id='element-box']/div[2]/table/tbody/tr[2]/td/table/tbody/tr[2]/td/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");

	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->click("//form[@id='installform']/div/div/input");
	    $this->waitForPageToLoad("60000");
	    $this->assertTrue($this->isTextPresent("Jom Social"));
  }

  function testCreateProfiletype()
  {
    // setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    
    
    //link is present     //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage2']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage2']/img[contains(@src,'images/publish_x.png')]"));
	
    //now add profiletype and link should be removed
    $sql = " INSERT INTO `#__xipt_profiletypes`  (`id`,`name`, `ordering`)  
			 VALUES
			 (1,'PROFILETYPE-1', 1),
			 (2,'PROFILETYPE-2', 2);
			";
    $this->_DBO->execSql($sql);
    
    //now link should be converted into right
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    //link should not be present
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage2']/a"));
    //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage2']/img[contains(@src,'images/tick.png')]"));
    
  }	
  
  function testSetDefaultProfiletype()
  {
  	// setup default location 
    $this->adminLogin();
    $filter['defaultProfiletypeID']=0;
	$this->changeJSPTConfig($filter);
	
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
	
    //link is present , image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage3']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage3']/img[contains(@src,'images/publish_x.png')]"));
    
    $this->click("//td[@id='setupMessage3']/a");
	$this->waitPageLoad();

	$filter['defaultProfiletypeID']=1;
	$this->changeJSPTConfig($filter);
    
    //now link should be converted into right
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();

    //link should not be present , image is correct
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage3']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage3']/img[contains(@src,'images/tick.png')]"));
  }
  
  function testCreateCustomFields()
  {
	$this->_DBO->addTable('#__community_fields');
	$this->_DBO->filterColumn("#__community_fields",'ordering');
    $this->_DBO->filterOrder("#__community_fields","id");
	
	// setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    
    //link is present //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage4']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage4']/img[contains(@src,'images/publish_x.png')]"));
    
	$this->click("//td[@id='setupMessage4']/a");
    $this->waitPageLoad(); // will be back at same page
    
    //link should not be present     //image is correct
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage4']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage4']/img[contains(@src,'images/tick.png')]"));
  }
  
  function testPatchFiles()
  {
	// setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    
    //link is present //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage5']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage5']/img[contains(@src,'images/publish_x.png')]"));
    
	$this->click("//td[@id='setupMessage5']/a");
    $this->waitPageLoad(); // will be back at same page
    
    //link should not be present     //image is correct
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage5']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage5']/img[contains(@src,'images/tick.png')]"));
    
    //if AEC exits
    if(file_exists(JPATH_ROOT.'/components/com_acctexp'))
    {
	    //link is present //image is correct
	    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage7']/a"));
	    $this->assertTrue($this->isElementPresent("//td[@id='setupImage7']/img[contains(@src,'images/publish_x.png')]"));
	    
		$this->click("//td[@id='setupMessage7']/a");
	    $this->waitPageLoad();
	    
	    //link should not be present     //image is correct
	    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage7']/a"));
	    $this->assertTrue($this->isElementPresent("//td[@id='setupImage7']/img[contains(@src,'images/tick.png')]"));
    }
    
    
  }
  
  
  function xxxtestEnablePlugin()
  {
  	// setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    
    //link is present //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage1']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage1']/img[contains(@src,'images/publish_x.png')]"));
    
	$this->click("//td[@id='setupMessage1']/a");
    $this->waitPageLoad(); // will be back at same page
    
    //link should not be present     //image is correct
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage1']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage1']/img[contains(@src,'images/tick.png')]"));
  }
  
  /**
   * @depends testCreateCustomFields
   */
 /* function testSyncUpUserPT()
  {
  	//A silly assumption, in joomla test we always have uuser 62
  	// so we will drop all fields of user 62 
  	$sql = " DELETE FROM `#__community_fields_values`
    		 WHERE `user_id`='62'  ";
    $this->_DBO->execSql($sql);
    
  	// setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    
    //link is present //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage7']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage7']/img[contains(@src,'images/publish_x.png')]"));
    
	$this->click("//td[@id='setupMessage7']/a");
    $this->waitPageLoad(); // will be back at same page
    
    //link should not be present     //image is correct
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage7']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage7']/img[contains(@src,'images/tick.png')]"));
  }*/
  
//  function testMigrateAvatar()
//  {
//  	// setup default location 
//    $this->adminLogin();
//    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
//    $this->waitPageLoad();
//    
//    //link is present //image is correct
//    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage8']/a"));
//    $this->assertTrue($this->isElementPresent("//td[@id='setupImage8']/img[contains(@src,'images/publish_x.png')]"));
//    
//	$this->click("//td[@id='setupMessage8']/a");
//    $this->waitPageLoad(); // will be back at same page
//    
//    //link should not be present     //image is correct
//    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage8']/a"));
//    $this->assertTrue($this->isElementPresent("//td[@id='setupImage8']/img[contains(@src,'images/tick.png')]"));
//    
//    $this->_DBO->addTable('#__xipt_profiletypes');
//    $this->_DBO->filterColumn('#__xipt_profiletypes','watermarkparams');
//    $this->_DBO->addTable('#__community_users');
//  }
  
  function testUnhook()
  {
	//XITODO : use changepluginState fn here  	
	$sql = " UPDATE `#__plugins` SET `published` = '1' WHERE `element` ='xipt_system' LIMIT 1";
  	$this->_DBO->execSql($sql);
	$sql="UPDATE `#__plugins` SET `published` = '1' WHERE `element` ='xipt_community' LIMIT 1";
    $this->_DBO->execSql($sql);
  	// setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup&task=display");
    $this->waitPageLoad();
    
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup&task=unhook");
    $this->waitPageLoad();

    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage4']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage4']/img[contains(@src,'images/publish_x.png')]"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage5']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage5']/img[contains(@src,'images/publish_x.png')]"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage1']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage1']/img[contains(@src,'images/publish_x.png')]"));
    //check xipt_system plugin disabled or not
	//XITODO : use verifyPluginState fn here
	
    $db	=& JFactory::getDBO();
    $query	= " SELECT `published` FROM `#__extensions`"
			." WHERE `element` ='xipt_system' AND `type`='plugin'"
			." LIMIT 1";
	$db->setQuery($query);
	$result = $db->loadObject();
	$this->assertEquals($result->published,0);
	//check xipt_community plugin disabled or not
	$query	= " SELECT `published` FROM `#__extensions`"
			." WHERE `element` ='xipt_community' AND `type`='plugin'"
			." LIMIT 1";
	$db->setQuery($query);
	$result = $db->loadObject();
	$this->assertEquals($result->published,0);  	
    $this->click("//td[@id='setupMessage4']/a");
    $this->waitPageLoad();
    $this->click("//td[@id='setupMessage5']/a");
    $this->waitPageLoad();
    $this->click("//td[@id='setupMessage1']/a");   
    $this->waitPageLoad();
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage4']/a"));
    $this->assertFalse($this->isElementPresent("//td[@id='setupImage4']/img[contains(@src,'images/publish_x.png')]"));
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage5']/a"));
    $this->assertFalse($this->isElementPresent("//td[@id='setupImage5']/img[contains(@src,'images/publish_x.png')]"));
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage1']/a"));
    $this->assertFalse($this->isElementPresent("//td[@id='setupImage1']/img[contains(@src,'images/publish_x.png')]"));
    
  }
}
