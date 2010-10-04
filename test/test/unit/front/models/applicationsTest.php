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
		$this->assertEquals($model->getPluginFromId(44)->name,'Walls');
		$this->assertEquals($model->getPluginFromId(45)->name,'Feeds');
		$this->assertEquals($model->getPluginFromId(46)->name,'Groups'); 
	}
	
	function testResetApplicationId()
	{
		$model 	= new XiptModelApplications();
		$model->resetApplicationId(46);
		
		$this->_DBO->addTable('#__xipt_applications');
	}
	
}