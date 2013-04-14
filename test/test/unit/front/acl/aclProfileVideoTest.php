<?php

class AclProfileVideoTest extends XiAclUnitTest
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
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'profile';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'ajaxlinkprofilevideo';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		//  Rule 11  : pt1 can't add profile video
  		//  Rule 12  : pt2 can add profile video
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));

  		$data['userid'] 	= 86;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));
  }

  function testDelete()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= true;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'profile';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'ajaxremovelinkprofilevideo';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		//  Rule 11  : pt1 can't add profile video
  		//  Rule 12  : pt2 can add profile video
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));

  		$data['userid'] 	= 86;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));
  }

  function testView()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= true;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'profile';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'ajaxplayprofilevideo';
  		$this->assertTrue($this->checkApplicable(11, $data));


  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		//  Rule 11  : pt1 can't see video of pt2
  		//  Rule 12  : pt2 cant see video of pt3
  		$data['userid'] 	= 85;
  		$data['args'][0]	= 6 ; // video of 86
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));

  		$data['userid'] 	= 85;
  		$data['args'][0]	= 7 ; // video of 87
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));

  		$data['userid'] 	= 86;
  		$data['args'][0]	= 7 ; // video of 87
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));

  		//86 and 84 are friends
  		$data['userid'] 	= 86;
  		$data['args'][0]	= 4 ; // video of 84
  		$this->assertFalse($this->checkViolation(12, $data));

  }
}