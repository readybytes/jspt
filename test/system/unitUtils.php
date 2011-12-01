<?php
require_once 'PHPUnit/Framework.php';

class XiUnitTestCase extends PHPUnit_Framework_TestCase 
{
  var  $_DBO;
  function setUp()
  {
  	//$this->parentSetup();
  	$this->resetCacheData();
  	$this->cleanStaticCache();
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
  
  function updateJoomlaConfig($filter)
  {
  		$config =& JFactory::getConfig();		
  		foreach($filter as $key=>$value)
  			$config->setValue($key,$value);
  		
		jimport('joomla.filesystem.file');
		$fname = JPATH_CONFIGURATION.DS.'configuration.php';
		system("sudo chmod 777 $fname");
			
		$configString = '';
		if(TEST_XIPT_JOOMLA_17){
			$configString = $config->toString('PHP', array('class' => 'JConfig', 'closingtag' => false));
		}elseif(TEST_XIPT_JOOMLA_15){
			$configString  = $config->toString('PHP', 'config', array('class' => 'JConfig'));
		}else {
			assert(0);
		}
		
  		if(!JFile::write($fname,$configString)) 
		{
			echo JText::_('ERRORCONFIGFILE');
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
	$allData = $newParams->toArray(); 
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
	$allData = $newParams->toArray(); 
	foreach ($allData as $key => $value)
		$paraStr .= "$key=$value\n";
		
	$query = "UPDATE `#__xipt_settings` SET `params`='".$paraStr."' WHERE `name`='settings' ";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$db->query();
  	
	$done=true;
  }
  
  function resetCacheData()
  {
  	 $sModel = XiptFactory::getInstance('settings','model');
	 $params  = $sModel->getParams();
	 XiptLibJomsocial::cleanStaticCache(true);
  }
  
  function cleanWhiteSpaces($str)
  {
	 $str = preg_replace('#[\\n\\b\\s\\t]+#','' , $str);
	 return $str;
  }
	
  function changePluginState($pluginname, $action=1)
  {
  	
		$db		= JFactory::getDBO();
		if(TEST_XIPT_JOOMLA_15){
			$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
			. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);
		}
		else{
			$query	= 'UPDATE ' . $db->nameQuote( '#__extensions' )
			. ' SET '.$db->nameQuote('enabled').'='.$db->Quote($action)
          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);
		}
		$db->setQuery($query);		
		
		if(!$db->query())
			return false;
			
		return true;
  }
	
	function cleanStaticCache()
	{
		XiptLibJomsocial::cleanStaticCache(true);
	}
   	//Remove caching data
   	function reloadUser($userId = array())
   	{
   		foreach($userId as $id)
   			$bogus=XiptLibJomsocial::reloadCUser($id);
   	}
}