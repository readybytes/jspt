<?php
require_once (JPATH_ROOT.DS.'plugins'.DS.'community'.DS.'xipt_community.php');	

class XiptCommunityPluginTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testOnAfterProfileUpdate()
	{	
		global $mainframe;
		$mainframe = JFactory::getApplication();
		$this->changePluginState('aecuser', 0);
		$this->changePluginState('aecaccess', 0);
		
		JDispatcher::getInstance()->_observers= array();
		JPluginHelper::importPlugin('system');
		$subject = JDispatcher::getInstance();
		$obj = new plgCommunityxipt_community($subject, array());
		
		//#case 1: data was not saved, do nothing
		$this->assertTrue($obj->onAfterProfileUpdate(87, false));
		
		//#case 2: data saved
		
		$this->assertTrue($obj->onAfterProfileUpdate(84, true));
		$this->changePluginState('aecuser', 1);
		$this->changePluginState('aecaccess', 1);
		
		JDispatcher::getInstance()->_observers= array();
		JPluginHelper::importPlugin('system');
		
		$this->_DBO->addTable('#__xipt_users');
	}
	
//	function testOnProfileCreate()
//	{
//		$subject = JDispatcher::getInstance();
//		$obj = new plgCommunityxipt_community($subject, array());
//	}
	
}