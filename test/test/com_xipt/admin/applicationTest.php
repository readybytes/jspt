<?php

class ApplicationTest extends XiSelTestCase 
{
  
function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }


  function testAllSupportForApplication()
  {
    //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=applications");
    $this->waitPageLoad();
    
    //db verification settings
      	$this->_DBO->addTable('#__xipt_applications');
    	$this->_DBO->filterColumn('#__xipt_applications','id');	
    	if(!TEST_XIPT_JOOMLA_15)
  		  $this->_DBO->filterOrder('#__xipt_applications','id');	
  
    
    
    // now check for showing application
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//span[@id='name44']/a");
    else
    	$this->click("//span[@id='name10004']/a");
    $this->waitPageLoad();
    $this->click("ptypeSelectNone");
    $this->click("profileTypes1");
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//td[@id='toolbar-save']/a/span");
    else
    	$this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    // for 2
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//span[@id='name45']/a");
    else
    	$this->click("//span[@id='name10008']/a");
    $this->waitPageLoad();
    $this->click("ptypeSelectNone");
    $this->click("profileTypes2");    
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//td[@id='toolbar-save']/a/span");
    else
    	 $this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    //for 1,2
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//span[@id='name46']/a");
    else
    	$this->click("//span[@id='name10004']/a");
    $this->waitPageLoad();
    $this->click("ptypeSelectNone");
    $this->click("profileTypes1");
    $this->click("profileTypes2");    
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//td[@id='toolbar-save']/a/span");
    else
    	$this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    //still ALL should reflect
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//span[@id='name47']/a");
    else
    	$this->click("//span[@id='name10008']/a");
    $this->waitPageLoad();
    $this->click("profileTypes1");
    $this->click("profileTypes2");
    $this->click("ptypeSelectAll");
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//td[@id='toolbar-save']/a/span");
    else
    	$this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    //For core application
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//span[@id='name49']/a");
    else
    	$this->click("//span[@id='name10004']/a");
    $this->waitPageLoad();
    $this->click("ptypeSelectNone");
    $this->click("profileTypes1");
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//td[@id='toolbar-save']/a/span");
    else
    	$this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    
    //still ALL should reflect
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//span[@id='name50']/a");
    else
    	$this->click("//span[@id='name10008']/a");
    $this->waitPageLoad();
    $this->click("ptypeSelectNone");
    $this->click("profileTypes2");
    if (TEST_XIPT_JOOMLA_15)
    	$this->click("//td[@id='toolbar-save']/a/span");
    else
    	$this->click("//li[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
  }
	
}
