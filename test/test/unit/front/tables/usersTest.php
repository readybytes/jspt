<?php

//require_once(JPATH_ROOT.DS.'components'.DS.'com_xiec'.DS.'libraries'.DS.'base'.DS.'table.php');

class XiptUsersTableTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testStore()
	{
		$table  = new XiptTableUsers();

		// store new data
		$table->userid 		= 65;
		$table->profiletype = 3;
		$table->template 	= 'blueface';		
		$table->store();
		
		// update existing data
		$table->userid 		= 63;
		$table->profiletype = 3;
		$table->template 	= 'blackout';		
		$table->store();

		$this->_DBO->addTable('#__xipt_users');
	}
	
	function testIsRowExists()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testStore.start.sql');
		$table  = new XiptTableUsers();
		
		$obj = new stdClass();
		$obj->userid 		= 63;
		$obj->profiletype	= 2;
		$obj->template 		= 'bubble';
		
		$this->assertEquals($table->isRowExists(65),null);		
		$this->assertEquals($table->isRowExists(63),$obj);
		
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testStore.end.sql');		
	}
}
