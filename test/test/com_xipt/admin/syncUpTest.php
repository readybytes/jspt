<?php
class SyncUpTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function createProfileType()
  {
  	$this->open(JOOMLA_LOCATION.'/administrator/index.php?option=com_xipt&view=setup');
	$this->waitPageLoad();
	$this->assertTrue($this->isElementPresent("//td[@id='setupMessage2']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage2']/img[contains(@src,'images/publish_x.png')]"));
    $this->open(JOOMLA_LOCATION.'administrator/index.php?option=com_xipt&view=profiletypes&task=edit');
    $this->waitPageLoad();

    $this->type("//input[@name='name']", "Profile 1");
    $this->type("//input[@id='watermarkparamsxiText']", "P1");
    $this->click("//input[@id='watermarkparamsenableWaterMark1']");
    $this->type("file-upload", JPATH_ROOT.DS.'test'.DS.'test'.DS.'com_xipt'.DS.'admin'.DS.'avatar_1.png');
  	if(TEST_XIPT_JOOMLA_15){
		$this->click("//td[@id='toolbar-save']/a/span");
    }
    else{
    	$this->click("//li[@id='toolbar-save']/a/span");
    }
    $this->waitPageLoad();
  }
  
  function testSyncUp()
  { 
  	$this->_DBO->addTable('#__community_users');
  	$this->_DBO->addTable('#__xipt_users');
  	$this->_DBO->filterColumn('#__community_users', 'params');
  	$this->adminLogin();
	$this->createProfileType();
 	
	$filter['defaultProfiletypeID']=1;
	$this->changeJSPTConfig($filter);
    $this->open(JOOMLA_LOCATION.'/administrator/index.php?option=com_xipt&view=setup');
	$this->waitPageLoad();
    $this->assertTrue($this->isElementPresent("//td[@id='setupMessage4']/a"));
    $this->assertTrue($this->isElementPresent("//td[@id='setupImage4']/img[contains(@src,'images/publish_x.png')]"));
    $this->click("//td[@id='setupMessage4']/a");
    $this->waitPageLoad();     	
  }
}