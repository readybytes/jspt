<?php
class XiptpluginTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testDoRevert()
	{
		$obj = new XiptSetupRuleXiptplugin();
		$this->assertTrue($obj->doRevert());
		$this->assertFalse($obj->_isPluginInstalledAndEnabled());
		//$this->_DBO->addTable('#__plugins');
	}
	
	function testIsApplicable()
	{
		$obj = new XiptSetupRuleXiptplugin();
		$this->assertTrue($obj->isApplicable());
	}
	
	function testIsPluginInstalledAndEnabled()
	{
		//#case 1: when both plugins are installed & enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->changePluginState('xipt_system', 1);
		$this->changePluginState('xipt_community', 1);
		$this->assertTrue($obj->_isPluginInstalledAndEnabled());
		
		//#case 2: when both plugins are installed but not enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->changePluginState('xipt_system', 0);
		$this->changePluginState('xipt_community', 0);
		$this->assertFalse($obj->_isPluginInstalledAndEnabled());
		
		//#case 3: when both plugins are installed but one is not enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->changePluginState('xipt_system', 0);
		$this->changePluginState('xipt_community', 1);
		$this->assertFalse($obj->_isPluginInstalledAndEnabled());
	}
	
	function testIsRequired()
	{
		//#case 1: when both plugins are installed but not enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->changePluginState('xipt_system', 0);
		$this->changePluginState('xipt_community', 0);
		//XiptLibJomsocial::saveValueinJSConfig(1);
		$this->assertTrue($obj->isRequired());
		
		//#case 2: when both plugins are installed but one is not enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->changePluginState('xipt_system', 0);
		$this->changePluginState('xipt_community', 1);
		$this->assertTrue($obj->isRequired());
		
		//#case 3: when both plugins are installed & enabled and multiprofiletype is also enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->changePluginState('xipt_system', 1);
		$this->changePluginState('xipt_community', 1);
		$this->assertFalse($obj->isRequired());
	}
	
	function testDoApply()
	{
		$obj = new XiptSetupRuleXiptplugin();
		$this->assertEquals($obj->doApply(), 'COM_XIPT_JS_MULTIPROFILETYPE_DISABLEDCOM_XIPT_PLUGINS_ENABLED_SUCCESSFULLYCOM_XIPT_CUSTOM_FIELD_ALREADY_CREATED_AND_ENABLED_SUCCESSFULLYCOM_XIPT_FILES_PATCHED_SUCCESSFULLY');
		//$this->_DBO->addTable('#__plugins');
	}
}