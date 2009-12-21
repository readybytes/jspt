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
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    
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
	
  function xtestChildProfileType()
  {
    //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitPageLoad();
    
	// add profiletype-one - id will be 5
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-5-CHILD-of-1");
    $this->select("parent", "value=1");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    
    //id will be 6, child of unpublished profiletype
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-6-CHILD-of-4");
    $this->select("parent", "value=4");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    
    // id will be 7
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-7-CHILD-of-5");
    $this->select("parent", "value=5");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    
    //Normale profiletype child of None
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-8-CHILD-of-NONE");
    $this->select("parent", "value=0");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-9-CHILD-of-5");
    $this->select("parent", "value=5");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-10-CHILD-of-1");
    $this->select("parent", "value=1");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    // child of 10    
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-11-CHILD-of-10");
    $this->select("parent", "value=10");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    // child of 10
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-12-CHILD-of-10");
    $this->select("parent", "value=10");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
  }
  
  function xtestOrderChildProfileType()
  {
  	$this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitPageLoad();
    
  	$this->click("//tr[@id='rowid5']/td[12]/span[2]/a");
    $this->waitPageLoad();
  	$this->click("//tr[@id='rowid12']/td[12]/span[2]/a");
    $this->waitPageLoad();
  	$this->click("//tr[@id='rowid12']/td[12]/span[1]/a");
    $this->waitPageLoad();
  	$this->click("//tr[@id='rowid7']/td[12]/span[2]/a");
    $this->waitPageLoad();
  	$this->click("//tr[@id='rowid2']/td[12]/span[1]/a");
    $this->waitPageLoad();
  	$this->click("//td[@id='published12']/a");
    $this->waitPageLoad();
  	$this->click("//td[@id='published10']/a");
    $this->waitPageLoad();
  	$this->click("//tr[@id='rowid11']/td[12]/span[1]/a");
    $this->waitPageLoad();
  	$this->click("//tr[@id='rowid10']/td[12]/span[2]/a");
    $this->waitPageLoad();
  	$this->click("//tr[@id='rowid4']/td[12]/span[1]/a");
    $this->waitPageLoad();
  }
  
	function xtestDeleteChildProfileType()
	{
	    //setup default location 
        $this->adminLogin();
        $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
        $this->waitPageLoad();
        
        /* 
         *  pt1 - 1  - 0
         *  pt10 - 5 - 4
         *  pt11 - 6 - 5
         *  pt12 - 7 - 6
         */
    	$this->click("//input[@id='cb0']"); // should not delete 1
    	$this->click("//td[@id='toolbar-trash']/a");
    	$this->assertTrue((bool)$this->getConfirmation());
    	$this->waitPageLoad();
    	  
    	$this->click("//input[@id='cb4']"); // should not delete 10
    	$this->click("//td[@id='toolbar-trash']/a");
    	$this->assertTrue((bool)$this->getConfirmation());
    	$this->waitPageLoad();
    	
    	
    	$this->click("//input[@id='cb6']"); // should  delete 12
    	$this->click("//td[@id='toolbar-trash']/a");
    	$this->assertTrue((bool)$this->getConfirmation());
    	$this->waitPageLoad();
    	
    	$this->click("//input[@id='cb5']"); // should  delete 11
    	$this->click("//td[@id='toolbar-trash']/a");
    	$this->assertTrue((bool)$this->getConfirmation());
    	$this->waitPageLoad();
    	
    	$this->click("//input[@id='cb4']"); // should  delete 10
    	$this->click("//td[@id='toolbar-trash']/a");
    	$this->assertTrue((bool)$this->getConfirmation());
    	$this->waitPageLoad();
    	
    	$this->click("//input[@id='cb0']"); // should  delete 1
    	$this->click("//td[@id='toolbar-trash']/a");
    	$this->assertTrue((bool)$this->getConfirmation());
    	$this->waitPageLoad();
    	
    	$this->click("//input[@id='cb0']"); // should  not delete 1
    	$this->click("//input[@id='cb1']"); // should not delete 2
    	$this->click("//input[@id='cb2']"); // should  delete 3
    	$this->click("//input[@id='cb3']"); // should  delete 4
    	$this->click("//td[@id='toolbar-trash']/a");
    	$this->assertTrue((bool)$this->getConfirmation());
    	$this->waitPageLoad();
    	
    	$this->click("//input[@id='cb4']"); // should  not delete 4
    	$this->click("//input[@id='cb5']"); // should delete 6
    	$this->click("//td[@id='toolbar-trash']/a");
    	$this->assertTrue((bool)$this->getConfirmation());
    	$this->waitPageLoad();
    	
	}
}
?>
