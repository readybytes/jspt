<?php 

class XiptJomsocialHelperTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetTemplatesList()
	{
		$template = array('default', 'blackout', 'bubble', 'blueface');
		$this->assertEquals(XiptHelperJomsocial::getTemplatesList(),$template);
	}
	
	function testGetReturnURL()
	{
		//$this->assertTR(XiptHelperJomsocial::getReturnURL(),'');
	}
	
	function testGetFieldId()
	{
		$this->assertEquals(XiptHelperJomsocial::getFieldId(PROFILETYPE_CUSTOM_FIELD_CODE), 4);
		
		$this->assertEquals(XiptHelperJomsocial::getFieldId(TEMPLATE_CUSTOM_FIELD_CODE), 3);
	}
}