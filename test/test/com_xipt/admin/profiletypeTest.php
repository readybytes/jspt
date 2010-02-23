<?php

class ProfiletypeTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  

  function testAddProfileType()
  {
  	$this->_DBO->addTable('#__xipt_profiletypes');
    $this->_DBO->filterColumn('#__xipt_profiletypes','id');
  	
      //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitPageLoad();
      
	// add profiletype-one
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    $this->type("name", "PROFILETYPE-ONE");
    $this->click("watermarkparamsenableWaterMark1");
    $this->type("watermarkparamsxiText", "P1");
    $this->type("watermarkparamsxiWidth", "40");
    $this->type("watermarkparamsxiHeight", "40");
    $this->type("watermarkparamsxiThumbWidth", "20");
    $this->type("watermarkparamsxiThumbHeight", "20");
    $this->type("watermarkparams[xiBackgroundColor]", "0F15D0");
    $this->click("resetAll1");
        
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-ONE"));
	
    $checkWMExists=JFile::exists(JPATH_ROOT.DS.'images'.DS.'profiletype'.DS.'watermark_1.png');
    $this->assertTrue($checkWMExists);
    
    $md5_watermark      = md5(JFile::read(JPATH_ROOT.DS.'images'.DS.'profiletype'.DS.'watermark_1.png'));
    $md5_watermark_gold = md5(JFile::read(JPATH_ROOT.DS.'test'.DS.'test'.DS.'com_xipt'.DS.'admin'.DS.'watermark_1.png'));
    $this->assertEquals($md5_watermark,$md5_watermark_gold);
    // setup custom filters
    //$this->_DBO->filterColumn('#__xipt_profiletypes','watermark');
    $this->_DBO->filterColumn('#__xipt_profiletypes','ordering');
    $this->_DBO->filterColumn('#__xipt_profiletypes','params');
    $this->_DBO->filterColumn('#__xipt_profiletypes','watermarkparams');
  }
	
	function testOrderProfileType()
	{
		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterColumn('#__xipt_profiletypes','id');
		
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
		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterColumn('#__xipt_profiletypes','id');
		
    
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
		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterColumn('#__xipt_profiletypes','id');
		
    
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
    //setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes");
    $this->waitPageLoad();
      
	// Edit profiletype-one
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=1");
    $this->waitPageLoad(); //1: png.jpg
    $this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_1.png");
    
    $this->click("watermarkparamsenableWaterMark1");
     $this->type("watermarkparamsxiText", "Profiletype1");
    $this->click("resetAll1");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
  
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=2");
    $this->waitPageLoad();//2:png,gif
	$this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_2.png");
	 $this->type("watermarkparamsxiText", "Profiletype2");
	$this->click("watermarkparamsenableWaterMark1");
	$this->click("resetAll1");
	$this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
	
	// Edit entry 3 with default avatar and watermark as blank
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=3");
    $this->waitPageLoad();//3: jpg,-
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    
	// now edit first entry, and change watermark
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=1");
    $this->waitPageLoad();//1. png,png
	$this->type("watermarkparamsxiText", "Profiletype1");
    $this->type("watermarkparamsxiWidth", "150");
    $this->type("watermarkparamsxiHeight", "30");
    $this->type("watermarkparamsxiFontSize", "24");
    $this->type("watermarkparams[xiBackgroundColor]", "0F15D0");
    $this->select("watermarkparamsxiWatermarkPosition", "label=Top Right");
    $this->click("resetAll1");
    $this->click("//td[@id='toolbar-save']/a");
		
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-1"));
    
    //edit 1st entry and change avatar before it was PNG and now its GIF
    //user must be updated
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=1");
    $this->waitPageLoad(); //1: gif,png
	$this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_3.gif");
	$this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-1"));
	
    // now edit 3rd entry, and change watermark and avatar
	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=3");
    $this->waitPageLoad();//3: png,png
    $this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_1.png");
	$this->click("watermarkparamsenableWaterMark1");
     $this->type("watermarkparamsxiText", "Profiletype3");
	$this->type("watermarkparamsxiWidth", "100");
    $this->type("watermarkparamsxiHeight", "40");
    $this->type("watermarkparamsxiFontSize", "18");
    $this->type("watermarkparams[xiBackgroundColor]", "0F15D0");
    $this->select("watermarkparamsxiWatermarkPosition", "label=Right Bottom");
    $this->click("resetAll1");
    $this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-3"));	
    
    //now add profiletype-4
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    
    $this->type("name", "PROFILETYPE-4");
    $this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_1.png");
    $this->click("watermarkparamsenableWaterMark1");
     $this->type("watermarkparamsxiText", "Profiletype4");
    $this->type("watermarkparamsxiWidth", "100");
    $this->type("watermarkparamsxiHeight", "40");
    $this->type("watermarkparamsxiFontSize", "18");
    $this->type("watermarkparams[xiBackgroundColor]", "0F15D0");
    $this->select("watermarkparamsxiWatermarkPosition", "label=Right Bottom");
    $this->click("resetAll1");
    $this->click("//td[@id='toolbar-save']/a");//4:png.png
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-4"));
        
    // setup custom filters
    $this->_DBO->addTable('#__xipt_profiletypes');
  	$this->_DBO->filterColumn('#__xipt_profiletypes','id');
    $this->_DBO->filterColumn('#__xipt_profiletypes','ordering');
    $this->_DBO->filterColumn('#__xipt_profiletypes','watermark');
    $this->_DBO->filterColumn('#__xipt_profiletypes','watermarkparams');
    $this->_DBO->addTable('#__community_users');
    $this->_DBO->filterColumn('#__community_users','params');
  }
  
  /*function testChangeAvatar()
  {
  	$this->adminLogin();
  	$this->open(JOOMLA_LOCATION."index.php?option=com_xipt&view=profiletypes");
  	$this->waitPageLoad();
    $this->click("//span[@title='ProfileType1']");
    $this->waitPageLoad();
    $this->type("file-upload", JPATH_ROOT.DS."/var/www/jspt6305/test/test/com_xipt/admin/avatar_1.png");
    $this->click("resetAll1");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
  }
  */
  function testProfiletypeResetAll()
  {
  	$this->adminLogin();
  	$filter['show_watermark']=0;
	$this->changeJSPTConfig($filter);
	
  	//edit 2nd profiletype
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=2");
    $this->waitPageLoad();
    $this->select("jusertype", "label=Editor");
    $this->select("privacy", "label=Public");
    $this->select("template", "value=default");
    //previous was PNG, now adding GIF, so all users must be updated
    $this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/admin/avatar_3.gif");
    $this->click("resetAll1");
	$this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("PROFILETYPE-2"));   
	
	//edit 1st profiletype joomla user type
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=1");
    $this->waitPageLoad();
    $this->select("jusertype", "label=Manager");
    $this->click("resetAll1");
	$this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("PROFILETYPE-1"));

	//edit 3rd profiletype 
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=profiletypes&task=edit&editId=3");
    $this->waitPageLoad();
    $this->select("group", "value=2"); // from 4 to 2
    $this->click("resetAll1");
	$this->click("//td[@id='toolbar-save']/a");
    $this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("PROFILETYPE-3"));
	
	$this->_DBO->addTable('#__community_fields_values');
	$this->_DBO->addTable('#__community_groups_members');
	$this->_DBO->addTable('#__community_users');
	$this->_DBO->addTable('#__users');
	$this->_DBO->addTable('#__xipt_profiletypes');
	$this->_DBO->addTable('#__xipt_users');
	$this->_DBO->addTable('#__core_acl_groups_aro_map');
	$this->_DBO->filterColumn('#__users','lastvisitDate');
	$this->_DBO->filterColumn('#__xipt_profiletypes','tip');
	$this->_DBO->filterColumn('#__xipt_profiletypes','watermark');
	$this->_DBO->filterColumn('#__xipt_profiletypes','wtermarkparams');
	$this->_DBO->filterOrder('#__core_acl_groups_aro_map','aro_id');
  }
}
