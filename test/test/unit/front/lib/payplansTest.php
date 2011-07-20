<?php
class PayplansLibTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.'PayplansTest';
  }
  
  function testGetProfiletypeInfoFromPayplans()
  {
  		include_once JPATH_ROOT .DS. 'components' .DS. 'com_payplans' .DS. 'includes' .DS. 'api.php';
  		//default params
  		$param 					= array();
		$param['profiletype'] 	= 1;
		$param['plan'] 			= '';
		$param['planid'] 		= 0;
		$param['planSelected'] 	= false;
		
		//when planid and PT is not set in session
	  	$this->assertEquals(XiptLibPayplans::getProfiletypeInfoFromPayplans(), $param);
	  	
	  	$mySess = JFactory::getSession();
	  	$mySess->set('PAYPLANS_REG_PLANID', 1 ,'XIPT');
  	
  	    $param 					= array();
		$param['profiletype'] 	= 1;
		$param['plan'] 			= 'plan2';
		$param['planid'] 		= 1;
		$param['planSelected'] 	= true;
		
		//when planid is set, but PT is not set
		$this->assertEquals(XiptLibPayplans::getProfiletypeInfoFromPayplans(), $param);
		
		$mySess = JFactory::getSession();
	  	$mySess->set('PAYPLANS_REG_PLANID', 4 ,'XIPT');
	  	$mySess->set('SELECTED_PROFILETYPE_ID', 4 ,'XIPT');
	  	
		//default params
  		$param 					= array();
		$param['profiletype'] 	= 4;
		$param['plan'] 			= 'plan4';
		$param['planid'] 		= 4;
		$param['planSelected'] 	= true;
	  	
		//when both PT and planid is set in session
	  	$this->assertEquals(XiptLibPayplans::getProfiletypeInfoFromPayplans(), $param);
  }
  
  function testGetPlanName()
  {
  	include_once JPATH_ROOT .DS. 'components' .DS. 'com_payplans' .DS. 'includes' .DS. 'api.php';
  	$planid   = array(1, 2, 3, 4);
  	$planName = array('plan2', 'plan3', 'plan1', 'plan4');
  	
  	foreach($planid as $key=>$value)
  	{
  		$result = self::checkGetPlanName($value);
  		$this->assertEquals($result, $planName[$key]);
  	}
  		
  }
  
  function checkGetPlanName($planid)
  {
  	$result = XiptLibPayplans::getPlanName($planid);
  	return $result;
  }
  
  function testGetProfiletype()
  {
    //when PT is not set in session, return default PT
    $mySess = JFactory::getSession();
  	$mySess->set('SELECTED_PROFILETYPE_ID', 0 ,'XIPT');
    $this->assertEquals(XiptLibPayplans::getProfiletype(), 1);
    
    $mySess = JFactory::getSession();
  	$mySess->set('SELECTED_PROFILETYPE_ID', 3 ,'XIPT');
    //when PT is set in session, return PT
    $this->assertEquals(XiptLibPayplans::getProfiletype(), 3);
  }
  
  function testGetPayplansMessage()
  {
  	$mySess = JFactory::getSession();
  	$mySess->set('PAYPLANS_REG_PLANID', 4 ,'XIPT');
  	$mySess->set('SELECTED_PROFILETYPE_ID', 4 ,'XIPT');
  	$this->assertEquals(XiptLibPayplans::getPayplansMessage(),'Your currently selected plan is plan4 , to change plan');
  }
  
  function testIsPayplansExists()
  {
  	include_once JPATH_ROOT .DS. 'components' .DS. 'com_payplans' .DS. 'includes' .DS. 'includes.php';
  	$this->assertTrue(XiptLibPayplans::isPayplansExists());
  	
  }
  
}