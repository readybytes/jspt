<?php

class XiptProfiletypesHelperTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	//XITODO 
	function xxtestBuildTypes()
	{
		// for profiletype 1
		$html = $this->cleanWhiteSpaces('<select name="profiletypes" id="profiletypes" class="inputbox">'
				.'<option value="1" selected="selected">ProfileType1</option>'
				.'<option value="2" >ProfileType2</option>'
				.'</select>');
		$this->assertEquals($this->cleanWhiteSpaces(XiptHelperProfiletypes::buildTypes(1,'profiletypes')),$html);
		// for profiletype 1
		$html = $this->cleanWhiteSpaces('<select name="profiletypes" id="profiletypes" class="inputbox">'
				.'<option value="1" >ProfileType1</option>'
				.'<option value="2"  selected="selected">ProfileType2</option>'
				.'</select>');
		$this->assertEquals($this->cleanWhiteSpaces(XiptHelperProfiletypes::buildTypes(2,'profiletypes')),$html);
		
		// for groups
		$html = '<selectname="group[]"id="group"class="inputbox"size="3"multiple>'
				.'<optionvalue="1"selected="selected">Group1</option>'
				.'<optionvalue="2">Group2</option><optionvalue="3">Group3</option>'
				.'<optionvalue="0">None</option></select>';
		$this->assertEquals($this->cleanWhiteSpaces(XiptHelperProfiletypes::buildTypes(1,'group')),$html);
		
		// for privacy members
		$html = '<selectname="privacy"id="privacy"class="inputbox"><optionvalue="friends">friends</option><optionvalue="members"selected="selected">members</option><optionvalue="public">public</option></select>';
		$this->assertEquals($this->cleanWhiteSpaces(XiptHelperProfiletypes::buildTypes('members','privacy')),$html);
		
		// for privacy friends
		$html = '<selectname="privacy"id="privacy"class="inputbox"><optionvalue="friends"selected="selected">friends</option><optionvalue="members">members</option><optionvalue="public">public</option></select>';
		$this->assertEquals($this->cleanWhiteSpaces(XiptHelperProfiletypes::buildTypes('friends','privacy')),$html);
		
		// for template bubble
		$html = '<selectname="template"id="template"class="inputbox"><optionvalue="default">default</option><optionvalue="blackout">blackout</option><optionvalue="bubble"selected="selected">bubble</option><optionvalue="blueface">blueface</option></select>';
		$this->assertEquals($this->cleanWhiteSpaces(XiptHelperProfiletypes::buildTypes('bubble','template')),$html);
		
		// for jusertype Publisher
		$html = '<selectname="jusertype"id="jusertype"class="inputbox"><optionvalue="Registered">Registered</option><optionvalue="Author">Author</option><optionvalue="Editor">Editor</option><optionvalue="Publisher"selected="selected">Publisher</option><optionvalue="Manager">Manager</option><optionvalue="Administrator">Administrator</option></select>';
		$this->assertEquals($this->cleanWhiteSpaces(XiptHelperProfiletypes::buildTypes('Publisher','jusertype')),$html);		
	} 
	
	function testGetGroups()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testBuildTypes.start.sql');
		$result = XiptHelperProfiletypes::getGroups();
		$this->assertEquals($result[0]->id,1);
		$this->assertEquals($result[1]->id,2);
	} 
	
	function testGetProfileTypeData()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testBuildTypes.start.sql');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeData(2,'name'),'ProfileType2');
		//$this->assertEquals(XiptHelperProfiletypes::getProfileTypeData(1,'privacy'),"privacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n");
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeData(2,'template'),'blueface');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeData(1,'template'),'default');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeData(0,'name'),'All');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeData(0,'group'),0);
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeData(1,'group'),0);
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeData(2,'group'),'1,2');
	}
	
	function testGetProfileTypeName()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testBuildTypes.start.sql');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeName(2),'ProfileType2');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeName(1),'ProfileType1');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeName(1,true),'ProfileType1');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeName(0,true),'All');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeName(-1,true),'None');
		//$this->assertEquals(XiptHelperProfiletypes::getProfileTypeName(-1,false),'All');
	}
	
	function testGetProfileTypeAraay()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testBuildTypes.start.sql');
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeArray(),array(1,2));
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeArray(true),array(1,2,0));
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeArray(false,true),array(1,2,-1));
		$this->assertEquals(XiptHelperProfiletypes::getProfileTypeArray(true,true),array(1,2,0,-1));
	}
	
	function testResetAllUsers()
	{
		// profiletype1 watermark images/profiletypes/watermark_1.png
		$records = XiptFactory::getInstance('profiletypes','model')->loadRecords();
		$p1Data = clone $records[1];
		$p1Data->template 	= 'blackout';
		$p1Data->group 		= '1';
		$p1Data->watermark 	= '/images/profiletypes/watermark_3.png';
		$p1Data->avatar		= 'components/com_community/assets/group.jpg';
		$p1Data->privacy 	= new JParameter('');
		XiptHelperProfiletypes::resetAllUsers(1,$records[1],$p1Data);
		
		$this->_DBO->addTable('#__community_users');
		$this->_DBO->addTable('#__xipt_users');
		$this->_DBO->addTable('#__community_groups_members');
	}
}
