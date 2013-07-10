<?php
class usrscrTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

 function testEdituser()
 {
 	$this->adminLogin();
    $this->open(JOOMLA_LOCATION.'/administrator/index.php?option=com_xipt');
    $this->waitPageLoad();
    if(TEST_XIPT_JOOMLA_15){
   		 $this->click("//ul[@id='menu-jomsocial-profile-types']/li[10]/a");
    }
    else{
    	$this->click("//ul[@id='submenu']/li[10]/a");
    }
    $this->waitPageLoad();
    $this->click("link=regtest6208627");
    $this->waitPageLoad();
    $this->select("profiletypes", "label=PROFILETYPE-1");
    if(TEST_XIPT_JOOMLA_15){
      $this->click("//td[@id='toolbar-save']/a/span");
    }
    else
      $this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("User saved"));
    
    //check whether edit template can be done or not.
    $this->open(JOOMLA_LOCATION.'/administrator/index.php?option=com_xipt&view=users');
    $this->click("link=regtest6208627");
    $this->waitPageLoad();
    $this->select("template", "label=default");
     if(TEST_XIPT_JOOMLA_15){
      $this->click("//td[@id='toolbar-save']/a/span");
    }
    else
      $this->click("//li[@id='toolbar-save']/a/span");
    
    $this->waitForPageToLoad();
    $this->assertTrue($this->isTextPresent("User saved"));
 }
 
 function testSearchUser()
 {
 	$this->adminLogin();
    $this->open(JOOMLA_LOCATION.'/administrator/index.php?option=com_xipt');
    $this->waitPageLoad();
    if(TEST_XIPT_JOOMLA_15){
    	$this->click("//ul[@id='menu-jomsocial-profile-types']/li[10]/a");
    }
    else{
    	$this->click("//ul[@id='submenu']/li[10]/a");
    }
    $this->waitPageLoad();
    $this->type("search", "regtest6208627");
    $this->click("//button[@onclick='this.form.submit();']");
    $this->waitPageLoad();
    $this->assertTrue($this->isElementPresent("//tr[@id='rowid80']/td[3]"));
 }
 
 
}