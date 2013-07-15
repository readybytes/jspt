<?php
class AecTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testGetProfiletypeInfoFromAEC()
  {
  		//default params
  		$param 					= array();
		$param['profiletype'] 	= 1;
		$param['plan'] 			= '';
		$param['planid'] 		= 0;
		$param['planSelected'] 	= false;
		
		//when session and usages are not set.
	  	$this->assertEquals(XiptLibAec::getProfiletypeInfoFromAEC(), $param);
	  	
	  	$mySess = JFactory::getSession();
	  	$mySess->set('AEC_REG_PLANID', 4 ,'XIPT');
  	
  	    $param 					= array();
		$param['profiletype'] 	= 3;
		$param['plan'] 			= 'AEC Plan 002 (ID 4)';
		$param['planid'] 		= 4;
		$param['planSelected'] 	= true;
		
		//when session is set and usages is not set.
		$this->assertEquals(XiptLibAec::getProfiletypeInfoFromAEC(), $param);
		
		//default params
  		$param 					= array();
		$param['profiletype'] 	= 3;
		$param['plan'] 			= 'AEC Plan 002 (ID 4)';
		$param['planid'] 		= 4;
		$param['planSelected'] 	= true;
		
		//when session is not set and usage is set.
	  	$this->assertEquals(XiptLibAec::getProfiletypeInfoFromAEC(4), $param);
	  	
	  	$mySess = JFactory::getSession();
	  	$mySess->set('AEC_REG_PLANID', 2 ,'XIPT');
  		
  	    $param 					= array();
		$param['profiletype'] 	= 3;
		$param['plan'] 			= 'AEC Plan 002 (ID 4)';
		$param['planid'] 		= 4;
		$param['planSelected'] 	= true;
		
		//when session and usages are set.
		$this->assertEquals(XiptLibAec::getProfiletypeInfoFromAEC(4), $param);
  }
  
  function testGetPlanName()
  {
  	$planid   = array(1, 2, 4, 5, 13);
  	$planName = array('INVALID PLAN', 'AEC Plan 001 (ID 2)',
  	 				'AEC Plan 002 (ID 4)', 'AEC Plan 003 (ID 5)', 
  	 				'AEC Plan 004 (ID 13)');
  	
  	foreach($planid as $key=>$value)
  	{
  		$result = self::checkGetPlanName($value);
  		$this->assertEquals($result, $planName[$key]);
  	}
  		
  }
  
  function checkGetPlanName($planid)
  {
  	$result = XiptLibAec::getPlanName($planid);
  	return $result;
  }
  
  function testGetProfiletype()
  {
    $planid      = array(1, 2, 4, 5, 13);
  	$profiletype = array(1, 3, 3, 4, 2);
  	
  	foreach($planid as $key=>$value)
  	{
  		$result = self::checkGetProfiletype($value);
  		$this->assertEquals($result, $profiletype[$key]);
  	}
  }
  
  function checkGetProfiletype($planid)
  {
  	$result = XiptLibAec::getProfiletype($planid);
  	return $result;
  }
  
  function testGetMIntegration()
  {
  	//get microintegration of planid 5
  	$this->assertEquals(XiptLibAec::getMIntegration(5), array(6));
  	
  	//get microintegration of planid 13
  	$this->assertEquals(XiptLibAec::getMIntegration(13), array(8));
  	
  	//return blank array if plan id does not exist
  	$this->assertEquals(XiptLibAec::getMIntegration(1), array());
  }
  
  function testGetAecMessage()
  {
  	$mySess = JFactory::getSession();
  	$mySess->set('AEC_REG_PLANID', 4 ,'XIPT');
  	$this->assertEquals(XiptLibAec::getAecMessage(),'Your current profiletype is PROFILETYPE-3 , to change profiletype');
  }
  
  function testIsPlanExists()
  {
  	//return true if plan exists
  	$this->assertTrue(XiptLibAec::isPlanExists(2));
  	
  	//return true if plan exists
  	$this->assertTrue(XiptLibAec::isPlanExists(4));
  	
  	//return false if plan does not exist
  	$this->assertFalse(XiptLibAec::isPlanExists(1));
  }
  
  function testIsAecExists()
  {
  	JFolder::move('com_acctexp', 'com_acctexp11', JPATH_ROOT . DS . 'components');
  	$this->assertFalse(XiptLibAec::isAecExists());
  	
  	JFolder::move('com_acctexp11', 'com_acctexp', JPATH_ROOT . DS . 'components');
  	$this->assertTrue(XiptLibAec::isAecExists());
  	
  	
  }
  
  function testGetExistingMI()
  {
  	//this will return MIs present in MI table
  	$this->assertEquals(XiptLibAec::getExistingMI(array(1, 6, 8)), array(6, 8));
  }
  
  function testGetPlan()
  {
  	$plan = XiptLibAec::getPlan(2);
  	
  	$plan->micro_integrations 	= unserialize(base64_decode($plan->micro_integrations));
  	
  	$result = new stdClass();
  	$result->id 				= 2;
  	$result->name 				= 'AEC Plan 001 (ID 2)';
  	$result->micro_integrations = array(2);
  	
  	$this->assertEquals($plan->id, $result->id);
  	$this->assertEquals($plan->name, $result->name);
  	$this->assertEquals($plan->micro_integrations, $result->micro_integrations);
  	
  	$plan = XiptLibAec::getPlan(5);
  	
  	$plan->micro_integrations 	= unserialize(base64_decode($plan->micro_integrations));
  	
  	$result = new stdClass();
  	$result->id 				= 5;
  	$result->name 				= 'AEC Plan 003 (ID 5)';
  	$result->micro_integrations = array(6);
  	
  	$this->assertEquals($plan->id, $result->id);
  	$this->assertEquals($plan->name, $result->name);
  	$this->assertEquals($plan->micro_integrations, $result->micro_integrations);
  	
  	//will return null if plan does not exist
  	$this->assertEquals(XiptLibAec::getPlan(1), null);
  }
}