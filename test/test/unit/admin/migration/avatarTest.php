<?php

require_once JPATH_ADMINISTRATOR.DS."components/com_xipt/install/helper.php";
class DefaultAvatarPathTest extends XiUnitTestCase
{	
	function testDefaultAvatarPath()
	{
		// get avatar coloumn schema
		$avatarSchema=XiptHelperInstall::_getColumnStructure('#__xipt_profiletypes','avatar');
		$this->assertTrue((0 == JString::strcmp($avatarSchema->Default,'components/com_community/assets/user.png')));	
	} 
	
	function testMigrationOnAvatarPath(){

		//If you have already user.png then dont apply migration.
		$this->assertFalse(XiptHelperInstall::changeDefaultAvatar());
		
		// change XiPT version
		$db		= JFactory::getDBO();

		$query	= 'UPDATE #__xipt_settings'
				.' SET '. $db->nameQuote('params') .' = '.$db->Quote('3.1.600')
				.' WHERE '. $db->nameQuote('name') .' = '.$db->Quote('version');
		$db->setQuery($query);
		$db->query();
		// change default path = components/com_community/assets/default.jpg in `#__xipt_profiletypes` table
		$query = "ALTER TABLE `#__xipt_profiletypes` MODIFY `avatar` varchar(250) Default 'components/com_community/assets/default.jpg' NOT NULL";
		$db->setQuery($query);
		$db->query();
		
		// Check migration apply or not
		$this->assertTrue(XiptHelperInstall::changeDefaultAvatar());
		
		// revert XiPT version 
		XiptHelperInstall::updateXiptVersion();		
	}
}