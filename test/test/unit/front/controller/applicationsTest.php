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
  	$data['profileTypes0']=true;
  	$controller->save($data);
  	
  	#case : 2 : Select all types, no entries in table
  	$data = array('id'=>99);
  	$data['profileTypes1']=1;
  	$data['profileTypes2']=1;
  	$data['profileTypes3']=1;
  	$data['profileTypes4']=1;
  	$data['profileTypes6']=1;
  	$controller->save($data);
  	
  	#case : 3 It should store 3 rows 
  	$data = array('id'=>100);
  	$data['profileTypes1']=1;
  	$data['profileTypes4']=1;
  	$controller->save($data);
  	
  	#case : 4 Update Existing records 
  	$data = array('id'=>100);
  	$data['profileTypes4']=1;
  	$data['profileTypes3']=1;
  	$controller->save($data);
  	
  	#case : 4 Update Existing ALL records to  
  	$data = array('id'=>101);
  	$data['profileTypes0']=true;
  	$controller->save($data);
  	
  	$data = array('id'=>101);
  	$data['profileTypes6']=1;
  	$data['profileTypes3']=1;
  	$controller->save($data);
  	
  	#case 5 : Saved records to ALL selection 
  	$data = array('id'=>102);
  	$data['profileTypes4']=1;
  	$data['profileTypes3']=1;
  	$controller->save($data);
  	
  	$data = array('id'=>102);
  	$data['profileTypes0']=true;
  	$controller->save($data);
  	
  	$this->_DBO->addTable('#__xipt_applications');
  	$this->_DBO->filterOrder('#__xipt_applications', 'profiletype');
  	$this->_DBO->filterColumn('#__xipt_applications', 'id');
  }
 
}