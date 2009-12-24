<?php

/* This testcase should run on fresh install */
class SetupTest extends XiSelTestCase 
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
  }


  function testCreateProfiletype()
  {
    // setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    
    //link is present
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage1']/a"));
    //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage1']/img[contains(@src,'images/publish_x.png')]"));
    
	//$this->click("//td[@id='setupMessage1']/a");
	//XITODO : how to crosscheck link is going on right place
	
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
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage1']/a"));
    //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage1']/img[contains(@src,'images/tick.png')]"));
    
  }	
  
  function testSetDefaultProfiletype()
  {
  	// setup default location 
    $this->adminLogin();
    
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    
    //link is present
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage2']/a"));
    //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage2']/img[contains(@src,'images/publish_x.png')]"));
    
	//$this->click("//td[@id='setupMessage1']/a");
	$filter['defaultProfiletypeID']=1;
	$this->changeJSPTConfig($filter);
    
    //now link should be converted into right
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    //link should not be present
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage2']/a"));
    //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage2']/img[contains(@src,'images/tick.png')]"));
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
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage3']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage3']/img[contains(@src,'images/publish_x.png')]"));
    
	$this->click("//td[@id='setupMessage3']/a");
    $this->waitPageLoad(); // will be back at same page
    
    //link should not be present     //image is correct
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage3']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage3']/img[contains(@src,'images/tick.png')]"));
  }
  
  function testPatchFiles()
  {
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
  
  
  function testEnablePlugin()
  {
  	// setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=setup");
    $this->waitPageLoad();
    
    //link is present //image is correct
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage6']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage6']/img[contains(@src,'images/publish_x.png')]"));
    
	$this->click("//td[@id='setupMessage6']/a");
    $this->waitPageLoad(); // will be back at same page
    
    //link should not be present     //image is correct
    $this->assertFalse($this->isElementPresent("//td[@id='setupMessage6']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage6']/img[contains(@src,'images/tick.png')]"));
  }
  
  /**
   * @depends testCreateCustomFields
   */
  function testSyncUpUserPT()
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
  }
}