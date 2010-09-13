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
  	$appid = XiPTLibraryApps::getNotAllowedCommunityAppsArray(1);
  	$result = array(42, 46, 48);
  	$this->assertEquals($appid, $result);
  	
  	//return array of appid for Profiletype 2
  	$appid = XiPTLibraryApps::getNotAllowedCommunityAppsArray(2);
  	$result = array(45, 44, 47);
  	$this->assertEquals($appid, $result);
  	
  	//return array of appid for Profiletype 3
  	$appid = XiPTLibraryApps::getNotAllowedCommunityAppsArray(3);
  	$result = array(42, 43, 47, 48);
  	$this->assertEquals($appid, $result);
  	
  	//return array of appid for Profiletype 4
  	$appid = XiPTLibraryApps::getNotAllowedCommunityAppsArray(4);
  	$result = array(42, 47, 48);
  	$this->assertEquals($appid, $result);
  }
  
//  function testFilterCommunityApps()
//  {
//  	$dispatcher =& JDispatcher::getInstance();
//  	$app = $dispatcher->_observers;
//	$result = XiPTLibraryApps::FilterCommunityApps($app, 1);
//	$this->assertEquals($result, true);
//	
//  }
  
  function testPluginId()
  {
	  	//retrun PluginId of element
	 $this->assertEquals(XiPTLibraryApps::getPluginId('joomla', 'authentication'),1);
	  	
	 $this->assertEquals(XiPTLibraryApps::getPluginId('sections', 'search'),9);
	 	
	 $this->assertEquals(XiPTLibraryApps::getPluginId('tinymce', 'editors'),19);
	  	
	 $this->assertEquals(XiPTLibraryApps::getPluginId('legacy', 'system'),29);
	  	
	 $this->assertEquals(XiPTLibraryApps::getPluginId('weblinks', 'search'),11);
	  	
	 $this->assertEquals(XiPTLibraryApps::getPluginId('contacts', 'search'),7);
	 
  }
  
  function testFilterAjaxAddApps()
  {
  	$element = 'feeds';
  	$profiletype = 1; 
  	$objResponse = 'joomla';
 	$this->assertEquals(XiPTLibraryApps::filterAjaxAddApps($element, $profiletype, $objResponse),true);
  }
 
}