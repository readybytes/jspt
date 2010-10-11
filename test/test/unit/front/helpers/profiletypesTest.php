<?php

class XiptProfiletypesHelperTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testBuildTypes()
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
		$this->assertEquals($this->cleanWhiteSpaces(XiptHelperProfiletypes::buildTypes('2','profiletypes')),$html);
		
		// for groups
		$html = '<selectname="group[]"id="group"class="inputbox"size="3"multiple>'
				.'<optionvalue="1"selected="selected">Group1</option>'
				.'<optionvalue="2">Group2</option><optionvalue="3">Group3</option>'
				.'<optionvalue="0">None</option></select>';
		$this->assertEquals($this->cleanWhiteSpaces(XiptHelperProfiletypes::buildTypes('1','group')),$html);
		
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
	}
}
