<?php

//require_once(JPATH_ROOT.DS.'components'.DS.'com_xiec'.DS.'libraries'.DS.'base'.DS.'table.php');

class XiptApplicationsModelTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetPluginFromId()
	{
		$model 	= new XiptModelApplications();
		$this->assertEquals($model->getPlugin(XIPT_TEST_COMMUNITY_WALLS)->name, 'Walls');
		$this->assertEquals($model->getPlugin(XIPT_TEST_COMMUNITY_FEEDS)->name, 'Feeds');
		$this->assertEquals($model->getPlugin(XIPT_TEST_COMMUNITY_ARTICLES)->name, 'My Articles');	
	}
}