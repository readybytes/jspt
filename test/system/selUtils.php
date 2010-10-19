<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class XiSelTestCase extends PHPUnit_Extensions_SeleniumTestCase 
{
  var  $_DBO;
  protected $captureScreenshotOnFailure = TRUE;
  protected $screenshotPath = SCREENSHOT_PATH;
  protected $screenshotUrl  = SCREENSHOT_URL;
/*  
  protected $collectCodeCoverageInformation = TRUE;
  protected $coverageScriptUrl = 'http://localhost/phpunit_coverage.php';
 */ 
  function setUp()
  {
  	$this->parentSetup();
  }
  
  function click($elem)
  {
  	$this->assertTrue($this->isElementPresent($elem)," Element $elem was not found");
  	parent::click($elem);
  }
  
  function type($elem, $data)
  {
  	$this->assertTrue($this->isElementPresent($elem));
  	parent::type($elem, $data);
  }
  
  
  function get_js_version()
  {	
	$CMP_PATH_ADMIN	= JPATH_ROOT . DS. 'administrator' .DS.'components' . DS . 'com_community';

	$parser		=& JFactory::getXMLParser('Simple');
	$xml		= $CMP_PATH_ADMIN . DS . 'community.xml';

	$parser->loadFile( $xml );

	$doc		=& $parser->document;
	$element	=& $doc->getElementByPath( 'version' );
	$version	= $element->data();

	return $version;
  }

  function parentSetup()
  {
  	$this->setHost(SEL_RC_SERVER);
  	$this->setPort(SEL_RC_PORT);
  	$this->setTimeout(10);
  	
  	//to be available to all childs
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION);
    
    $filter['debug']=1;
    $filter['error_reporting']=6143;
    $this->updateJoomlaConfig($filter);
  }
  
  function assertPreConditions()
  {
    // this will be a assert for every test
    if(method_exists($this,'getSqlPath'))
        $this->assertEquals($this->_DBO->getErrorLog(),'');
  }

  function assertPostConditions()
  {
     // if we need DB based setup then do this
     if(method_exists($this,'getSqlPath'))
         $this->assertTrue($this->_DBO->verify());
  }
  
  function adminLogin()
  {
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    $this->waitForPageToLoad("60000");

    $this->type("modlgn_username", JOOMLA_ADMIN_USERNAME);
    $this->type("modlgn_passwd", JOOMLA_ADMIN_PASSWORD);
    $this->click("//form[@id='form-login']/div[1]/div/div/a");

    $this->waitForPageToLoad();
    $this->assertTrue($this->isTextPresent("Logout"));
  }
  
  function frontLogin($username=JOOMLA_ADMIN_USERNAME, $password= JOOMLA_ADMIN_PASSWORD)
  {
    $this->open(JOOMLA_LOCATION."/index.php");
    $this->waitForPageToLoad("60000");

    $this->type("modlgn_username", $username);
    $this->type("modlgn_passwd", $password);
    $this->click("//form[@id='form-login']/fieldset/input");
    $this->waitForPageToLoad();
    $this->assertEquals("Log out", $this->getValue("//form[@id='form-login']/div[2]/input"));
  }
  
  function frontLogout()
  {
  	$this->open(JOOMLA_LOCATION."/index.php");
    $this->waitForPageToLoad("60000");
    $this->assertEquals("Log out", $this->getValue("//form[@id='form-login']/div[2]/input"));
    $this->click("//form[@id='form-login']/div[2]/input");
    $this->waitForPageToLoad("60000");
    $this->assertTrue($this->isElementPresent("modlgn_username"));
  }
  
  function waitPageLoad($time=TIMEOUT_SEC)
  {
      $this->waitForPageToLoad($time);
      // now we just want to verify that 
      // page does not have any type of error
      // XIPT SYSTEM ERROR
      $this->assertFalse($this->isTextPresent("( ! ) Notice:"));
      $this->assertFalse($this->isTextPresent("500 - An error has occurred."));
      $this->assertFalse($this->isTextPresent("XIPT-SYSTEM-ERROR"));
      // a call stack ping due to assert/notice etc.
  }
  
  function waitForElement($element)
  {
	  //wait for ajax window
  		for ($second = 0; ; $second++) {
	        if ($second >= 10) $this->fail("timeout");
	        try {
	            if ($this->isElementPresent($element)) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
  }
  
  function changeJomSocialConfig($filters)
  {
	require_once (JPATH_BASE . '/components/com_community/libraries/core.php' );
	$query = "SELECT params FROM `#__community_config` WHERE `name`='config'";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$params=$db->loadResult();
	
	$newParams = new JParameter($params);
	foreach($filters as $key => $value)
		$newParams->set($key,$value);
		
	$paraStr = '';
	$allData = $newParams->_registry['_default']['data']; 
	foreach ($allData as $key => $value)
		$paraStr .= "$key=$value\n";
		
	$query = "UPDATE `#__community_config` SET `params`='".$paraStr."' WHERE `name`='config'";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$db->query();
  }
  
  function changeJSPTConfig($filters)
  {
 
  	if(!$filters)
  		return;
  		
	$query = "SELECT params FROM `#__xipt_settings` WHERE `name`='settings' ";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$params=$db->loadResult();
	
	$newParams = new JParameter($params);
	
	foreach($filters as $key => $value)
		$newParams->set($key,$value);
		
	$paraStr = '';
	$allData = $newParams->_registry['_default']['data']; 
	foreach ($allData as $key => $value)
		$paraStr .= "$key=$value\n";
		
	$query = "UPDATE `#__xipt_settings` SET `params`='".$paraStr."' WHERE `name`='settings' ";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$db->query();
  	
	$done=true;
  }
  
  function updateJoomlaConfig($filter)
  {
	  	$config =& JFactory::getConfig();		
  		foreach($filter as $key=>$value)
  			$config->setValue($key,$value);
  		
		jimport('joomla.filesystem.file');
		$fname = JPATH_CONFIGURATION.DS.'configuration.php';
		
		system("sudo chmod 777 $fname");
		
  		if (!JFile::write($fname, 
  				$config->toString('PHP', 'config', array('class' => 'JConfig')) )
  		    ) 
		{
			echo JText::_('ERRORCONFIGFILE');
		}
  		
  }
  
  function changePluginState($pluginname, $action=1)
  {
  	
		$db			=& JFactory::getDBO();
		$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
	          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);

		$db->setQuery($query);		
		
		if(!$db->query())
			return false;
			
		return true;
  }
  
  
  /**
   * Verifies that plugin is in correct state
   * @param $pluginname : Name of plugin
   * @param $enabled : Boolean, 
   * @return unknown_type
   */
  function verifyPluginState($pluginname, $enabled=true)
  {
  	
		$db			=& JFactory::getDBO();
		$query	= 'SELECT '.$db->nameQuote('published')
				.' FROM ' . $db->nameQuote( '#__plugins' )
	          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);

		$db->setQuery($query);		
		$actualState= (boolean) $db->loadResult();
		$this->assertEquals($actualState, $enabled);
  }
  
}
