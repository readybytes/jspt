<?php

class ImagePathTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testSaveAvatar() {
		
		//Test Plugin function onProfileAvatarUpdate
	    JDispatcher::getInstance()->set('_observers',array());
		JPluginHelper::importPlugin('community');
		$subject = JDispatcher::getInstance();
		$obj = new plgCommunityxipt_community($subject, array());
		
		$avatarPath			= 'test/test/unit/front/setup/images/avatar_1.gif';
		$thumbPath			= 'test/test/unit/front/setup/images/avatar_1_thumb.gif';
		$watarmart_avatar	= "test/test/unit/front/setup/images/watr_avatar_1.gif";
		$watarmart_thumb	= "test/test/unit/front/setup/images/watr_avatar_1_thumb.gif";
		
		// Check Avatar is save in Correct folder
		$this->assertTrue($obj->onProfileAvatarUpdate(88,'test/test/unit/front/images/avatar.jpg', $avatarPath ));
		// Check Thumb is save in Correct folder
		$this->assertTrue($obj->onProfileAvatarUpdate(88,'test/test/unit/front/images/thumb_avatar.jpg', $thumbPath ));
			
		// Test water-mark apply on Avatar and thumb
		$this->assertEquals(md5_file(JPATH_ROOT.DS.$avatarPath),md5_file(JPATH_ROOT.DS.$watarmart_avatar));
		$this->assertEquals(md5_file(JPATH_ROOT.DS.$thumbPath),md5_file(JPATH_ROOT.DS.$watarmart_thumb));
		
		//Check Backup File Exist or not and delete thease files for dont effect other test case
		$this->assertTrue(JFile::delete(USER_AVATAR_BACKUP.'/avatar_1.gif'));
		$this->assertTrue(JFile::delete(USER_AVATAR_BACKUP.'/avatar_1_thumb.gif'));

		// Replace avtar and thumb (wid watrmark)
		JFile::copy(JPATH_ROOT.DS.'test/test/unit/front/setup/images/copy_avatar_1.gif', JPATH_ROOT.DS. $avatarPath);
		JFile::copy(JPATH_ROOT.DS.'test/test/unit/front/setup/images/copy_avatar_1_thumb.gif', JPATH_ROOT.DS.$thumbPath);
	}
	
	//Test all image path save in URI formate in DataBase
	function testImagePath()
	{
		$newavatar 		= 'test\test/unit\\front/setup//images/avatar_1.gif';
		$oldavatar		= 'test/test/unit/front/images/avatar.jpg';
		$newavatarthumb	= 'test\test\\unit\\\front/setup/images/avatar_1_thumb.gif';
		
		$this->assertTrue(XiptModelProfiletypes::resetUserAvatar(1,$newavatar,$oldavatar,$newavatarthumb));

		$this->_DBO->addTable('#__community_users');
		$this->_DBO->filterColumn('#__community_users','profile_id');
		$this->_DBO->filterColumn('#__community_users','watermark_hash');
		$this->_DBO->filterColumn('#__community_users','storage');
	}
	
	//Test watrmark Apply or not
	function testWatermark() {
		
		$avatarPath			= JPATH_ROOT.DS.'test/test/unit/front/setup/images/avatar_1.gif';
		$thumbPath			= JPATH_ROOT.DS.'test/test/unit/front/setup/images/avatar_1_thumb.gif';
		$au_avatar			= JPATH_ROOT.DS.'test/test/unit/front/setup/images/copy_avatar_1.gif';
		$au_thumb 			= JPATH_ROOT.DS.'test/test/unit/front/setup/images/copy_avatar_1_thumb.gif';
		$watermark			= 'test/test/unit/front/setup/images/watermark_1.png';
		$watarmart_avatar	= JPATH_ROOT.DS.'test/test/unit/front/setup/images/watr_avatar_1.gif';
		$watarmart_thumb	= JPATH_ROOT.DS.'test/test/unit/front/setup/images/watr_avatar_1_thumb.gif';
		
		// Case::1 Test watrmart not apply on Default avatar
		$this->assertFalse(XiptLibJomsocial::updateCommunityUserWatermark(81,$watermark ));
		
		// Case::2 Test Watemark Apply on custom Avatar
		$this->assertTrue(XiptLibJomsocial::updateCommunityUserWatermark(88, $watermark));
		
		
		// Test water-mark apply on Avatar and thumb
		$this->assertEquals(md5_file($avatarPath),md5_file($watarmart_avatar));
		$this->assertEquals(md5_file($thumbPath),md5_file($watarmart_thumb));
		
		//Check Backup File Exist or not
		$this->assertTrue(JFile::exists(USER_AVATAR_BACKUP.'/avatar_1.gif'));
		$this->assertTrue(JFile::exists(USER_AVATAR_BACKUP.'/avatar_1_thumb.gif'));
		
		//Case::3 When watrmark not exists then restore Image without-watrmart
		XiptLibJomsocial::updateCommunityUserWatermark(88,'');
		//Check image restore or not
		$this->assertEquals(md5_file($avatarPath),md5_file($au_avatar));
		$this->assertEquals(md5_file($thumbPath),md5_file($au_thumb));
		
		//Case::4 When Watermark not apply on Profile Type
		$this->assertFalse(XiptLibJomsocial::updateCommunityUserWatermark(86,$watermark ));
	}
	
	
//testing getRealPath Function
	/**
	 * @dataProvider getConditions
	 */
	function testRealPath($path, $seprator, $result)
	{
		$resultPath = XiptHelperUtils::getRealPath($path, $seprator);
		$this->assertEquals($resultPath, $result);
	}
	
	function getConditions()
	{
		$path1		= '/test/manish\\Trivedi\\RBSL';
		$seprator1	= '/'; 
		$result1	= '/test/manish/Trivedi/RBSL';
		
		$seprator2	= "\\"; 
		$result2	= "\\test\\manish\\Trivedi\\RBSL";
		
		$path3		= 'test/gaurav\\Jain\\RBSL/Developer.jpg';
		$seprator3	= '/'; 
		$result3	= 'test/gaurav/Jain/RBSL/Developer.jpg';
		
		$path4		= 'test/gaurav/Jain/RBSL/Developer.jpg';
		$seprator4	= "\\"; 
		$result4	= "test\\gaurav\\Jain\\RBSL\\Developer.jpg";
		
		$path5		= '\\SSV/GJ/VJ/MT/Developer.jpg';
		$seprator5	= "\\"; 
		$result5	= "\\SSV\\GJ\\VJ\\MT\\Developer.jpg";
		
		$path6		= '/test/manish\\Trivedi\\RBSL/';
		$seprator6	= '/'; 
		$result6	= '/test/manish/Trivedi/RBSL/';
		
		$path7		= '\\test/manish/Trivedi/RBSL/';
		$seprator7	= "\\"; 
		$result7	= "\\test\\manish\\Trivedi\\RBSL\\";
		
		return Array(
					array($path1, $seprator1, $result1),
					array($path1, $seprator2, $result2),
					array($path3, $seprator3, $result3),
					array($path4, $seprator4, $result4),
					array($path5, $seprator5, $result5),
					array($path6, $seprator6, $result6),
					array($path7, $seprator7, $result7)
					);	
	}
}