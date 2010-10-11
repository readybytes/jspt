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
		$this->assertEquals($model->getPlugin(44)->name,'Walls');
		$this->assertEquals($model->getPlugin(45)->name,'Feeds');
		$this->assertEquals($model->getPlugin(46)->name,'Groups'); 
	}
}