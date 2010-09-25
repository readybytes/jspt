<?php
class CoreTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testFieldObject()
  {
  	$fieldobj = XiPTLibraryCore::getFieldObject(1);
  	$result = new stdClass();
  	$result->id = 1;
    $result->type = 'group';
    $result->ordering = 1;
    $result->published = 1;
    $result->min = 10;
    $result->max = 100;
    $result->name = 'Basic Information';
    $result->tips = 'Basicr';
    $result->visible = 1;
    $result->required = 1;
    $result->searchable = 1;
    $result->registration = 1;
    $result->options = '';
    $result->fieldcode ='';

  	$this->assertEquals($fieldobj, $result);
  	
  	$fieldobj = XiPTLibraryCore::getFieldObject(4);
  	$result = new stdClass();
  	$result->id = 4;
    $result->type = 'text';
    $result->ordering = 4;
    $result->published = 1;
    $result->min = 5;
    $result->max = 250;
    $result->name = 'Hometown4';
    $result->tips = 'Hometown4';
    $result->visible = 1;
    $result->required = 0;
    $result->searchable = 1;
    $result->registration = 1;
    $result->options = '';
    $result->fieldcode ='FIELD_HOMETOWN4';

  	$this->assertEquals($fieldobj, $result);
  }
  
  function testUserDataFromCommunity()
  {
  	$this->assertEquals(XiPTLibraryCore::getUserDataFromCommunity(62, 'points'), 12);
  	
  	$this->assertEquals(XiPTLibraryCore::getUserDataFromCommunity(83, 'status'), null);
  	
  	$this->assertEquals(XiPTLibraryCore::getUserDataFromCommunity(87, 'avatar'), 'components/com_community/assets/default.jpg');
  	
  	$this->assertEquals(XiPTLibraryCore::getUserDataFromCommunity(82, 'invite'), 0);
  }
  
  function testUpdateJoomlaUserType()
  {
  	//no updates for admin
  	$this->assertEquals(XiPTLibraryCore::updateJoomlaUserType(62), false);
  	//no updates for nonuser
  	$this->assertEquals(XiPTLibraryCore::updateJoomlaUserType(0), false);
  	
  	//no updates where JUser is none
  	$this->assertEquals(XiPTLibraryCore::updateJoomlaUserType(82, 'None'), false);
  	// test actually it is applying or not 
  	$this->assertTrue(XiPTLibraryCore::updateJoomlaUserType(83, 'Registered'));
  	
	$this->_DBO->addTable('#__users');
	$this->_DBO->filterColumn('#__users','lastvisitDate');
	
  }
  
  function testUpdateCommunityCustomField()
  {
  	XiPTLibraryCore::updateCommunityCustomField(82, 'blueface', 'XIPT_TEMPLATE');
  	
  	$this->_DBO->addTable('#__community_fields_values');
  	
  	XiPTLibraryCore::updateCommunityCustomField(83, 3, 'XIPT_PROFILETYPE');
  	
  	$this->_DBO->addTable('#__community_fields_values');
  	
  	XiPTLibraryCore::updateCommunityCustomField(85, 1, 'XIPT_PROFILETYPE');
  	
  	$this->_DBO->addTable('#__community_fields_values');
  	
  }
  
  function testUpdateCommunityUserWatermark()
  {
  	$this->assertEquals(XiPTLibraryCore::updateCommunityUserWatermark(87, 'test/test/com_xipt/front/images/watermark_2.png'), false);
    $this->assertEquals(XiPTLibraryCore::updateCommunityUserWatermark(82, 'test/test/com_xipt/front/images/watermark_2.png'), true);

  }
  
  function testUpdateCommunityUserAvatar()
  {
  	XiPTLibraryCore::updateCommunityUserAvatar(83, 'test/test/unit/front/images/avatar.jpg');
  	$this->_DBO->addTable('#__community_users');
  }
  
  function xtestUpdateCommunityUserPrivacy()
  {
        XiPTLibraryCore::updateCommunityUserPrivacy(84, 10);
        $this->_DBO->addTable('#__community_users');
  }
  
  function testUpdateCommunityUserGroup()
  {
  	XiPTLibraryCore::updateCommunityUserGroup(82, 1, 2);
  	$this->_DBO->addTable('#__community_groups_members');
  }
  
  function testIsMemberOfGroup()
  {
  	$this->assertEquals(XiPTLibraryCore:: _isMemberOfGroup(82, 1), true);
  	
  	$this->assertEquals(XiPTLibraryCore:: _isMemberOfGroup(84, 1), false);
  }
  
  function testAddUserToGroup()
  {
  	//not a groupId
  	$this->assertEquals(XiPTLibraryCore:: _addUserToGroup(83, 0),false);
  	
  	//already a member of this group
  	$this->assertEquals(XiPTLibraryCore:: _addUserToGroup(84, 4),false);
  	
  	XiPTLibraryCore:: _addUserToGroup(83, 2);
  	$this->_DBO->addTable('#__community_groups_members');
  }
  
  function testRemoveUserFromGroup()
  {
  	XiPTLibraryCore:: _removeUserFromGroup(83, 2);
  	$this->_DBO->addTable('#__community_groups_members');
  }
  
  function testReloadCUser()
  {
  	$this->assertEquals(XiPTLibraryCore::reloadCUser(88), false);
  	$this->assertEquals(XiPTLibraryCore::reloadCUser(83), null);
  }
}
