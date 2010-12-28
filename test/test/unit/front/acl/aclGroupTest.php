<?php

class AclGroupTest extends XiAclUnitTest
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
  		$data['view'] 		= 'groups';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'create';
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		// Case 3 : Rule 11  : pt1 can't create group
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['userid'] 	= 86;
  		$this->assertFalse($this->checkViolation(11, $data));

  		$data['userid'] 	= 87;
  		$this->assertFalse($this->checkViolation(11, $data));


  		// Case 4 : Rule 12  : ALL PT can't create group
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 86;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkViolation(12, $data));


  		// Case 5 : Rule 13  : PT1 can create 2 groups
  		$data['userid'] 	= 85; // own less then group
  		$this->assertFalse($this->checkViolation(13, $data));

  		$data['userid'] 	= 82; // own exactly 2 group
  		$this->assertTrue($this->checkViolation(13, $data));

  		$data['userid'] 	= 79; // own 3 groups
  		$this->assertTrue($this->checkViolation(13, $data));
  }

  function testJoin()
  {

  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'groups';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'ajaxshowjoingroup';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		$data['task'] 		= 'ajaxsavejoingroup';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		// Case 3 : Rule 11  : pt1 can't join group
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['userid'] 	= 86;
  		$this->assertFalse($this->checkViolation(11, $data));

  		$data['userid'] 	= 87;
  		$this->assertFalse($this->checkViolation(11, $data));


  		// Case 4 : Rule 12  : ALL PT can't join group
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 86;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkViolation(12, $data));


  		// Case 5 : Rule 13  : PT1 can join 2 groups
  		$data['userid'] 	= 79;
  		$this->assertFalse($this->checkViolation(13, $data));

  		$data['userid'] 	= 82;
  		$this->assertTrue($this->checkViolation(13, $data));

  		$data['userid'] 	= 85;
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
  		$data['view'] 		= 'groups';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(10, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'viewgroup';
  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkApplicable(10, $data));


  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		//Rule 10: pt3  cant access group(6) from pt1
  		// # pt3 - pt3
  		$data['userid'] 	= 87;
  		$data['groupid'] 	= 7;
  		$this->assertFalse($this->checkViolation(10, $data));

  		// # pt3 - pt2
  		$data['userid'] 	= 87;
  		$data['groupid'] 	= 5;
  		$this->assertFalse($this->checkViolation(10, $data));

  		// # pt3 - pt1
  		$data['userid'] 	= 87;
  		$data['groupid'] 	= 6;
  		$this->assertTrue($this->checkViolation(10, $data));

  		// Rule 11: same but not applicable to friends
  		// # pt3 - pt1, not friends
  		$data['userid'] 	= 84;
  		$data['groupid'] 	= 6;
  		$this->assertTrue($this->checkViolation(11, $data));

  		// # pt3 - pt1, friends,
  		$data['userid'] 	= 87;
  		$data['groupid'] 	= 6;
  		$this->assertFalse($this->checkViolation(11, $data));
  }

  function testDelete()
  {

  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'groups';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'ajaxdeletegroup';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		// Case 3 : Rule 11  : pt1 can't delete group
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['userid'] 	= 86;
  		$this->assertFalse($this->checkViolation(11, $data));

  		$data['userid'] 	= 87;
  		$this->assertFalse($this->checkViolation(11, $data));


  		// Case 4 : Rule 12  : ALL PT can't create group
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 86;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkViolation(12, $data));
  }
  
function testAccessgroupcategory()
  {
  		$data = array();
  		$data['userid'] 	= 0;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'groups';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(10, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'viewgroup';
  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkApplicable(10, $data));


  		// Profiletypes:
  		//  	1=users(79,82,85) ,  
  		//   	2=users(80,83,86) ,  
  		//  	3=users(81,84,87) ,  
  		//Rule 10: pt3  can access group category 4

  		$data['userid'] 	= 87;
  		$data['groupid'] 	= 7;
  		$this->assertTrue($this->checkViolation(10, $data));

  		$data['userid'] 	= 87;
  		$data['groupid'] 	= 6;
  		$this->assertTrue($this->checkViolation(10, $data));

  		$data['userid'] 	= 87;
  		$data['groupid'] 	= 5;
  		$this->assertFalse($this->checkViolation(10, $data));
  		
  		// Case 4 : Rule 11  : ALL PT can access group category 3
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['userid'] 	= 86;
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkViolation(11, $data));

  	  }
}