<?php
//Require File in Joomla 1.5 
if(JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'community'.DS.'xipt_community.php'))
require_once (JPATH_ROOT.DS.'plugins'.DS.'community'.DS.'xipt_community.php');	
//Require File in Joomla 1.6 
if(JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'community'.DS.'xipt_community'.DS.'xipt_community.php'))
require_once (JPATH_ROOT.DS.'plugins'.DS.'community'.DS.'xipt_community'.DS.'xipt_community.php');	


class XiptCommunityPluginTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testOnAfterProfileUpdate()
	{	
		$mainframe = JFactory::getApplication();

		$filter['debug']=0;
		$this->updateJoomlaConfig($filter);
		
		$mainframe = JFactory::getApplication();
		$this->changePluginState('aecuser', 0);
		$this->changePluginState('aecaccess', 0);
		if(TEST_XIPT_JOOMLA_15){
			JDispatcher::getInstance()->_observers= array();
		}
		if(TEST_XIPT_JOOMLA_16){
			JDispatcher::getInstance()->set('_observers',array());
		}
		JPluginHelper::importPlugin('system');
		$subject = JDispatcher::getInstance();
		$obj = new plgCommunityxipt_community($subject, array());
		
		//#case 1: data was not saved, do nothing
		$this->assertTrue($obj->onAfterProfileUpdate(87, false));
		
		//#case 2: data saved
		
		$this->assertTrue($obj->onAfterProfileUpdate(84, true));
		$this->changePluginState('aecuser', 1);
		$this->changePluginState('aecaccess', 1);
		if(TEST_XIPT_JOOMLA_15){
			JDispatcher::getInstance()->_observers= array();
		}
		if(TEST_XIPT_JOOMLA_16){
			JDispatcher::getInstance()->set('_observers',array());
		}
		JPluginHelper::importPlugin('system');
		
		$filter['debug']=1;
		$this->updateJoomlaConfig($filter);	
	
		$this->_DBO->addTable('#__xipt_users');
	}
	
//	function testOnProfileCreate()
//	{
//		$subject = JDispatcher::getInstance();
//		$obj = new plgCommunityxipt_community($subject, array());
//	}
	
}