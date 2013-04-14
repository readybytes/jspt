<?php

class AclIsSelfTest extends XiAclUnitTest
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }


  function testView()
  {
  		$data = array();
  		$data['userid'] 	= 87;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'events';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(10, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'viewevent';
  		$this->assertTrue($this->checkApplicable(10, $data));


  		// Profiletypes:
  		//  	1=users(79,82,85) ,  event 1
  		//   	2=users(80,83,86) ,  event 2
  		//  	3=users(81,84,87) ,  event 3

  		//Rule 10: pt3  cant access event(6) from pt1
  		// # pt3 - pt3
  		$data['userid'] 	= 87;
  		$data['viewuserid'] = 87; 
  		$data['eventid'] 	= 3;
  		$result = $this->checkViolation(10,$data);
  		$this->assertTrue($result['self']);
  		$this->assertFalse($result['voilation']);
  		

  		$data['userid'] 	= 87;
  		$data['viewuserid'] = 87; 
  		$data['eventid'] 	= 3;
  		$result = $this->checkViolation(11,$data);
  		$this->assertFalse($result['self']);
  		$this->assertFalse($result['voilation']);
  		
  		
  		$data['userid'] 	= 87;
  		$data['viewuserid'] = 84; 
  		$data['eventid'] 	= 3;
  		$result = $this->checkViolation(11,$data);
  		$this->assertTrue($result['self']);
  		$this->assertFalse($result['voilation']);
  		
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 85; 
  		$data['eventid'] 	= 1;
  		$result = $this->checkViolation(11,$data);
  		$this->assertFalse($result['self']);
  		$this->assertFalse($result['voilation']);
  		
  }
  
	function checkViolation($aclid, $info)
	{
		//load
		$filter['id']	= $aclid;
		$filter['published']= 1;
		$rules = XiptAclFactory::getAclRulesInfo($filter);

		//prepare
		$rule = array_pop($rules);
		$aclObject = XiptAclFactory::getAclObject($rule->aclname);
		$aclObject->bind($rule);


		//test violation
		$result['voilation'] = $aclObject->checkViolation($info);
		$result['self'] 	 = $aclObject->isApplicableOnSelf($info['userid'],$info['viewuserid']);
		return $result;
	}
}