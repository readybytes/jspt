<?php

class XiptAppsHelperTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetPTypeNames()
	{
		$this->assertEquals(XiptHelperApps::getProfileTypeNames(44),'ProfileType1');
		$this->assertEquals(XiptHelperApps::getProfileTypeNames(45),'ProfileType2');
		$this->assertEquals(XiptHelperApps::getProfileTypeNames(46),'None');
		$this->assertEquals(XiptHelperApps::getProfileTypeNames(47),'All');		
	}
	
	function testGetProfileTypeArray()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testGetPTypeNames.start.sql');
		$this->assertEquals(XiptHelperApps::getProfileTypeArray(44),array(1));
		$this->assertEquals(XiptHelperApps::getProfileTypeArray(45),array(2));
		$this->assertEquals(XiptHelperApps::getProfileTypeArray(46),array());
		$this->assertEquals(XiptHelperApps::getProfileTypeArray(47),array(0));
	}
}