<?php
class JsfieldsTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testIsApplicable()
	{
		$obj = new XiptSetupRuleJsfields();
		$this->assertTrue($obj->isApplicable());
	}

	function testEnableField()
	{
		$obj = new XiptSetupRuleJsfields();
		$this->assertTrue($obj->_switchFieldState(1));
		$this->_DBO->addTable('#__community_fields');
		$this->_DBO->filterColumn('#__community_fields','id');
	}

	function testCreateCustomField()
	{
		$obj = new XiptSetupRuleJsfields();

		//#case 1: create profiletype field
		$obj->createCustomField(PROFILETYPE_CUSTOM_FIELD_CODE);

		//#case 2: create template field
		$obj->createCustomField(TEMPLATE_CUSTOM_FIELD_CODE);
		$this->_DBO->addTable('#__community_fields');
		$this->_DBO->filterColumn('#__community_fields','id');
	}

	function testCheckExistance()
	{
		$obj = new XiptSetupRuleJsfields();

		$this->assertEquals(count($obj->_checkExistance()), 2);
	}

	function testDoRevert()
	{
		$obj = new XiptSetupRuleJsfields();
		$this->assertTrue($obj->doRevert());
		$this->_DBO->addTable('#__community_fields');
		$this->_DBO->filterColumn('#__community_fields','id');
	}

	function truncateCommunityFields()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/truncateCommunityFields.start.sql');
	}

	function insert()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/insert.start.sql');
	}

	function testIsRequired()
	{
		$obj = new XiptSetupRuleJsfields();

		//#case 1: when fields don't exist
		$this->truncateCommunityFields();
		$this->assertTrue($obj->isRequired());

		//#case 2: when only one field exist
		$this->insert();
		$this->assertTrue($obj->isRequired());

		//#case 3: when both fields exist but not enabled
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testEnableField.start.sql');
		$this->assertTrue($obj->isRequired());

		//#case 4: when both fields exist and enabled
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testCheckExistance.start.sql');
		$this->assertFalse($obj->isRequired());
	}
}