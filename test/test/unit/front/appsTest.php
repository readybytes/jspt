<?php
class AppsTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testNotAllowedCommunityAppsArray()
  {
  	//return array of appid for Profiletype 1
  	$appid = XiptLibApps::getNotAllowedCommunityAppsArray(1);
  	$result = array(42, 46, 48);
  	$this->assertEquals($appid, $result);
  	
  	//return array of appid for Profiletype 2
  	$appid = XiptLibApps::getNotAllowedCommunityAppsArray(2);
  	$result = array(45, 44, 47);
  	$this->assertEquals($appid, $result);
  	
  	//return array of appid for Profiletype 3
  	$appid = XiptLibApps::getNotAllowedCommunityAppsArray(3);
  	$result = array(42, 43, 47, 48);
  	$this->assertEquals($appid, $result);
  	
  	//return array of appid for Profiletype 4
  	$appid = XiptLibApps::getNotAllowedCommunityAppsArray(4);
  	$result = array(42, 47, 48);
  	$this->assertEquals($appid, $result);
  }
  
//  function testFilterCommunityApps()
//  {
//  	$dispatcher =& JDispatcher::getInstance();
//  	$app = $dispatcher->_observers;
//	$result = XiptLibApps::FilterCommunityApps($app, 1);
//	$this->assertEquals($result, true);
//	
//  }
  
  function testPluginId()
  {
	  	//retrun PluginId of element
	 $this->assertEquals(XiptLibApps::getPluginId('joomla', 'authentication'),1);
	  	
	 $this->assertEquals(XiptLibApps::getPluginId('sections', 'search'),9);
	 	
	 $this->assertEquals(XiptLibApps::getPluginId('tinymce', 'editors'),19);
	  	
	 $this->assertEquals(XiptLibApps::getPluginId('legacy', 'system'),29);
	  	
	 $this->assertEquals(XiptLibApps::getPluginId('weblinks', 'search'),11);
	  	
	 $this->assertEquals(XiptLibApps::getPluginId('contacts', 'search'),7);
	 
  }
  
  function testFilterAjaxAddApps()
  {
  	$element = 'feeds';
  	$profiletype = 1; 
  	$objResponse = 'joomla';
 	$this->assertEquals(XiptLibApps::filterAjaxAddApps($element, $profiletype, $objResponse),true);
  }
 
}