<?php


class XiptProfilefieldsControllerTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testSave()
  {
  	$controller = new XiptControllerProfilefields();
  	
  	#case : 1 Blank Table, Set to ALL, No update required
  	$data = array('id'=>2);
  		
	$data['allowedProfileTypes']= array(1,2);		
	$data['requiredProfileTypes']= array(1,2);		
	$data['visibleProfileTypes']= array(1,2);		
	$data['editableAfterRegProfileTypes']= array(1,2);	
	$data['editableDuringRegProfileTypes']= array(1,2);
  	$controller->save($data);  	
  	
  	#case : 2 : Select all types, no entries in table for id 4
  	$data = array('id'=>4);
  	$data['allowedProfileTypes']= array(1,2);		
	$data['requiredProfileTypes']= array(1,2);		
	$data['visibleProfileTypes']= array(1,2);		
	$data['editableAfterRegProfileTypes']= array(1,2);	
	$data['editableDuringRegProfileTypes']= array(1,2);
  	$controller->save($data);
  	
  	#case : 3 It should store 3 rows for id = 5
  	$data = array('id'=>5);  	
	$data['allowedProfileTypes'] 		= array(1,2);	
	$data['requiredProfileTypes'] 		= array(1,2);
	$data['visibleProfileTypes'] 		= array(1,2);		
	$data['editableAfterRegProfileTypes'] = array(1);	
	$controller->save($data);
  	
  	#case : 4 Update Existing records for id = 5 
  	$data = array('id'=>5);
  	$data['allowedProfileTypes'] 		= array(2);	
	$data['requiredProfileTypes'] 		= array(1);
	$data['visibleProfileTypes'] 		= array(1,2);
	$data['editableAfterRegProfileTypes'] = array(1);	
	$controller->save($data);  	
  	
  	$this->_DBO->addTable('#__xipt_profilefields');
  	$this->_DBO->filterOrder('#__xipt_profilefields', 'pid');
  	$this->_DBO->filterColumn('#__xipt_profilefields', 'id');
  }
 
}