<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class ProfileTypeTest extends PHPUnit_Extensions_SeleniumTestCase 
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
    $this->_DBO->addTable('#__xipt_profiletypes');
    $this->_DBO->filterColumn('#__xipt_profiletypes','id');
  }

  function tearDown()
  {
     // no verify results
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


  function testAddProfileType()
  {
      //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitForPageToLoad("30000");
      
	// add profiletype-one
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitForPageToLoad("30000");
    $this->type("name", "PROFILETYPE-ONE");
    $this->type("tip", "PROFILETYPE-ONE-TIP");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitForPageToLoad("30000");
    $this->assertTrue($this->isTextPresent("PROFILETYPE-ONE"));

    // setup custom filters
    $this->_DBO->filterColumn('#__xipt_profiletypes','ordering');
  }
	
	function testOrderProfileType()
	{
	    //setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitForPageToLoad("30000");
	    // in sql load, we will have 5 profiletypes installed
	    // we will move 1 2 3 4 5
	    // we want to order these as 2 1 4 5 3
	    // 1-> down , 3 -> down , 5-> up
    	    
		// 1-> down //id('rowid1')/td[12]/span[2]/a/img
		$this->click("//tr[@id='rowid1']/td[12]/span[2]/a");
		$this->waitForPageToLoad("30000");
		//3 -> down  id('rowid3')/td[12]/span[2]/a/img
		$this->click("//tr[@id='rowid3']/td[12]/span[2]/a");
		$this->waitForPageToLoad("30000");
		//5-> up
		$this->click("//tr[@id='rowid5']/td[12]/span[1]/a");
		$this->waitForPageToLoad("30000");
		
		$this->_DBO->filterOrder('#__xipt_profiletypes','ordering');
	}


	// unpublish fed profiletypes
	function testPublishProfileType()
	{	
	    //setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitForPageToLoad("30000");
    
	    // p -> u
		$this->click("//td[@id='published1']/a/"); // 1 st row
		$this->waitForPageToLoad("30000");
		
		// u -> p
		$this->click("//input[@id='cb1']"); // its 2 row
		$this->click("//td[@id='toolbar-publish']/a"); 
		$this->waitForPageToLoad("30000");
		
		//p ->u 
    	$this->click("//input[@id='cb2']"); // its 3 row
		$this->click("//td[@id='toolbar-unpublish']/a"); 
		$this->waitForPageToLoad("30000");
		
		// u -> p
    	//5th one is unpublished mark it publisj
		$this->click("//td[@id='published4']/a/");
		$this->waitForPageToLoad("30000");
	}

	
	function testDeleteProfileType()
	{
	    //setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitForPageToLoad("30000");
        
    	  $this->click("//input[@id='cb0']");
    	  $this->click("//input[@id='cb2']");
    	  $this->click("//input[@id='cb4']");
    	  $this->click("//td[@id='toolbar-trash']/a");
    	  $this->assertTrue((bool)$this->getConfirmation());
    	  //proivde yes to popup box.
    	  $this->waitForPageToLoad("30000");
    	  
    	  // we can check for ordering also
    	  $this->_DBO->filterColumn('#__xipt_profiletypes','ordering');
	}

}
?>
