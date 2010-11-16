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
		$this->assertTrue(XiptHelperRegistration::checkIfUsernameAllowed($uname,1));
		$this->assertTrue(XiptHelperRegistration::checkIfUsernameAllowed($uname,2));
		
		$this->assertFalse(XiptHelperRegistration::checkIfUsernameAllowed('admin',2));
		$this->assertFalse(XiptHelperRegistration::checkIfUsernameAllowed('moderator',2));
		$this->assertTrue(XiptHelperRegistration::checkIfUsernameAllowed('moderator',1));

		// test with space
		$this->assertTrue(XiptHelperRegistration::checkIfUsernameAllowed('  moderator  ',1));
		$this->assertFalse(XiptHelperRegistration::checkIfUsernameAllowed('  moderator  ',2));
	}
	
	function testAjaxCheckEmail()
	{	
		$this->assertTrue(XiptHelperRegistration::checkIfEmailAllowed('admin@yahoo.com',1));
		$this->assertFalse(XiptHelperRegistration::checkIfEmailAllowed('admin@yaahoo.com',1));
		$this->assertFalse(XiptHelperRegistration::checkIfEmailAllowed('moderator@gmail.com',1));

		$this->assertFalse(XiptHelperRegistration::checkIfEmailAllowed('admin@yahoo.com',2));
		$this->assertFalse(XiptHelperRegistration::checkIfEmailAllowed('admin@yaahoo.com',2));
		$this->assertTrue(XiptHelperRegistration::checkIfEmailAllowed('moderator@gmail.com',2));		
		
		$this->assertFalse(XiptHelperRegistration::checkIfEmailAllowed('admin@yahoo.com',3));
		$this->assertTrue(XiptHelperRegistration::checkIfEmailAllowed('admin@yaahoo.com',3));
		$this->assertTrue(XiptHelperRegistration::checkIfEmailAllowed('moderator@gmail.com',3));
		
		$this->assertFalse(XiptHelperRegistration::checkIfEmailAllowed('admin@yaahoo.com',4));
		$this->assertTrue(XiptHelperRegistration::checkIfEmailAllowed('admin@yahoo.com',4));
		$this->assertTrue(XiptHelperRegistration::checkIfEmailAllowed('moderator@gmail.com',4));
		
		// test with space in emailid
		$this->assertFalse(XiptHelperRegistration::checkIfEmailAllowed('admin@yaahoo.com ',4));
		$this->assertTrue(XiptHelperRegistration::checkIfEmailAllowed('  admin@yahoo.com  ',4));
		$this->assertFalse(XiptHelperRegistration::checkIfEmailAllowed(' admin@yahoo.com',3));
		$this->assertFalse(XiptHelperRegistration::checkIfEmailAllowed(' admin@yahoo.com ',2));
		 
	}
}