<?php
class WatermarkTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testIsApplicable()
	{
		$obj = new XiptSetupRuleWatermark();
		$this->assertTrue($obj->isApplicable());
	}
	
	function testIsRequired()
	{
		//#case 1: when global watermark is set
		$obj = new XiptSetupRuleWatermark();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testIsRequired2.start.sql');
		$this->assertFalse($obj->isRequired());
		
		//#case 2: when global watermark and watermarkparams are not set 
		$obj = new XiptSetupRuleWatermark();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testIsRequired1.start.sql');
		$this->assertFalse($obj->isRequired());
		
		//#case 3: when global watermark is not set and watermarkparams are set 
		$obj = new XiptSetupRuleWatermark();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testIsRequired.start.sql');
		$this->assertTrue($obj->isRequired());
	}
}