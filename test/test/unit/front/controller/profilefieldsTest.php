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
  	$data['allowedProfileTypeCount'] = 2;	
	$data['allowedProfileType0']= 0;	
	$data['requiredProfileTypeCount'] = 2;	
	$data['requiredProfileType0']= 0;
	$data['visibleProfileTypeCount'] = 2;	
	$data['visibleProfileType0']= 0;
	$data['editableAfterRegProfileTypeCount'] = 2;	
	$data['editableAfterRegProfileType0']= 0;
	$data['editableDuringRegProfileTypeCount'] = 2;	
	$data['editableDuringRegProfileType0']= 0;
  	$controller->save($data);  	
  	
  	#case : 2 : Select all types, no entries in table for id 4
  	$data = array('id'=>4);
  	$data['allowedProfileTypeCount'] = 2;	
	$data['allowedProfileType1']= 1;	
	$data['allowedProfileType2']= 2;
	$data['requiredProfileTypeCount'] = 2;	
	$data['requiredProfileType1']= 1;
	$data['requiredProfileType2']= 2;
	$data['visibleProfileTypeCount'] = 2;	
	$data['visibleProfileType1']= 1;
	$data['visibleProfileType2']= 2;
	$data['editableAfterRegProfileTypeCount'] = 2;	
	$data['editableAfterRegProfileType1']= 1;
	$data['editableAfterRegProfileType2']= 2;
	$data['editableDuringRegProfileTypeCount'] = 2;	
	$data['editableDuringRegProfileType1']= 1;
	$data['editableDuringRegProfileType2']= 2;
  	$controller->save($data);
  	
  	#case : 3 It should store 3 rows for id = 5
  	$data = array('id'=>5);
  	$data['allowedProfileTypeCount'] 	= 2;	
	$data['allowedProfileType0'] 		= 0;	
	$data['requiredProfileTypeCount'] 	= 2;	
	$data['requiredProfileType0'] 		= 0;
	$data['visibleProfileTypeCount'] 	= 2;	
	$data['visibleProfileType0'] 		= 0;
	$data['editableAfterRegProfileTypeCount'] = 2;	
	$data['editableAfterRegProfileType1'] = 1 ;	
	$controller->save($data);
  	
  	#case : 4 Update Existing records for id = 5 
  	$data = array('id'=>5);
  	$data['allowedProfileTypeCount'] 	= 2;	
	$data['allowedProfileType2'] 		= 2;	
	$data['requiredProfileTypeCount'] 	= 2;	
	$data['requiredProfileType1'] 		= 1;
	$data['visibleProfileTypeCount'] 	= 2;	
	$data['visibleProfileType0'] 		= 0;
	$data['editableAfterRegProfileTypeCount'] = 2;	
	$data['editableAfterRegProfileType1'] = 1 ;	
	$controller->save($data);  	
  	
  	$this->_DBO->addTable('#__xipt_profilefields');
  	$this->_DBO->filterOrder('#__xipt_profilefields', 'pid');
  	$this->_DBO->filterColumn('#__xipt_profilefields', 'id');
  }
 
}