<?php

class AclVideoTest extends XiAclUnitTest
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
  		$data['view'] 		= 'videos';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'ajaxaddvideo';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		$data['task'] 		= 'ajaxuploadvideo';
  		$this->assertTrue($this->checkApplicable(11, $data));

  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		//  Rule 11  : pt1 can't create video
  		//  Rule 12  : pt2 can't create video more than 1
  		//  Rule 13  : pt2 can't create video more than 2
  		//  Rule 14  : pt2 can't create video more than 3
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));

  		$data['userid'] 	= 80; // own 1
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertFalse($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));

  		$data['userid'] 	= 83; // own 2
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertFalse($this->checkViolation(14, $data));

  		$data['userid'] 	= 86; // own 3
  		$this->assertTrue($this->checkViolation(12, $data));
  		$this->assertTrue($this->checkViolation(13, $data));
  		$this->assertTrue($this->checkViolation(14, $data));
  }


  function testView()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= true;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'videos';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(11, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'video';
  		$this->assertTrue($this->checkApplicable(11, $data));


  		// Profiletypes:
  		//  	1=users(79,82,85) ,  group 6
  		//   	2=users(80,83,86) ,  group 5
  		//  	3=users(81,84,87) ,  group 7

  		//  Rule 11  : pt1 can't see video of pt2
  		//  Rule 12  : pt2 cant see video of pt3
  		$data['userid'] 	= 85;
  		$data['videoid']	= 6 ; // video of 86
  		$this->assertTrue($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));

  		$data['userid'] 	= 85;
  		$data['videoid']	= 7 ; // video of 87
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertFalse($this->checkViolation(12, $data));

  		$data['userid'] 	= 86;
  		$data['videoid']	= 7 ; // video of 87
  		$this->assertFalse($this->checkViolation(11, $data));
  		$this->assertTrue($this->checkViolation(12, $data));

  		//86 and 84 are friends
  		$data['userid'] 	= 86;
  		$data['videoid']	= 4 ; // video of 84
  		$this->assertFalse($this->checkViolation(12, $data));

  }
  
 
function xtestAccessvideocategory()
  {
  		$data = array();
  		$data['userid'] 	= 0;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'videos';

  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(10, $data));

  		// case 2 : should be applicable
  		$data['task'] 		= 'video';
  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkApplicable(10, $data));


  		// Profiletypes:
  		//  	1=users(79,82,85) ,  
  		//   	2=users(80,83,86) ,  
  		//  	3=users(81,84,87) ,  
  		//Rule 10: pt3  can access video category 4

  		$data['userid'] 	= 87;
  		$data['videoid'] 	= 7;
  		$this->assertTrue($this->checkViolation(10, $data));

  		$data['userid'] 	= 87;
  		$data['videoid'] 	= 6;
  		$this->assertTrue($this->checkViolation(10, $data));

  		$data['userid'] 	= 87;
  		$data['videoid'] 	= 5;
  		$this->assertFalse($this->checkViolation(10, $data));
  		
  		// Case 4 : Rule 11  : ALL PT can access video category 3
  		$data['userid'] 	= 85;
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['userid'] 	= 86;
  		$this->assertTrue($this->checkViolation(11, $data));

  		$data['userid'] 	= 87;
  		$this->assertTrue($this->checkViolation(11, $data));

  	  }
}
