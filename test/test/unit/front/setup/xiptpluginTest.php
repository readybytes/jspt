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
		$this->_DBO->addTable('#__plugins');
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
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testDoRevert.start.sql');
		$this->assertTrue($obj->_isPluginInstalledAndEnabled());
		
		//#case 2: when both plugins are installed but not enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testDoApply.start.sql');
		$this->assertFalse($obj->_isPluginInstalledAndEnabled());
		
		//#case 3: when both plugins are installed but one is not enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testIsPluginInstalledAndEnabled.start.sql');
		$this->assertFalse($obj->_isPluginInstalledAndEnabled());
	}
	
	function testIsRequired()
	{
		//#case 1: when both plugins are installed & enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testDoRevert.start.sql');
		$this->assertFalse($obj->isRequired());
		
		//#case 2: when both plugins are installed but not enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testDoApply.start.sql');
		$this->assertTrue($obj->isRequired());
		
		//#case 3: when both plugins are installed but one is not enabled
		$obj = new XiptSetupRuleXiptplugin();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testIsPluginInstalledAndEnabled.start.sql');
		$this->assertTrue($obj->isRequired());
	}
	
	function testDoApply()
	{
		$obj = new XiptSetupRuleXiptplugin();
		$this->assertEquals($obj->doApply(), 'PLUGIN ENABLED SUCCESSFULLY');
		$this->_DBO->addTable('#__plugins');
	}
}