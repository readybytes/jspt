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
  	}
  	
  	function testPublish()
  	{ 		
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->publish(array(1,3,4));  		
  		$controller->publish(array(2));
  		$controller->publish(6);
  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
  	}
  	
	function testUnpublish()
  	{ 		
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->unpublish(array(1,3,4));  		
  		$controller->unpublish(array(2));
  		$controller->unpublish(6);

  		$this->_DBO->addTable('#__xipt_profiletypes');
  	}
  	
  	function testVisible()
  	{
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->visible(array(1,3,4));  		
  		$controller->visible(array(2));
  		$controller->visible(6);  		  	
  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
  	}
  	
	function testInvisible()
  	{
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->invisible(array(1,3,4));  		
  		$controller->invisible(array(2));
  		$controller->invisible(6); 		
  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
  		
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
  	}
  	
  	function testRemoveAvatar()
  	{
  		$controller = new XiptControllerProfiletypes();
  		
  		$controller->removeAvatar(1,'components/com_community/assets/demo.jpg');
  		$controller->removeAvatar(2,'components/com_community/assets/demo1.jpg');
  		  		
  		$this->_DBO->addTable('#__xipt_profiletypes');
  		$this->_DBO->addTable('#__community_users');  		
  	}
}