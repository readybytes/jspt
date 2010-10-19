<?php

class AclFriendTest extends XiAclUnitTest
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testAdd()
  {

  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= true;
  		$data['args'] 		= array(0 => 1);
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'friends';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'ajaxconnect';
  		$data['userid'] = 85;
  		$this->assertTrue($this->checkApplicable(11, $data));
  		$this->assertFalse($this->checkApplicable(12, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85)
  		//   	2=users(80,83,86)
  		//  	3=users(81,84,87)

  		// Rule 11  : Ptype 1 cannot add ptype2 as friend
  		// Rule 12  : Ptype 2 cannot add ptype3 as friend
  		// Rule 13  : All cannot add ALL as friend
  		// Rule 14  : ALL cannot add ptype1 as friend

  		// Case 3 : pt1 -> pt2
  		$data['userid'] = 85;  $data['args'] = array(86);
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));

  		// Case 4 : pt2 -> pt3
  		$data['userid'] = 86;  $data['args'] = array(87);
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));

  		// Case 5 : pt3 -> pt1
  		$data['userid'] = 87;  $data['args'] = array(85);
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertTrue($this->checkViolation(14, $data));

  		// Rule 11  : Ptype 1 cannot add ptype2 as friend
  		// Rule 12  : Ptype 2 cannot add ptype3 as friend
  		// Rule 13  : All cannot add ALL as friend
  		// Rule 14  : ALL cannot add ptype1 as friend

  		//Reverse Cases
  		// Case 6 : pt2 -> pt1
  		$data['userid'] = 86;  $data['args'] = array(85);
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertTrue($this->checkViolation(14, $data));

  		// Case 7 : pt3 -> pt2
  		$data['userid'] = 87;  $data['args'] = array(86);
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));

  		// Case 8 : pt1 -> pt3
  		$data['userid'] = 85;  $data['args'] = array(87);
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));
  }

//  function testRemove()
//  {}
}