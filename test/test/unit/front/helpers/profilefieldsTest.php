<?php

class XiptProfilefieldsHelperTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetPTypeNames()
	{
		// for PROFILE_FIELD_CATEGORY_ALLOWED
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(2, PROFILE_FIELD_CATEGORY_ALLOWED),'ProfileType1');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(3, PROFILE_FIELD_CATEGORY_ALLOWED),'ProfileType2');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(4, PROFILE_FIELD_CATEGORY_ALLOWED),'None');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(5, PROFILE_FIELD_CATEGORY_ALLOWED),'ProfileType1');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(7, PROFILE_FIELD_CATEGORY_ALLOWED),'All');

		// 	for PROFILE_FIELD_CATEGORY_REQUIRED
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(2, PROFILE_FIELD_CATEGORY_REQUIRED),'ProfileType1');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(3, PROFILE_FIELD_CATEGORY_REQUIRED),'ProfileType2');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(4, PROFILE_FIELD_CATEGORY_REQUIRED),'All');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(5, PROFILE_FIELD_CATEGORY_REQUIRED),'ProfileType2');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(7, PROFILE_FIELD_CATEGORY_REQUIRED),'All');
		
		// 	for PROFILE_FIELD_CATEGORY_VISIBLE
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(2, PROFILE_FIELD_CATEGORY_VISIBLE),'ProfileType1');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(3, PROFILE_FIELD_CATEGORY_VISIBLE),'ProfileType2');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(4, PROFILE_FIELD_CATEGORY_VISIBLE),'None');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(5, PROFILE_FIELD_CATEGORY_VISIBLE),'ProfileType1');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(7, PROFILE_FIELD_CATEGORY_VISIBLE),'All');
		
		// 	for PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(2, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),'ProfileType1');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(3, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),'ProfileType2');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(4, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),'ProfileType1');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(5, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),'ProfileType2');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(7, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),'All');
		
		// 	for PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(2, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),'ProfileType1');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(3, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),'ProfileType2');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(4, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),'ProfileType2');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(5, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),'All');
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeNames(7, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),'All');		
	}
	
	function testGetProfileTypeArray()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testGetPTypeNames.start.sql');

		// for PROFILE_FIELD_CATEGORY_ALLOWED
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(2, PROFILE_FIELD_CATEGORY_ALLOWED),array(1));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(3, PROFILE_FIELD_CATEGORY_ALLOWED),array(2));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(4, PROFILE_FIELD_CATEGORY_ALLOWED),array());
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(5, PROFILE_FIELD_CATEGORY_ALLOWED),array(1));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(7, PROFILE_FIELD_CATEGORY_ALLOWED),array(0));

		// 	for PROFILE_FIELD_CATEGORY_REQUIRED
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(2, PROFILE_FIELD_CATEGORY_REQUIRED),array(1));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(3, PROFILE_FIELD_CATEGORY_REQUIRED),array(2));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(4, PROFILE_FIELD_CATEGORY_REQUIRED),array(0));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(5, PROFILE_FIELD_CATEGORY_REQUIRED),array(2));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(7, PROFILE_FIELD_CATEGORY_REQUIRED),array(0));
		
		// 	for PROFILE_FIELD_CATEGORY_VISIBLE
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(2, PROFILE_FIELD_CATEGORY_VISIBLE),array(1));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(3, PROFILE_FIELD_CATEGORY_VISIBLE),array(2));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(4, PROFILE_FIELD_CATEGORY_VISIBLE),array());
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(5, PROFILE_FIELD_CATEGORY_VISIBLE),array(1));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(7, PROFILE_FIELD_CATEGORY_VISIBLE),array(0));
		
		// 	for PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(2, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),array(1));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(3, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),array(2));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(4, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),array(1));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(5, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),array(2));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(7, PROFILE_FIELD_CATEGORY_EDITABLE_AFTER_REG),array(0));
		
		// 	for PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(2, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),array(1));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(3, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),array(2));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(4, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),array(2));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(5, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),array(0));
		$this->assertEquals(XiptHelperProfilefields::getProfileTypeArray(7, PROFILE_FIELD_CATEGORY_EDITABLE_DURING_REG),array(0));		
	}
}