<?php

class AclMigrationTest extends XiUnitTestCase 
{
	//define this function if you require DB setup
  	function getSqlPath()
  	{
      	return dirname(__FILE__).'/sql/'.__CLASS__;
  	}
  	
	//test acl migration with version 3.0.460 should return true
  	function testACLMigration()
  	{
  		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php');
  		$this->assertTrue(XiptHelperInstall::_migration460());
  	}
  	
  	
  	//test acl migration with version > 3.0.460 should instert base64_encoded code in D.B.
	function testACLMigrationEncoding()
  	{
  		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php');
  		XiptHelperInstall::_migration460();
  		$this->_DBO->addTable('#__xipt_aclrules');
  	}

}