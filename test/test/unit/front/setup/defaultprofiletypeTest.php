<?php
class DefaultprofiletypeTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testIsApplicable()
	{
		//#case 1: when profiletype doesn't exist
	  	$obj = new XiptSetupRuleDefaultprofiletype();
	  	$this->truncateProfiletypes();
	  	$this->assertFalse($obj->isApplicable());
	  	
	  	//#case 2: when profiletype exists
	  	$this->insertProfiletypes();
	  	$this->assertTrue($obj->isApplicable());
	}
	
	function truncateProfiletypes()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/truncateProfiletypes.start.sql');
	}
	
	function insertProfiletypes()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/insertProfiletypes.start.sql');
	}
	
	function testDoRevert()
	{
	  	$obj = new XiptSetupRuleDefaultprofiletype();
	  	$this->assertTrue($obj->doRevert());
	}
	
	function testIsRequired()
	{
		$obj = new XiptSetupRuleDefaultprofiletype();
		
		XiptLibJomsocial::cleanStaticCache(true);
		//#case 1: when defaultPT doen't exist
		$this->truncateSettings();
		$this->assertTrue($obj->isRequired());
		
		XiptLibJomsocial::cleanStaticCache(true);
		//#case 2: when defaultPT exists, but it is not valid PT
		$this->insertSettings();
		$this->truncateProfiletypes();
		$this->assertTrue($obj->isRequired());
		
		XiptLibJomsocial::cleanStaticCache(true);
		//#case 3: when defaultPT exists and it is valid PT
		$this->insertSettings();
		$this->assertFalse($obj->isRequired());
	}
	
	function truncateSettings()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/truncateSettings.start.sql');
	}
	
	function insertSettings()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/insertSettings.start.sql');
	}
}