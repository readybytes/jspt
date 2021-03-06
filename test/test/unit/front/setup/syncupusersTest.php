<?php
class SyncupusersTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testIsRequired()
	{
		//#case 1: when custom field doesn't exist
		$obj = new XiptSetupRuleSyncupusers();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/truncateCommunityFields.start.sql');
		$this->assertTrue($obj->isRequired());
		
		//#case 2: when all users are already syncedup
		$obj = new XiptSetupRuleSyncupusers();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testIsRequired.start.sql');
		$this->assertFalse($obj->isRequired());
		
		//#case 3: when there are users to sync up
		$obj = new XiptSetupRuleSyncupusers();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testGetUsertoSyncUp.start.sql');
		$this->assertTrue($obj->isRequired());
	}
	
	function testGetUsertoSyncUp()
	{
		$obj = new XiptSetupRuleSyncupusers();
		//users 79, 80 are not in xipt_users table and 81's PT is not valid
		$result = array(79, 80, 81);
		$this->assertEquals($obj->getUsertoSyncUp(), $result);
	}
	
	function testSyncUpUserPT()
	{
		JFactory::getConfig()->setValue('debug', 0);
		//#case 1: when custom field doesn't exist
		$obj = new XiptSetupRuleSyncupusers();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/truncateCommunityFields.start.sql');
		$this->assertFalse($obj->syncUpUserPT(0, 10));
		
		//#case 2: sync up users
		$obj = new XiptSetupRuleSyncupusers();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testSyncUpUserPT.start.sql');
		$this->assertTrue($obj->syncUpUserPT(0, 10, true));
		$this->_DBO->addTable('#__xipt_users');
		JFactory::getConfig()->setValue('debug', 1);
	}
}