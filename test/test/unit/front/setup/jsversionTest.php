<?php
class JsversionTest extends XiUnitTestCase 
{
	function testIsApplicable()
	{
		$obj = new XiptSetupRuleJsversion();
		$this->assertFalse($obj->isApplicable());
	}
}