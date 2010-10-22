<?php


class XiptApplicationsControllerTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testSave()
  {
  	$controller = new XiptControllerApplications();
  	
  	#case : 1 Blank Table, Set to ALL, No update required
  	$data = array('id'=>98);
  	$data['profileTypes']=array(1,2,3,4,6);
  	$controller->save($data);
  	
  	#case : 2 : Select all types, no entries in table
  	$data = array('id'=>99);
  	$data['profileTypes']=array(1,2,3,4,6);
  	$controller->save($data);
  	
  	#case : 3 It should store 3 rows 
  	$data = array('id'=>100);
  	$data['profileTypes']=array(1,4);  	
  	$controller->save($data);
  	
  	#case : 4 Update Existing records 
  	$data = array('id'=>100);
  	$data['profileTypes']=array(4,3);  	
  	$controller->save($data);
  	
  	#case : 4 Update Existing ALL records to  
  	$data = array('id'=>101);
  	$data['profileTypes']=array(1,2,3,4,6);
  	$controller->save($data);
  	
  	$data = array('id'=>101);
  	$data['profileTypes']=array(6,3);  	
  	$controller->save($data);
  	
  	#case 5 : Saved records to ALL selection 
  	$data = array('id'=>102);
  	$data['profileTypes']=array(4,3);  	
  	$controller->save($data);
  	
  	$data = array('id'=>102);
  	$data['profileTypes']=array(1,2,3,4,6);
  	$controller->save($data);
  	
  	$this->_DBO->addTable('#__xipt_applications');
  	$this->_DBO->filterOrder('#__xipt_applications', 'profiletype');
  	$this->_DBO->filterColumn('#__xipt_applications', 'id');
  }
 
}