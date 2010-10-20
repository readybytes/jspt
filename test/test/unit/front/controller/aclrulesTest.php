<?php


class XiptAclrulesControllerTest extends XiUnitTestCase 
{

	//define this function if you require DB setup
  	function getSqlPath()
  	{
    	return dirname(__FILE__).'/sql/'.__CLASS__;
  	}
  	
  	function testRemove()
  	{
  		$controller = new XiptControllerAclrules();
  		
  		// case 1 : remove profiletype of id 6
  		$controller->remove(array(6));
  		
  		// case 2 : remove profiletype of id 3,4
  		$controller->remove(array(3,4));
  		
  		// case 3 : remove profiletype of id 5, which does not exists
  		$controller->remove(array(5));
  		
  		// case 4 : remove profiletype of id 1 which is default ptype, not be deleted
  		$controller->remove(array(2)); 		  
  		
  		$this->_DBO->addTable('#__xipt_aclrules');
  	}
  	
  	function testPublish()
  	{ 		
  		$controller = new XiptControllerAclrules();
  		
  		$controller->multidobool('switchOnpublished', array(1,3,4));  		
  		$controller->multidobool('switchOnpublished', array(2));
  		$controller->multidobool('switchOnpublished', 6);
  		
  		$this->_DBO->addTable('#__xipt_aclrules');
  	}
  	
	function testUnpublish()
  	{ 		
  		$controller = new XiptControllerAclrules();
  		
  		$controller->multidobool('switchOffpublished', array(1,3,4));  		
  		$controller->multidobool('switchOffpublished', array(2));
  		$controller->multidobool('switchOffpublished', 6);

  		$this->_DBO->addTable('#__xipt_aclrules');
  	}
}