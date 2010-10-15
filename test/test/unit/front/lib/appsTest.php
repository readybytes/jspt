<?php

class dummyOPD
{
	function onProfileDisplay()
	{}
}
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
  	$result = array(44, 48, 50);
  	$this->assertEquals($appid, $result);
  	
  	//return array of appid for Profiletype 2
  	$appid = XiptLibApps::getNotAllowedCommunityAppsArray(2);
  	$result = array(47, 46, 49);
  	$this->assertEquals($appid, $result);
  	
  	//return array of appid for Profiletype 3
  	$appid = XiptLibApps::getNotAllowedCommunityAppsArray(3);
  	$result = array(44, 45, 49, 50);
  	$this->assertEquals($appid, $result);
  	
  	//return array of appid for Profiletype 4
  	$appid = XiptLibApps::getNotAllowedCommunityAppsArray(4);
  	$result = array(44, 49, 50);
  	$this->assertEquals($appid, $result);
  }
  
  function testFilterCommunityApps()
  {
  	
  	//case #1 : when apps is blank array
	$apps = array();
	$result = array();
	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 2));
	$this->assertEquals($result, $apps);
  	
	// case #2 : do not work on arrays
	$apps = array( array(5, 'sample'));
	$result = array( array(5, 'sample'));
	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 2));
	$this->assertEquals($result, $apps);
	
	
	// case #3 do not work on non-community plugins
  	$obj1 = new stdClass();
	$obj1->_type = 'system';
	$obj1->_name = 'xipt_system';
	
	$apps = array($obj1);
	$result = array($obj1);
	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 2));
	$this->assertEquals($result, $apps);
	
	
	// case #4 community but xipt_community, then also do not work
	$obj2 = new stdClass();
	$obj2->_type = 'community';
	$obj2->_name = 'xipt_community';
	
	$apps = array($obj2);
	$result = array($obj2);
	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 2));
	$this->assertEquals($result, $apps);
	
	// case #5 
	$obj3 = new stdClass();
	$obj3->_type = 'community';
	$obj3->_name = 'walls';
	
	$obj4 = new dummyOPD();
	$obj4->_type = 'community';
	$obj4->_name = 'walls';
	
	//#5-1 OnProfileDisplay=false, $blockProfileApps=true
	$apps = array($obj3);
	$result = array($obj3);
	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 1));
	$this->assertEquals($result, $apps);
	
	//#5-2 OnProfileDisplay=false, $blockProfileApps=false
	$apps = array($obj3);
	$result = array();
	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 1, false));
	$this->assertEquals($result, $apps);
	
	//#5-3 OnProfileDisplay=true, $blockProfileApps=true
	$apps = array($obj4);
	$result = array();
	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 1));
	$this->assertEquals($result, $apps);
	
	//#5-4 OnProfileDisplay=true, $blockProfileApps=false
	$apps = array($obj4);
	$result = array($obj4);
	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 1, false));
	$this->assertEquals($result, $apps);
	
	
	
	// # Case 6, is given apps allowed
	$obj4 = new dummyOPD();
	$obj4->_type = 'community';
	$obj4->_name = 'walls';
		//only allowed to profiletype-2
		$apps = array($obj4);
		$result = array($obj4);
	  	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 2));
		$this->assertEquals($result , $apps);

		// not allowed to profiletype-1
		$apps = array($obj4);
		$result = array();
	  	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 1));
		$this->assertEquals($result , $apps);
	
	// case #7
	$obj3 = new dummyOPD();
	$obj3->_type = 'community';
	$obj3->_name = 'groups';
	
	$obj4 = new dummyOPD();
	$obj4->_type = 'community';
	$obj4->_name = 'walls';
	
	$apps = array($obj3,$obj4);
	$result = array($obj4);
  	$this->assertTrue(XiptLibApps::FilterCommunityApps(&$apps, 2));
	$this->assertEquals($result , $apps);
		
  }
  
  function testPluginId()
  {
	 //valid searches retrun PluginId of element
	 $this->assertEquals(XiptLibApps::getPluginId('joomla', 'authentication'),1);
	 $this->assertEquals(XiptLibApps::getPluginId('legacy', 'system'),29);	 
	 
	 // invalid search
	 $this->assertEquals(XiptLibApps::getPluginId('joomla', 'stupid'),false);
	 
	 // cached search
	 $this->assertEquals(XiptLibApps::getPluginId('legacy', 'system'),29);
	 $this->assertEquals(XiptLibApps::getPluginId('joomla', 'stupid'),false);
	 

  }
  
  function testFilterAjaxAddApps()
  {
  	$element = 'feeds';
  	$profiletype = 1; 
  	$objResponse = 'joomla';
 	$this->assertEquals(XiptLibApps::filterAjaxAddApps($element, $profiletype, $objResponse),true);
  }
 
}