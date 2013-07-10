<?php

class AclMessageTest extends XiAclUnitTest
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }


  function testSend()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= true;
  		$data['args'] 		= array(0 => 1);
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'inbox';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 	= 'ajaxcompose';
  		$data['userid'] = 85;
  		$this->assertTrue($this->checkApplicable(11, $data));

  		$data['task'] 	= 'ajaxaddreply';
  		$data['userid'] = 85;
  		$this->assertTrue($this->checkApplicable(11, $data));

  		$data['task'] 	= 'write';
  		$data['userid'] = 85;
  		$data['viewuserid'] = 86;
  		$this->assertTrue($this->checkApplicable(11, $data));


  		// Profiletypes:
  		//  	1=users(79,82,85)
  		//   	2=users(80,83,86)
  		//  	3=users(81,84,87)

  		// Rule 11  : Ptype 1 cannot send msg to  ptype2
  		// Rule 12  : Ptype ALL cannot send msg to  ptype3
  		// Rule 13  : Ptype 1 can send ONLY-2 msg to ptype2
  		// Rule 14  : Ptype 1 can send ONLY-1 msg to ptype2

  		// Case 3 : pt1 -> pt2
  		$data['userid'] = 85;
  		$data['viewuserid'] = 86;
  		$data['args'] = array(86);
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data)); // 2 message allowed

  		// Case 4 : pt1 -> pt3
  		$data['userid'] = 85;
  		$data['viewuserid'] = 87;
  		$data['args'] = array(87);
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));


  		// Case 5 : pt1 -> pt2 (Limit check)
  		$data['userid'] = 85;
  		$data['viewuserid'] = 83;
  		$data['args'] = array(83);
  		$this->assertFalse($this->checkViolation(13, $data)); // 4 msg
  		$this->assertTrue ($this->checkViolation(14, $data)); // 3 msg
  		$this->assertTrue ($this->checkViolation(15, $data)); // 2 msg

  		// Case 6 : Friend Check
  		$data['userid'] = 85;
  		$data['viewuserid'] = 83;
  		$data['args'] = array(83);
  		$this->assertTrue ($this->checkViolation(11, $data)); // friend rule, are friend

  		$data['viewuserid'] = 87;
  		$data['args'] = array(87);
  		$this->assertfalse ($this->checkViolation(11, $data)); // not friends

  }

//  function testRead()
//  {}
}