<?php


class XiptProfiletypesControllerTest extends XiUnitTestCase 
{

	//define this function if you require DB setup
  	function getSqlPath()
  	{
    	return dirname(__FILE__).'/sql/'.__CLASS__;
  	}
  	
  	function testRemove()
  	{
  		$controller = new XiptControllerProfiletypes();
  		
  		// case 1 : remove profiletype of id 6
  		$controller->remove(array(6));
  		
  		// case 2 : remove profiletype of id 3,4
  		$controller->remove(array(3,4));
  		
  		// case 3 : remove profiletype of id 5, which does not exists
  		$controller->remove(array(5));
  		
  		// case 4 : remove profiletype of id 1 which is default ptype, not be deleted
  		$controller->remove(array(1,2)); 		  
  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterOrder('#__xipt_profiletypes','id');
  	}
  	
  	function testPublish()
  	{ 		
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->multidobool('switchOnpublished',array(1,3,4));  		
  		$controller->multidobool('switchOnpublished',array(2));
  		$controller->multidobool('switchOnpublished',6);
  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterOrder('#__xipt_profiletypes','id');
  	}
  	
	function testUnpublish()
  	{ 		
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->multidobool('switchOffpublished',array(1,3,4));  		
  		$controller->multidobool('switchOffpublished',array(2));
  		$controller->multidobool('switchOffpublished',6);

  		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterOrder('#__xipt_profiletypes','id');
  	}
  	
  	function testVisible()
  	{
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->multidobool('switchOnvisible',array(1,3,4));  		
  		$controller->multidobool('switchOnvisible',array(2));
  		$controller->multidobool('switchOnvisible',6);  		  	
  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterOrder('#__xipt_profiletypes','id');
  	}
  	
	function testInvisible()
  	{
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->multidobool('switchOffvisible',array(1,3,4));  		
  		$controller->multidobool('switchOffvisible',array(2));
  		$controller->multidobool('switchOffvisible',6); 		
  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterOrder('#__xipt_profiletypes','id');  		
  	}
  	
	function testApprove()
  	{
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->multidobool('switchOnapprove',array(1,3,4));  		
  		$controller->multidobool('switchOnapprove',array(2));
  		$controller->multidobool('switchOnapprove',6);  		  	
  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterOrder('#__xipt_profiletypes','id');
  	}
  	
	function testAdminApprove()
  	{
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->multidobool('switchOffapprove',array(1,3,4));  		
  		$controller->multidobool('switchOffapprove',array(2));
  		$controller->multidobool('switchOffapprove',6); 		
  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterOrder('#__xipt_profiletypes','id');  		
  	}
  	
  	function testSaveOrder()
  	{
 		$controller = new XiptControllerProfiletypes();
 		
 		$controller->saveOrder(array(1),'orderdown');
 		$controller->saveOrder(array(6),'orderup');
 		$controller->saveOrder(array(3),'orderdown');
 		$controller->saveOrder(array(4),'orderup');
 		$controller->saveOrder(array(6),'orderdown');
 		
 		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterOrder('#__xipt_profiletypes','id');
  	}
  	
  	function testRemoveAvatar()
  	{
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->removeAvatar(1,'components/com_community/assets/demo.jpg');
  		$controller->removeAvatar(2,'components/com_community/assets/demo1.jpg');
  		  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
		$this->_DBO->filterOrder('#__xipt_profiletypes','id');
  		$this->_DBO->addTable('#__community_users');  		
  	}
}
