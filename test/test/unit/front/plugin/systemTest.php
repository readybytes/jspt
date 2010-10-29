<?php
require_once (JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'xipt_system.php');	
class XiptSystemPluginTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testOnAfterStoreUser()
	{
		$subject = JDispatcher::getInstance();
		$obj = new plgSystemxipt_system($subject, array());
		
		//#case 1: clean session if $isNew =false or $result =false or $error =true
		$user = array('id'=> 99);
		$mySess = JFactory::getSession();
		$mySess->clear('SELECTED_PROFILETYPE_ID','XIPT');
		$mySess->set('SELECTED_PROFILETYPE_ID', 1, 'XIPT');
		$this->assertTrue($obj->onAfterStoreUser($user, false, true, true));
		$this->assertEquals($mySess->get('SELECTED_PROFILETYPE_ID'), null);
		
		//#case 2: clean session and update user data
		$mySess->set('SELECTED_PROFILETYPE_ID', 3, 'XIPT');
		$this->assertTrue($obj->onAfterStoreUser($user, true, true, false));
		$this->assertEquals($mySess->get('SELECTED_PROFILETYPE_ID'), null);
		$this->_DBO->addTable('#__xipt_users');
	}
	
	function testOnAfterDeleteUser()
	{
		$subject = JDispatcher::getInstance();
		$obj = new plgSystemxipt_system($subject, array());
		
		$user = array('id'=> 81);
		// error cases
		$this->assertTrue($obj->onAfterDeleteUser($user, false, false));
		$this->assertTrue($obj->onAfterDeleteUser($user, false, true));
		
		// normal case
		$this->assertTrue($obj->onAfterDeleteUser($user, true, false));
		$this->_DBO->addTable('#__xipt_users');
	}
	
	function testOnBeforeProfileTypeSelection()
	{
		$subject = JDispatcher::getInstance();
		$obj = new plgSystemxipt_system($subject, array());
		
		//#case 1: when profiletype is not set in session & reset is false
		JRequest::clean();
		$this->assertTrue($obj->onBeforeProfileTypeSelection());
				
		//#case 2: when profiletype is set in session & reset is true
		JRequest::setVar('ptypeid',1, 'REQUEST');
		JRequest::setVar('reset',true, 'REQUEST');		
		$this->assertTrue($obj->onBeforeProfileTypeSelection());
		$mySess = JFactory::getSession();
		$this->assertEquals(JRequest::getVar('ptypeid'), $mySess->get('ptypeid'));
		
	}
	
	function testOnAfterProfileTypeChange()
	{
		$subject = JDispatcher::getInstance();
		$obj = new plgSystemxipt_system($subject, array());
		$this->assertFalse($obj->onAfterProfileTypeChange(1, true));
		
	}
	
	function testOnBeforeProfileTypeChange()
	{
		$subject = JDispatcher::getInstance();
		$obj = new plgSystemxipt_system($subject, array());
		$this->assertFalse($obj->onBeforeProfileTypeChange(array()));
	}
	
	function testEvent_com_xipt_registration_blank()
	{
		$subject = JDispatcher::getInstance();
		$obj = new plgSystemxipt_system($subject, array());
		
		$aecFront = JPATH_ROOT . DS . 'components' . DS . 'com_acctexp';
 		$this->assertTrue(JFolder::exists($aecFront));
 	
  		JFolder::move('com_acctexp', 'com_acctexp11', JPATH_ROOT . DS . 'components');
  		$this->assertFalse(JFolder::exists($aecFront));
		$this->assertFalse($obj->event_com_xipt_registration_blank());
		
		JFolder::move('com_acctexp11', 'com_acctexp', JPATH_ROOT . DS . 'components');
  		$this->assertTrue(JFolder::exists($aecFront));
	}
	
	function testOnAfterRoute()
	{
		$subject = JDispatcher::getInstance();
		$obj = new plgSystemxipt_system($subject, array());
		$this->assertFalse($obj->onAfterRoute());
	}
	
	function testEvent_com_acctexp_blank_subscribe()
	{
		$subject = JDispatcher::getInstance();
		$obj = new plgSystemxipt_system($subject, array());
		$mySess = JFactory::getSession();
		
		//#case 1: when usage is not set
		$obj->event_com_acctexp_blank_subscribe();
		$this->assertEquals($mySess->get('usage'), null);
		
		//#case 2: when usage is set
		JRequest::setVar('usage',1, 'REQUEST');
		$obj->event_com_acctexp_blank_subscribe();
		
		$this->assertEquals(JRequest::getVar('usage'), $mySess->get('AEC_REG_PLANID'));
	}
	
	function testEvent_com_community_profile_blank()
	{
		$subject = JDispatcher::getInstance();
		$obj = new plgSystemxipt_system($subject, array());
		$this->assertTrue($obj->event_com_community_profile_blank());
		
		$mySess = JFactory::getSession();
		$mySess->set('FROM_FACEBOOK', true, 'XIPT');
		$this->assertTrue($obj->event_com_community_profile_blank());
		$this->assertEquals($mySess->get('FROM_FACEBOOK'), null);
	}
	
}