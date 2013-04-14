<?php

class AclPhotoTest extends XiAclUnitTest
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testAlbum()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'photos';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'newalbum';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		//  Rule 11  : pt1 can't create album
  		//  Rule 12  : pt2 can't create album more than 1
  		//  Rule 13  : pt2 can't create album more than 2
  		//  Rule 14  : pt2 can't create album more than 3
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));


  		$data['userid'] 	= 80; // own 1 album
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));

  		$data['userid'] 	= 83; // own 2 album
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));

  		$data['userid'] 	= 86; // own 3 album
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertTrue($this->checkViolation(14, $data));
  }

  function testAddPhoto()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'photos';
  		$data['task'] 		= '';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'uploader';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		$data['task'] 		= 'jsonupload';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		$data['task'] 		= 'addnewupload';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		//  Rule 11  : pt1 can't create photo
  		//  Rule 12  : pt2 can't create photo more than 1
  		//  Rule 13  : pt2 can't create photo more than 2
  		//  Rule 14  : pt2 can't create photo more than 3
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));

  		$data['userid'] 	= 80; // own 1 album
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));

  		$data['userid'] 	= 83; // own 2 album
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));

  		$data['userid'] 	= 86; // own 3 album
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertTrue($this->checkViolation(14, $data));
  }

//  function testDelete()
//  {}
//
	function testAccessPhoto()
	{
		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'photos';
  		$data['task'] 		= '';
  		
  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(1, $data));
  		
  		$data['task'] 		= 'photo';
  		$data['userid'] 	= 86;
  		$this->assertTrue($this->checkApplicable(1, $data));
	}
}