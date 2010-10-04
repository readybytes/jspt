<?php

//require_once(JPATH_ROOT.DS.'components'.DS.'com_xiec'.DS.'libraries'.DS.'base'.DS.'table.php');

class XiptProfilefieldsModelTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testResetFieldId()
	{
		$model 	= new XiptModelProfilefields();
		
		$model->resetFieldId(3);
		
		$this->_DBO->addTable('#__xipt_profilefields');
	}
	
}