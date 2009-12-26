<?php

class ProfiletypeTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function setUp()
  {
  	//we need to setup parent settings then override other things
  	$this->parentSetup();
    $this->_DBO->addTable('#__xipt_profiletypes');
    $this->_DBO->filterColumn('#__xipt_profiletypes','id');
  }


  function testAddProfileType()
  {
      //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitPageLoad();
      
	// add profiletype-one
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-ONE");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-ONE"));

    // setup custom filters
    $this->_DBO->filterColumn('#__xipt_profiletypes','watermark');
    $this->_DBO->filterColumn('#__xipt_profiletypes','ordering');
  }
	
	function testOrderProfileType()
	{
	    //setup default location 
	    $this->adminLogin();
        $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
        $this->waitForPageToLoad();
	    // in sql load, we will have 5 profiletypes installed
	    // we will move 1 2 3 4 5
	    // we want to order these as 2 1 4 5 3
	    // 1-> down , 3 -> down , 5-> up
    	    
		// 1-> down //id('rowid1')/td[12]/span[2]/a/img
		$this->click("//tr[@id='rowid1']/td[12]/span[2]/a");
		$this->waitForPageToLoad();
		//3 -> down  id('rowid3')/td[12]/span[2]/a/img
		$this->click("//tr[@id='rowid3']/td[12]/span[2]/a");
		$this->waitForPageToLoad();
		//5-> up
		$this->click("//tr[@id='rowid5']/td[12]/span[1]/a");
		$this->waitForPageToLoad();
		
		$this->_DBO->filterOrder('#__xipt_profiletypes','ordering');
	}


	// unpublish fed profiletypes
	function testPublishProfileType()
	{	
	    //setup default location 
	    $this->adminLogin();
        $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
        $this->waitPageLoad();
    
	    // p -> u
		$this->click("//td[@id='published1']/a/"); // 1 st row
		$this->waitPageLoad();
		
		// u -> p
		$this->click("//input[@id='cb1']"); // its 2 row
		$this->click("//td[@id='toolbar-publish']/a"); 
		$this->waitPageLoad();
		
		//p ->u 
    	$this->click("//input[@id='cb2']"); // its 3 row
		$this->click("//td[@id='toolbar-unpublish']/a"); 
		$this->waitPageLoad();
		
		// u -> p
    	//5th one is unpublished mark it publisj
		$this->click("//td[@id='published4']/a/");
		$this->waitPageLoad();
	}

	
	function testDeleteProfileType()
	{
	    //setup default location 
        $this->adminLogin();
        $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
        $this->waitPageLoad();
        
    	$this->click("//input[@id='cb0']");
    	$this->click("//input[@id='cb2']");
    	$this->click("//input[@id='cb4']");
    	$this->click("//td[@id='toolbar-trash']/a");
    	$this->assertTrue((bool)$this->getConfirmation());
    	//proivde yes to popup box.
    	$this->waitPageLoad();
    	  
    	  // we can check for ordering also
    	$this->_DBO->filterColumn('#__xipt_profiletypes','ordering');
	}

  function testAddProfileTypeAvatar()
  {
      //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitPageLoad();
      
	// add profiletype-one
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    
    $this->type("name", "PROFILETYPE-1");
    $this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_1.png");
    $this->type("FileWatermark", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/watermark_1.jpg");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    
    $this->assertTrue($this->isTextPresent("PROFILETYPE-1"));
  
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-2");
	$this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_2.png");
	$this->type("FileWatermark", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/watermark_2.gif");
	$this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("PROFILETYPE-2"));
	
	// add entry 3 with default avatar and watermark as blank
	$this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-3");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-3"));
    
	// now edit first entry, and change watermark
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=1");
    $this->waitPageLoad();
	$this->type("FileWatermark", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/watermark_3.png");
	$this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-1"));
    
    //edit 1st entry
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=1");
    $this->waitPageLoad();
	$this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_3.gif");
	$this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-1"));
	
    // now edit 3rd entry, and change watermark and avatar
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=3");
    $this->waitPageLoad();
    $this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_1.png");
    $this->type("FileWatermark", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/watermark_1.jpg");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-3"));	
    
    // setup custom filters
    $this->_DBO->filterColumn('#__xipt_profiletypes','ordering');
  }
  
  
}
