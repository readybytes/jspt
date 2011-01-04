<?php

class XiptControllerProfiletypesTest extends XiUnitTestCase
{
  	function getSqlPath()
  	{
    	return dirname(__FILE__).'/sql/'.__CLASS__;
  	}
  	
  	function testResetAll()
  	{
  		$id = 1;
  		$limit = 2;
  		require_once(JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'libraries'.DS.'base'.DS.'model.php');
  		$model = XiptFactory::getInstance('profiletypes','Model');
  		
  		$oldData = $model->loadRecords(0);
  		$oldData = $oldData[$id];
  		$newData = $model->loadRecords(0);
		$newData = $newData[$id];
		$newData->privacy = $model->loadParams($id,'privacy');
  		$newData->template = 'default';		
  		  		
  		$session = JFactory::getSession();
		$session->set('oldPtData',$oldData,'jspt');
		$session->set('newPtData',$newData,'jspt');
  		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'controllers'.DS.'profiletypes.php');
  		
  		$start = XiptControllerProfiletypes::resetall($id, $limit);
  		$this->assertEquals($start, 1);
  		//echo "\nfirstcheck should be 1".$start;  
  		
  		$start = XiptControllerProfiletypes::resetall($id, $limit , $start);
  	//	echo "\nfirstcheck should be 2".$start;
  		$this->assertEquals($start,2);
  	
  		  		
  		$start = XiptControllerProfiletypes::resetall($id, $limit, $start);
  	//	echo "\nfirstcheck should be 3".$start;
  		$this->assertEquals($start,3);
  	
  		
  		$start = XiptControllerProfiletypes::resetall($id, $limit, $start);
  		$this->assertEquals($start,4);
  	//	echo "\nfirstcheck should be 4".$start;
  		
  		$start = XiptControllerProfiletypes::resetall($id, $limit, $start);
 
  		$this->_DBO->addTable('#__community_fields_values');
  		$this->_DBO->addTable('#__xipt_users');
		
  	}
}