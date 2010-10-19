<?php

class AclProfileTest extends XiAclUnitTest
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testViewProfile()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array(0 => 1);
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'profile';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= 'editProfile';//should be non-empty
  		$this->assertFalse($this->checkApplicable(11, $data));

  		$data['task'] 	= '';
  		$data['viewuserid'] = 0; // should be non zero
  		$this->assertFalse($this->checkApplicable(11, $data));

  		$data['task'] 	= '';
  		$data['viewuserid'] = 85; // should not be equal
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 	= '';
  		$data['viewuserid'] = 86; // should be non zero
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85)
  		//   	2=users(80,83,86)
  		//  	3=users(81,84,87)

  		// Rule 11  : Ptype 1 cannotview  2
  		// Rule 12  : Ptype 2 cannotview  ALL
  		// Rule 13  : Ptype 3 cannotview  1

  		// Case 3 : pt1 -> pt2
  		$data['userid'] = 85;
  		$data['viewuserid'] = 86;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));

  		// Case 4 : pt2 -> ALL
  		$data['userid'] = 86;
  		$data['viewuserid'] = 82;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['viewuserid'] = 83;
  		$this->assertTrue($this->checkViolation(12, $data));

  		$data['viewuserid'] = 84;
  		$this->assertTrue($this->checkViolation(12, $data));


  		// Case 5 : pt3 -> pt3
  		$data['userid'] = 87;
  		$data['viewuserid'] = 81; //pt3
  		$this->assertTrue($this->checkViolation(13, $data));
  		$data['viewuserid'] = 84; //pt3
  		$this->assertTrue ($this->checkViolation(13, $data));
  		$data['viewuserid'] = 87; //pt3
  		$this->assertFalse ($this->checkViolation(13, $data));

  		// Case 6 : Friend Check
  		$data['userid'] = 85;

  		$data['viewuserid'] = 86; // NOT friends
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['viewuserid'] = 83; //  83,85 are Friends
  		$this->assertFalse($this->checkViolation(11, $data));

  }

  function testEditProfile()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array(0 => 1);
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'profile';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 	= 'edit';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85)
  		//   	2=users(80,83,86)
  		//  	3=users(81,84,87)

  		// Rule 11  : Ptype 1 cannot edit self profile
  		// Rule 12  : Ptype 2
  		// Rule 13  : Ptype 3

  		// Case 3 : pt1 -> pt2
  		$data['userid'] = 85;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));

  		// Case 4 : pt2 -> ALL
  		$data['userid'] = 86;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));


  		// Case 5 : pt3 -> pt3
  		$data['userid'] = 87;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  }

  function testChangeAvatar()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array(0 => 1);
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'profile';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['view'] 	= 'profile';
  		$data['task'] 	= 'uploadavatar';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		$data['view'] 	= 'register';
  		$data['task'] 	= 'registeravatar';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		$data['userid'] 	= 87;
  		$data['view'] 	= 'register';
  		$data['task'] 	= 'registeravatar'; //only rule 13 will be applicable
  		$this->assertTrue($this->checkApplicable(13, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85)
  		//   	2=users(80,83,86)
  		//  	3=users(81,84,87)

  		// Rule 11  : Ptype 1
  		// Rule 12  : Ptype 2
  		// Rule 13  : Ptype 3

  		$data['view'] 	= 'profile';
  		$data['task'] 	= 'uploadavatar';

  		// Case 3 : pt1 -> pt2
  		$data['userid'] = 85;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));

  		// Case 4 : pt2 -> ALL
  		$data['userid'] = 86;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));


  		// Case 5 : pt3 -> pt3
  		$data['userid'] = 87;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  }

  function testEditDetails()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array(0 => 1);
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'profile';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['view'] 	= 'profile';
  		$data['task'] 	= 'editdetails';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85)
  		//   	2=users(80,83,86)
  		//  	3=users(81,84,87)

  		// Rule 11  : Ptype 1
  		// Rule 12  : Ptype 2
  		// Rule 13  : Ptype 3

  		// Case 3 : pt1 -> pt2
  		$data['userid'] = 85;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));

  		// Case 4 : pt2 -> ALL
  		$data['userid'] = 86;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));


  		// Case 5 : pt3 -> pt3
  		$data['userid'] = 87;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  }

  function testEditPrivacy()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array(0 => 1);
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'profile';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['view'] 	= 'profile';
  		$data['task'] 	= 'privacy';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85)
  		//   	2=users(80,83,86)
  		//  	3=users(81,84,87)

  		// Rule 11  : Ptype 1
  		// Rule 12  : Ptype 2
  		// Rule 13  : Ptype 3

  		// Case 3 : pt1 -> pt2
  		$data['userid'] = 85;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));

  		// Case 4 : pt2 -> ALL
  		$data['userid'] = 86;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));


  		// Case 5 : pt3 -> pt3
  		$data['userid'] = 87;
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  }


}