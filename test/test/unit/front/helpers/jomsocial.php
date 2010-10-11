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
}