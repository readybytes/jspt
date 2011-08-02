<?php

class ConfigurationTest extends XiSelTestCase 
{
  
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  

  function testConfiguration()
  {  
  	  //setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=configuration");
    $this->waitPageLoad();
       
    // now check for showing application
    $profiletype = array (1,2,3,4,5);
    foreach ($profiletype as $p)
    {
    	$this->assertTrue($this->isTextPresent("PROFILETYPE-$p"));
    	//no reset link
  	    $element = " //a[@href='".JOOMLA_LOCATION."administrator/index.php?option=com_xipt&view=configuration&task=reset&profileId=$p". "']";
    	$element = " //a[@href='index.php?option=com_xipt&view=configuration&task=reset&profileId=$p']";
    }
    
    //now edit 2
    $p = 2;
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=configuration&task=edit&id=$p");
    $this->waitPageLoad();
    $this->click("enablegroups0");
    $this->click("enablereporting0");
    $this->click("enablevideos0");
    $this->click("enablephotos0");
     $this->type("pmperday", "2");
    $this->type("limit_groups_perday", "2");
       $this->type("limit_photos_perday", "4");
    $this->type("limit_videos_perday", "5");
    $this->type("limit_friends_perday", "2");
    if(TEST_XIPT_JOOMLA_15)
	    $this->click("//td[@id='toolbar-save']/a");
    else
	    $this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    //check for reset link
    $element = " //a[@href='index.php?option=com_xipt&view=configuration&task=reset&profileId=$p']";
    $this->assertTrue($this->isElementPresent($element));
    
    $params = XiptFactory::getInstance('profiletypes', 'model')->loadParams(2,'params');
    $this->assertEquals($params->get('enablegroups'), 0);
    $this->assertEquals($params->get('enablereporting'), 0);
    $this->assertEquals($params->get('enablevideos'), 0);
    $this->assertEquals($params->get('enablephotos'), 0);
    $this->assertEquals($params->get('pmperday'), 2);
    $this->assertEquals($params->get('limit_groups_perday'), 2);
    $this->assertEquals($params->get('limit_photos_perday'), 4);
    $this->assertEquals($params->get('limit_videos_perday'), 5);
    $this->assertEquals($params->get('limit_friends_perday'), 2);
    // avoid caching issue
  	XiptLibJomsocial::cleanStaticCache(true);  
    //edit 1
    $p = 1;
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=configuration&task=edit&id=$p");
    $this->waitPageLoad();
    $this->click("enablegroups1");
    $this->click("enablereporting0");
    $this->click("enablevideos0");
    $this->click("enablephotos0");
    if(TEST_XIPT_JOOMLA_15)
	    $this->click("//td[@id='toolbar-save']/a");
    else
	    $this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    $element = " //a[@href='index.php?option=com_xipt&view=configuration&task=reset&profileId=$p']";
    $this->assertTrue($this->isElementPresent($element));
    
    $params = XiptFactory::getInstance('profiletypes', 'model')->loadParams(1,'params');
    $this->assertEquals($params->get('enablegroups'), 1);
    $this->assertEquals($params->get('enablereporting'), 0); //default value 1 in JS 2.1.3
    $this->assertEquals($params->get('enablevideos'), 0);  //default value 1 in JS 2.1.3
    $this->assertEquals($params->get('enablephotos'), 0);  //default value 1 in JS 2.1.3

    //edit 3
    $p = 3;
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=configuration&task=edit&id=$p");
    $this->waitPageLoad();
    $this->click("enablegroups1");
    $this->click("enablereporting1");
    $this->click("enablevideos1");
    $this->click("enablephotos1");
    $this->type("pmperday", "2");
    $this->type("limit_groups_perday", "2");
    $this->type("limit_photos_perday", "4");
    $this->type("limit_videos_perday", "5");
    $this->type("limit_friends_perday", "2");
    if(TEST_XIPT_JOOMLA_15)
	    $this->click("//td[@id='toolbar-save']/a");
    else
	    $this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    $element = " //a[@href='index.php?option=com_xipt&view=configuration&task=reset&profileId=$p']";
    $this->assertTrue($this->isElementPresent($element));
    
    $params = XiptFactory::getInstance('profiletypes', 'model')->loadParams(3, 'params');
    $this->assertEquals($params->get('enablegroups'), 1);
    $this->assertEquals($params->get('enablereporting'), 1);
    $this->assertEquals($params->get('enablevideos'), 1);
    $this->assertEquals($params->get('enablephotos'), 1);
     $this->assertEquals($params->get('pmperday'), 2);
     $this->assertEquals($params->get('limit_groups_perday'), 2);
     $this->assertEquals($params->get('limit_photos_perday'), 4);
     $this->assertEquals($params->get('limit_videos_perday'), 5);
     $this->assertEquals($params->get('limit_friends_perday'), 2);
    
    //no reset link for 4 and 5
    $p=4;
    $element = " //a[@href='index.php?option=com_xipt&view=configuration&task=reset&profileId=$p']";
    $this->assertFalse($this->isElementPresent($element));
    
    $p=5;
    $element = " //a[@href='index.php?option=com_xipt&view=configuration&task=reset&profileId=$p']";
    $this->assertFalse($this->isElementPresent($element));

    //now reset 1 entry
    $p=1;
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=configuration&task=reset&profileId=$p");
    $this->waitPageLoad();
    $element = " //a[@href='index.php?option=com_xipt&view=configuration&task=reset&profileId=$p']";
    $this->assertFalse($this->isElementPresent($element));    
    
  }
  
  function testGlobalSettings()
  {
  	$this->_DBO->addTable('#__xipt_settings');
  	$this->adminLogin();
  	$this->open(JOOMLA_LOCATION.'/administrator/index.php?option=com_xipt&view=settings');
  	$this->waitPageLoad();
  	
    $this->click("settingsshow_ptype_during_reg1");    
    $this->select("settings[defaultProfiletypeID]", "label=PROFILETYPE-1");
    $this->select("settings[guestProfiletypeID]", "label=PROFILETYPE-3");
    $this->click("settingssubscription_integrate1");
    if(TEST_XIPT_JOOMLA_15)      	
  		$this->click("//td[@id='toolbar-save']/a");
    else
  	 	$this->click("//li[@id='toolbar-save']/a/span");
  	$this->waitPageLoad();
  }
}