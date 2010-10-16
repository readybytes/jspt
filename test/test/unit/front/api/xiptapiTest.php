<?php
require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'api.xipt.php';
class XiptapiTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetUserProfiletype()
	{
		//#case 1 :get PT id of user 87, by default this fn returns PT id
		$this->assertEquals(XiptAPI::getUserProfiletype(87), 3);
		
		//#case 2 :get PT name of user 87,this fn returns PT id or PT name
		$this->assertEquals(XiptAPI::getUserProfiletype(87, 'name'), 'PROFILETYPE-3');
		
		//get PT id of user 79, by default this fn returns PT id
		$this->assertEquals(XiptAPI::getUserProfiletype(79), 1);
		
		//get PT id of user 79, this fn returns PT id or PT name
		$this->assertEquals(XiptAPI::getUserProfiletype(79, 'name'), 'PROFILETYPE-1');
	}
	
	function testSetUserProfiletype()
	{
		//#case 1: update user PTData, by default it will update all data
		$this->assertTrue(XiptAPI::setUserProfiletype(79, 2));
		
		//#case 2: update user PTData, it will update jusertype as per PT
		$this->assertTrue(XiptAPI::setUserProfiletype(80, 1, 'jusertype'));
		
		$this->_DBO->addTable('#__xipt_users');
		$this->_DBO->addTable('#__community_users');
		$this->_DBO->addTable('#__users');
	}
	
	function testGetProfiletypeInfo()
	{
		//#case 1:When no PT is available
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testGetProfiletypeInfo1.start.sql');
		$this->assertEquals(XiptAPI::getProfiletypeInfo(1), null);
		
		//#case 2:When no PT id is given, return all PTs info
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testGetProfiletypeInfo2.start.sql');
		
		$obj1 					= new stdClass();
	  	$obj1->id 				= 1;
	    $obj1->name 			= 'PROFILETYPE-1';
	    $obj1->ordering 		= 2;
	    $obj1->published 		= 1;
	    $obj1->tip 				= 'PROFILETYPE-ONE-TIP';
	    $obj1->privacy 			= 'public';
	    $obj1->template 		= 'default';
	    $obj1->jusertype 		= 'Registered';
	    $obj1->avatar			= 'components/com_community/assets/default.jpg';
	    $obj1->approve 			= 0;
	    $obj1->allowt 			= 0;
	    $obj1->group 			= 1;
	    $obj1->watermark 		= '';
	    $obj1->params 			= '';
	    $obj1->watermarkparams 	= '';
	    $obj1->visible 			= 1;
	    $obj1->config 			= '';
	    
	    $obj2 					= new stdClass();
	  	$obj2->id 				= 2;
	    $obj2->name 			= 'PROFILETYPE-2';
	    $obj2->ordering 		= 1;
	    $obj2->published 		= 1;
	    $obj2->tip 				= 'PROFILETYPE-TWO-TIP';
	    $obj2->privacy 			= 'friends';
	    $obj2->template 		= 'blueface';
	    $obj2->jusertype 		= 'Editor';
	    $obj2->avatar 			= 'components/com_community/assets/group.jpg';
	    $obj2->approve 			= 0;
	    $obj2->allowt 			= 0;
	    $obj2->group 			= 0;
	    $obj2->watermark 		= '';
	    $obj2->params 			= '';
	    $obj2->watermarkparams 	= '';
	    $obj2->visible 			= 1;
	    $obj2->config 			= '';
	     
		$result = array($obj2, $obj1);
		$this->assertEquals(XiptAPI::getProfiletypeInfo(), $result);
		
		//#case 3:When PT id is < 0 , return all PTs info
		$result = array($obj2, $obj1);
		$this->assertEquals(XiptAPI::getProfiletypeInfo(), $result);
		
		//#case 4:When PT id is given , return specific PT's info
		$result = array($obj2);
		$this->assertEquals(XiptAPI::getProfiletypeInfo(2), $result);
		
		//#case 5:When invalid PT id is given , return null
		$this->assertEquals(XiptAPI::getProfiletypeInfo(8), null);
	}
	
	function testGetDefaultProfiletype()
	{
		$this->assertEquals(XiptAPI::getDefaultProfiletype(), 1);
	}
	
	function testGetUserInfo()
	{
		//#case 1:by default it will return PT of given user
		$this->assertEquals(XiptAPI::getUserInfo(87), 3);
		
		//#case 2:it will return PT of given user
		$this->assertEquals(XiptAPI::getUserInfo(83, 'PROFILETYPE'), 2);
		
		//#case 3:it will return template of given user
		$this->assertEquals(XiptAPI::getUserInfo(80, 'TEMPLATE'), 'blueface');
	}
	
	function testGetGlobalConfig()
	{
		//#case 1:when no parameter is passed, this fn will return null
		$this->assertEquals(XiptAPI::getGlobalConfig(), null);
		
		//#case 2:it will return param's global value
		$this->assertEquals(XiptAPI::getGlobalConfig('show_watermark'), 1);
		
		$this->assertEquals(XiptAPI::getGlobalConfig('aec_integrate'), 1);
	}
}