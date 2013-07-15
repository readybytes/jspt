<?php
class JomsocialTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testFieldObject()
  {
  	$fieldobj = XiptLibJomsocial::getFieldObject(1);
  	$result 				= new stdClass();
  	$result->id 			= 1;
    $result->type 			= 'group';
    $result->ordering 		= 1;
    $result->published 		= 1;
    $result->min 			= 10;
    $result->max 			= 100;
    $result->name 			= 'Basic Information';
    $result->tips 			= 'Basicr';
    $result->visible 		= 1;
    $result->required 		= 1;
    $result->searchable 	= 1;
    $result->registration 	= 1;
    $result->options 		= '';
    $result->fieldcode 		= '';
	$result->params 		= '';
    	

  	$this->assertEquals($fieldobj, $result);
  	
  	$fieldobj = XiptLibJomsocial::getFieldObject(4);
  	$result 				= new stdClass();
  	$result->id 			= 4;
    $result->type 			= 'text';
    $result->ordering 		= 4;
    $result->published 		= 1;
    $result->min 			= 5;
    $result->max 			= 250;
    $result->name 			= 'Hometown4';
    $result->tips 			= 'Hometown4';
    $result->visible 		= 1;
    $result->required 		= 0;
    $result->searchable 	= 1;
    $result->registration   = 1;
    $result->options 		= '';
    $result->fieldcode 		= 'FIELD_HOMETOWN4';
    $result->params 		= '';

  	$this->assertEquals($fieldobj, $result);
  	
  	//checking caching
  	$fieldobj = XiptLibJomsocial::getFieldObject(1);
  	$result 				= new stdClass();
  	$result->id 			= 1;
    $result->type 			= 'group';
    $result->ordering 		= 1;
    $result->published 		= 1;
    $result->min 			= 10;
    $result->max 			= 100;
    $result->name 			= 'Basic Information';
    $result->tips 			= 'Basicr';
    $result->visible 		= 1;
    $result->required 		= 1;
    $result->searchable 	= 1;
    $result->registration   = 1;
    $result->options 		= '';
    $result->fieldcode 		= '';
	$result->params 		= '';
    
  	$this->assertEquals($fieldobj, $result);
  }
  
  function testUpdateJoomlaUserType()
  {
  	//case #1: no updates for admin
  	$adminId = 62;
  	if(XIPT_JOOMLA_16)
  		$adminId = 42;

  	$this->assertFalse(XiptLibJomsocial::updateJoomlaUserType($adminId));
	
  	//case #2: no updates for nonuser
  	$this->assertFalse(XiptLibJomsocial::updateJoomlaUserType(0));
	
  	//case #3: no updates where JUser is none
  	$this->assertFalse(XiptLibJomsocial::updateJoomlaUserType(82, JOOMLA_USER_TYPE_NONE));
	
  	//case #4: test actually it is applying or not 
  	$this->assertTrue(XiptLibJomsocial::updateJoomlaUserType(83, 'Registered'));
  	
	$this->_DBO->addTable('#__users');
	$this->_DBO->filterColumn('#__users','lastvisitDate');
	$this->_DBO->filterColumn('#__users', 'params');
  }
  
  //XITODO : check this test case
  function xxtestUpdateCommunityConfig()
  {
  		//case #1 when user is guest return true
         $instance                 = new JParameter('', '');
         $this->assertTrue(XiptLibJomsocial::updateCommunityConfig(&$instance, 0));
         $this->assertEquals($instance->get('enableterms'), 1);
         
         //case #2 when user is not guest
         $instance                 = new JParameter('', '');
         $this->assertTrue(XiptLibJomsocial::updateCommunityConfig(&$instance, 84));
         $this->assertEquals($instance->get('enablemyblogicon'), 1);
         
         //#case 3 : Templates
         //#case 3.1: when guest is looking user profile, don't set template
         $instance                 = new JParameter('', '');
         $this->assertTrue(XiptLibJomsocial::updateCommunityConfig(&$instance, 0));
         $this->assertEquals($instance->get('template'), '');
         
         //#case 3.2: when guest is looking user profile, set template as per visiting user
         $instance                 = new JParameter('', '');
         JRequest::setVar('userid', 82,'POST');
         $this->assertTrue(XiptLibJomsocial::updateCommunityConfig(&$instance, 84));
         $this->assertEquals($instance->get('template'), 'default');
         
         //#case 3.3: when guest is looking user profile, set template as per visiting user
         $instance                 = new JParameter('', '');
         JRequest::setVar('userid', 83,'POST');
         $this->assertTrue(XiptLibJomsocial::updateCommunityConfig(&$instance, 83));
         $this->assertEquals($instance->get('template'), 'blueface');
         
         //#case 3.4: when guest is looking user profile, set template as per visiting user
         $instance                 = new JParameter('', '');
         JRequest::setVar('userid', 84,'POST');
         $this->assertTrue(XiptLibJomsocial::updateCommunityConfig(&$instance, 82));
         $this->assertEquals($instance->get('template'), 'blackout');
  }
  
  function testUpdateCommunityCustomField()
  {
  	//case # 1: test it for template
  	$this->assertTrue(XiptLibJomsocial::updateCommunityCustomField(82, 'blueface', 'XIPT_TEMPLATE'));
  	
  	//case # 2: test it for profiletype
  	$this->assertTrue(XiptLibJomsocial::updateCommunityCustomField(83, 3, 'XIPT_PROFILETYPE'));
  	$this->assertTrue(XiptLibJomsocial::updateCommunityCustomField(85, 1, 'XIPT_PROFILETYPE'));
  	
  	//case # 3: test it when user is not in community_fields_values table
  	$this->assertTrue(XiptLibJomsocial::updateCommunityCustomField(81, 'blackout', 'XIPT_TEMPLATE'));
  	$this->_DBO->addTable('#__community_fields_values');
  	
  }
  
  function testUpdateCommunityUserWatermark()
  {
  	//case #1: when user has default avatar, don't apply watermark 
  	$this->assertFalse(XiptLibJomsocial::updateCommunityUserWatermark(87, 'test/test/com_xipt/front/images/watermark_2.png'));
  	
  	//case #2: when user has custom avatar, apply watermark
//  	$tmpFile = PROFILETYPE_AVATAR_STORAGE_PATH.DS."tmp.jpg";
//  	if(JFile::exists($tmpFile))
//  		$this->assertTrue(JFile::delete($tmpFile),$tmpFile);
  		 
    $this->assertTrue(XiptLibJomsocial::updateCommunityUserWatermark(82, 'test/test/com_xipt/front/images/watermark_2.png'));

    //case #3: when watermark is blank restore backedup avatar 
    $this->assertTrue(XiptLibJomsocial::updateCommunityUserWatermark(86, ''));
    
  }
  
  function testUserDataFromCommunity()
  {
  	$users  = array(62, 83, 87, 82, 62);
  	if(XIPT_JOOMLA_16)
  		$users  = array(42, 83, 87, 82, 42);
  	$what   = array('points', 'status', 'avatar', 'invite', 'points');
  	
  	$output = array(12, null, 'components/com_community/assets/default.jpg', 0, 12);
  	
  	foreach($users as $key => $value)
  	{
  		$result = self::getUserData($value, $what[$key]);
  		$this->assertEquals($result, $output[$key]);
  	}
  }
  
  //will return data as per userid & field
  function getUserData($userid, $what)
  {
  	$data = XiptLibJomsocial::getUserDataFromCommunity($userid, $what);
  	return $data;
  }
  
  function testUpdateCommunityUserDefaultAvatar()
  {
  	$this->assertTrue(XiptLibJomsocial::updateCommunityUserDefaultAvatar(83, 'test/test/unit/front/images/avatar.jpg'));
  	$this->_DBO->addTable('#__community_users');
  }
  
  //XITODO: In J1.7 privacy saves in different manner
  function xxtestUpdateCommunityUserPrivacy()
  {
  		$privacy = array('notifyEmailSystem' =>1, 'privacyProfileView' =>10, 'privacyPhotoView' =>1);
        XiptLibJomsocial::updateCommunityUserPrivacy(84, $privacy);
        $this->_DBO->addTable('#__community_users');
  }
  
  function testUpdateCommunityUserGroup()
  {
  	//update user group
  	XiptLibJomsocial::updateCommunityUserGroup(82, 1, 2);
  	$this->_DBO->addTable('#__community_groups_members');
  }
  
  function testIsMemberOfGroup()
  {
  	//will return true if user is member of group
  	$this->assertEquals(XiptLibJomsocial:: _isMemberOfGroup(82, 1), true);
  	
  	//will return false if user is not a member of group
  	$this->assertEquals(XiptLibJomsocial:: _isMemberOfGroup(84, 1), false);
  }
  
  function testAddUserToGroup()
  {
  	//assert false when group is blank
 	$this->assertFalse(XiptLibJomsocial:: _addUserToGroup(82, ''));
	
  	//assert false when group is none
  	$this->assertFalse(XiptLibJomsocial:: _addUserToGroup(83, NONE));
  	
  	//already a member of this group, then don't add it
  	$this->assertTrue(XiptLibJomsocial:: _addUserToGroup(84, 4));
  	
  	//if user is not a member of group then add it
  	$this->assertTrue(XiptLibJomsocial:: _addUserToGroup(83, 2));
  	
  	//if user is not a member of group then add it
  	$this->assertTrue(XiptLibJomsocial:: _addUserToGroup(83, '3,4'));
  	$this->_DBO->addTable('#__community_groups_members');
  	if(!TEST_XIPT_JOOMLA_17)
  		$this->_DBO->filterOrder('#__community_groups_members', 'groupid');
  }
  
  function testRemoveUserFromGroup()
  {
  	//assert false when group is blank
 	$this->assertFalse(XiptLibJomsocial:: _removeUserFromGroup(82, ''));
	
  	//don't remove user when user is owner of group
  	if(XIPT_JOOMLA_15)
  	$this->assertTrue(XiptLibJomsocial:: _removeUserFromGroup(62, 1));
  	else 
  	$this->assertTrue(XiptLibJomsocial:: _removeUserFromGroup(42, 1));
  	
  	
  	//do nothing when user is not member of group
  	$this->assertTrue(XiptLibJomsocial:: _removeUserFromGroup(84, 1));
  	
  	//remove user from group
  	$this->assertTrue(XiptLibJomsocial:: _removeUserFromGroup(83, 2));
  	
  	//remove user from group where user exists
  	$this->assertTrue(XiptLibJomsocial:: _removeUserFromGroup(83, '2,3'));
  	$this->_DBO->addTable('#__community_groups_members');
  }
  
  function xxxtestReloadCUser()
  {
  	
  	//if userid does not exist, return false
  	$this->assertEquals(XiptLibJomsocial::reloadCUser(0), false);
  	
  	//Without Reload
  	$cuser83 = CFactory::getUser(83);
	
  	$juser83_2 = JFactory::getUser(83);
	$juser83_2->set('sendEmail',47);
	$juser83_2->save();	
	$cuser83->setStatus('NewStatus');

	$user83New = CFactory::getUser(83);
	$this->assertEquals($user83New->getStatus(),'NewStatus');
	$this->assertEquals($user83New->get('sendEmail'),0);
	
	// With Reload
	$cuser84 = CFactory::getUser(84);
	$juser84_2 = JFactory::getUser(84);
	$juser84_2->set('sendEmail',47);
	$juser84_2->save();
	XiptLibJomsocial::reloadCUser(84);
	
	$cuser84->setStatus('NewStatus');	
	XiptLibJomsocial::reloadCUser(84);
	
 	$user84New = CFactory::getUser(84);
	$this->assertEquals($user84New->getStatus(),'NewStatus');
	$this->assertEquals($user84New->get('sendEmail'),47);

  }
  
  // we are not using this function anymore
  function xxtestChangeAvatarOnSyncUp()
  {
  	//case #1: return false when task is not syncUpUserPT
  	$this->assertFalse(XiptLibJomsocial::_changeAvatarOnSyncUp('',''));
  	
  	//case #2: return true when task is syncUpUserPT
  	$this->assertTrue(XiptLibJomsocial::_changeAvatarOnSyncUp('images/profiletype/avatar_2.gif','syncUpUserPT'));
  	
  	//case #3: return false when task is syncUpUserPT but user avatar is blank
  	$this->assertFalse(XiptLibJomsocial::_changeAvatarOnSyncUp('','syncUpUserPT'));
  }
  //XITODO : clean this testcase
  function xtestRestoreBackUpAvatar()
  {
  	$testFile = dirname(__FILE__).DS.'images'.DS.'avatar.jpg';
  	$this->assertTrue(JFile::copy($testFile , USER_AVATAR_BACKUP.DS.'avatar_2.gif'));
  	
  	$this->assertTrue(XiptLibJomsocial::restoreBackUpAvatar('images/profiletype/avatar_2.gif'));  	
  	
  	$md5_bkup_avatar  = md5(JFile::read(USER_AVATAR_BACKUP.DS.'avatar_2.gif'));
	$md5_new_avatar  = md5(JFile::read(PROFILETYPE_AVATAR_STORAGE_PATH.DS.'avatar_2.gif'));
	$this->assertEquals($md5_bkup_avatar, $md5_new_avatar);
  }
  
  function testCleanStaticCache()
  {
  	//this will return false by default
  	$this->assertFalse(XiptLibJomsocial::cleanStaticCache(false));
  	$this->assertFalse(XiptLibJomsocial::cleanStaticCache());
  	
  	//will return true
  	$this->assertTrue(XiptLibJomsocial::cleanStaticCache(true));
  	
  	//will return true because of caching
  	$this->assertTrue(XiptLibJomsocial::cleanStaticCache());
  }
}
