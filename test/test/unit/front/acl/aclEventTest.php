<?php

class AclEventTest extends XiAclUnitTest
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testCreate()
  {

  		$data = array();
  		$data['userid'] 	= 0;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'events';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'create';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85)
  		//   	2=users(80,83,86)
  		//  	3=users(81,84,87)

  		// Case 3 : Rule 11  : pt1 can't create event
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['userid'] 	= 86;
  		$this->assertFalse($this->checkViolation(11, $data));

  		$data['userid'] 	= 87;
  		$this->assertFalse($this->checkViolation(11, $data));


  		// Case 4 : Rule 12  : ALL PT can't create event
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 86;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkViolation(12, $data));


  		// Case 5 : Rule 13  : PT1 can create 2 event
  		$data['userid'] 	= 85;
  		$this->assertFalse($this->checkViolation(13, $data));

  		$data['userid'] 	= 82;
  		$this->assertTrue($this->checkViolation(13, $data));

  		$data['userid'] 	= 79;
  		$this->assertTrue($this->checkViolation(13, $data));

  }

  function testView()
  {
  		$data = array();
  		$data['userid'] 	= 0;
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
  		$data['eventid'] 	= 3;
  		$this->assertFalse($this->checkViolation(10, $data));

  		// # pt3 - pt2
  		$data['userid'] 	= 87;
  		$data['eventid'] 	= 2;
  		$this->assertFalse($this->checkViolation(10, $data));

  		// # pt3 - pt1
  		$data['userid'] 	= 87;
  		$data['eventid'] 	= 1;
  		$this->assertTrue($this->checkViolation(10, $data));

  		// Rule 11: same but not applicable to friends
  		// # pt3 - pt1, not friends
  		$data['userid'] 	= 84;
  		$data['eventid'] 	= 1;
  		$this->assertTrue($this->checkViolation(11, $data));

  		// # pt3 - pt1, friends,
  		$data['userid'] 	= 87;
  		$data['eventid'] 	= 1;
  		$this->assertFalse($this->checkViolation(11, $data));
  }

  function testDelete()
  {

  		$data = array();
  		$data['userid'] 	= 0;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'events';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'ajaxdeleteevent';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85) ,  event 6
  		//   	2=users(80,83,86) ,  event 5
  		//  	3=users(81,84,87) ,  event 7

  		// Case 3 : Rule 11  : pt1 can't delete event
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['userid'] 	= 86;
  		$this->assertFalse($this->checkViolation(11, $data));

  		$data['userid'] 	= 87;
  		$this->assertFalse($this->checkViolation(11, $data));


  		// Case 4 : Rule 12  : ALL PT can't delete event
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 86;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkViolation(12, $data));
  }
}