<?php
class CreateprofiletypesTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testIsRequired()
	{
		//#case 1: when profiletype doesn't exist
		$obj = new XiptSetupRuleCreateprofiletypes();
		$this->truncate();
		$this->assertTrue($obj->isRequired());
		
		//#case 2: when profiletype exists
		$this->insert();
		$this->assertFalse($obj->isRequired());
	}
	
	function truncate()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/truncate.start.sql');
	}
	
	function insert()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/insert.start.sql');
	}
	
	function testIsApplicable()
	{
	  	$obj = new XiptSetupRuleCreateprofiletypes();
	  	$this->assertTrue($obj->isApplicable());
	}
	
  	function testDoRevert()
	{
	  	$obj = new XiptSetupRuleCreateprofiletypes();
	  	$this->assertTrue($obj->doRevert());
	}
}