<?php

class PrivacyTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testHidePrivacyElements() {
  	//Case-1: Hide Privacy at rgistration time.
  	$this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=frontpage");
  	$this->waitPageLoad();
  	$this->click("joinButton");
  	$this->waitPageLoad();
  	$this->click("profiletypes1");
  	$this->waitPageLoad();
  	$this->type("jsname", "manish");
    $this->type("jsusername", "manish");
    $this->type("jsemail", "manish@manish.com");
    $this->type("jspassword", "111111");
    $this->type("jspassword2", "111111");
    $this->click("btnSubmit");
    sleep(2);
    $this->click("btnSubmit");
    $this->waitPageLoad();
    $this->assertFalse($this->isElementPresent('//div[@class="js_PriContainer"]'));
  	
    //Case-2: Hide Privacy at Home Page when share any status, photo, video etc, Hide from Profile edit page
  	//Case-3: Hide Privacy menu 
  	$this->frontLogin();
  	$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=frontpage');
  	$this->waitPageLoad();
  	$this->assertFalse($this->isElementPresent('//div[@class="js_PriContainer"]'));
  	$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=frontpage');
  	$this->waitPageLoad();
  	$this->assertFalse($this->isElementPresent('//div[@class="js_PriContainer"]'));
  	
  	$this->open(JOOMLA_LOCATION.'index.php?option=com_community&view=profile&task=edit');
  	$this->waitPageLoad();
  	$this->assertFalse($this->isElementPresent('//div[@class="js_PriContainer"]'));
  	$this->assertFalse($this->isTextPresent("Privacy"));
  	//case-4: Hide privcy at Album Page
   	//case-5: Hide Privacy at video Page
  	$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=photos&task=myphotos');
  	$this->waitPageLoad();
  	$this->click("link=Create Photo Album");
    $this->waitPageLoad();
    $this->assertFalse($this->isTextPresent("Who can see"));
    $this->assertFalse($this->isElementPresent('//select[@class="js_PrivacySelect js_PriDefault"]'));
  }
}
  