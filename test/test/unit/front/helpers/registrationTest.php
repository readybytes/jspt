<?php

class XiptRegistrationHelperTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testAjaxCheckUsername()
	{
		$uname = 'username'.rand(111111,999999);
		$this->assertTrue(XiptHelperRegistration::checkIfUsernameAllowed($uname));
		//$this->assert(XiptHelperRegistration::checkIfUsernameAllowed('admin'));
	}
}