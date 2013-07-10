<?php
class EmailMigrationTest extends XiUnitTestCase 
{
	//define this function if you require DB setup
  	function getSqlPath()
  	{
      	return dirname(__FILE__).'/sql/'.__CLASS__;
  	}
  	

  	function testEmailMigration()
  	{
  		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xipt'.DS.'install'.DS.'helper.php');
  		XiptHelperInstall::_migrateRegistrationConfig();
  		$this->_DBO->addTable('#__xipt_profiletypes');
  		$this->_DBO->addTable('#__xipt_settings');
  	}
}