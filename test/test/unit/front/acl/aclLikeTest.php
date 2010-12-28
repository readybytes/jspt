<?php

class AclLikeTest extends XiAclUnitTest
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }


  function testLikePhoto()
  {
  		$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'system';
  		$data['task'] 		= '';
  		
  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(1, $data));
  		
  		$data['args'][0] = 'photo';
  		$data['task']	 = 'ajaxlike';
  		$data['userid']	 = 86;
  		$this->assertTrue($this->checkApplicable(1, $data));
  }
  
  function testLikeProfile(){
  	  	$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'system';
  		$data['task'] 		= '';
  		
  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(1, $data));
  		
  		$data['args'][0] = 'profile';
  		$data['task'] = 'ajaxlike';
  		$data['userid'] = 86;
  		$this->assertTrue($this->checkApplicable(1, $data));
  }
  
  function testLikeGroup(){
  	  	$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'system';
  		$data['task'] 		= '';
  		
  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(1, $data));
  		
  		$data['args'][0] = 'groups';
  		$data['task'] = 'ajaxlike';
  		$data['userid'] = 86;
  		$this->assertTrue($this->checkApplicable(1, $data));
  }
  
  function testLikeVideo(){
  	  	$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'system';
  		$data['task'] 		= '';
  		
  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(1, $data));
  		
  		$data['args'][0] = 'videos';
  		$data['task'] = 'ajaxlike';
  		$data['userid'] = 86;
  		$this->assertTrue($this->checkApplicable(1, $data));
  }
  
  function testLikeEvent(){
  	  	$data = array();
  		$data['userid'] 	= 85;
  		$data['viewuserid'] = 0;
  		$data['ajax'] 		= false;
  		$data['args'] 		= array();
  		$data['option'] 	= 'com_community';
  		$data['view'] 		= 'system';
  		$data['task'] 		= '';
  		
  		// case 1: not applicable
  		$data['task'] 		= '';
  		$this->assertFalse($this->checkApplicable(1, $data));
  		
  		$data['args'][0] = 'events';
  		$data['task'] = 'ajaxlike';
  		$data['userid'] = 86;
  		$this->assertTrue($this->checkApplicable(1, $data));
  }
  
 }