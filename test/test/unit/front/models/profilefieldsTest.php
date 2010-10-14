<?php

//require_once(JPATH_ROOT.DS.'components'.DS.'com_xiec'.DS.'libraries'.DS.'base'.DS.'table.php');

class XiptProfilefieldsModelTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
  function testNotSelectedFieldForProfiletype()
  {
  	$model 	= new XiptModelProfilefields();
  	//this will return fid for allowed category and Profiletype1.
  	$fid = $model->getNotSelectedFieldForProfiletype(1, 0);
  	$result = array(4);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for allowed category and Profiletype2.
  	$fid = $model->getNotSelectedFieldForProfiletype(2, 0);
  	$result = array(3);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for allowed category and Profiletype3.
  	$fid = $model->getNotSelectedFieldForProfiletype(3, 0);
  	$result = array();
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for allowed category and Profiletype4.
  	$fid = $model->getNotSelectedFieldForProfiletype(4, 0);
  	$result = array(4,3);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for required category and Profiletype1.
  	$fid = $model->getNotSelectedFieldForProfiletype(1, 1);
  	$result = array(5,4);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for required category and Profiletype2.
  	$fid = $model->getNotSelectedFieldForProfiletype(2, 1);
  	$result = array(4,3,2);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for required category and Profiletype3.
  	$fid = $model->getNotSelectedFieldForProfiletype(3, 1);
  	$result = array(5,3);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for required category and Profiletype4.
  	$fid = $model->getNotSelectedFieldForProfiletype(4, 1);
  	$result = array(5,4,3,2);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for visible category and Profiletype1.
  	$fid = $model->getNotSelectedFieldForProfiletype(1, 2);
  	$result = array(4,3);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for visible category and Profiletype2.
  	$fid = $model->getNotSelectedFieldForProfiletype(2, 2);
  	$result = array(5,4,3,2);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for visible category and Profiletype3.
  	$fid = $model->getNotSelectedFieldForProfiletype(3, 2);
  	$result = array();
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for visible category and Profiletype4.
  	$fid = $model->getNotSelectedFieldForProfiletype(4, 2);
  	$result = array(5,4,3,2);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for editable after reg category and Profiletype1.
  	$fid = $model->getNotSelectedFieldForProfiletype(1, 3);
  	$result = array(5,4,2);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for editable after reg category and Profiletype2.
  	$fid = $model->getNotSelectedFieldForProfiletype(2, 3);
  	$result = array(4,3);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for editable after reg category and Profiletype3.
  	$fid = $model->getNotSelectedFieldForProfiletype(3, 3);
  	$result = array(3,2);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for editable after reg category and Profiletype4.
  	$fid = $model->getNotSelectedFieldForProfiletype(4, 3);
  	$result = array(5,4,3);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for editable during reg category and Profiletype2.
  	$fid = $model->getNotSelectedFieldForProfiletype(1, 4);
  	$result = array(4,3);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for editable during reg category and Profiletype2.
  	$fid = $model->getNotSelectedFieldForProfiletype(2, 4);
  	$result = array(4,3,2);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for editable during reg category and Profiletype2.
  	$fid = $model->getNotSelectedFieldForProfiletype(3, 4);
  	$result = array(5);
  	$this->assertEquals($fid,$result);
  	
  	//this will return fid for editable during reg category and Profiletype2.
  	$fid = $model->getNotSelectedFieldForProfiletype(4, 4);
  	$result = array(5,4,3,2);
  	$this->assertEquals($fid,$result);
  }
  
  function testFieldsForProfiletype()
  {
  	$model 	= new XiptModelProfilefields();
  	//basic 
  	$inputfields = array(array('id'=>1), array('id'=>2), array('id'=>3) ,array('id'=>4));
  	$outputfields = array(array('id'=>1), array('id'=>2), array('id'=>3) ,array('id'=>4));
  	$notSelectedFields = array(
  		"ALLOWED" 	=> array(),
  		"REQUIRED" 	=> array(),
  		"VISIBLE" 	=> array(),
  		"EDITABLE_AFTER_REG" 	=> array(),
  		"EDITABLE_DURING_REG" 	=> array()
  		);
  		
  	$result = $model->getFieldsForProfiletype($inputfields,2,'getViewableProfile', $notSelectedFields);
  	$this->assertEquals($inputfields,$outputfields);
  	
  	//test allowed
  	$inputfields = array(array('id'=>1), array('id'=>2), array('id'=>3) ,array('id'=>4));
  	$outputfields = array(array('id'=>1), array('id'=>2), array('id'=>3));
  	$notSelectedFields = array(
  		"ALLOWED" 	=> array(4),
  		"REQUIRED" 	=> array(),
  		"VISIBLE" 	=> array(),
  		"EDITABLE_AFTER_REG" 	=> array(),
  		"EDITABLE_DURING_REG" 	=> array()
  		);
  		
  	$result = $model->getFieldsForProfiletype($inputfields,2,'getViewableProfile', $notSelectedFields);
  	$this->assertEquals($inputfields,$outputfields);
  	
  	//test required
  	$inputfields = array(array('id'=>1), array('id'=>2), array('id'=>3) ,array('id'=>4));
  	$outputfields = array(array('id'=>1), array('id'=>2), array('id'=>3),array('id'=>4, 'required'=>0));
  	$notSelectedFields = array(
  		"ALLOWED" 	=> array(),
  		"REQUIRED" 	=> array(4),
  		"VISIBLE" 	=> array(),
  		"EDITABLE_AFTER_REG" 	=> array(),
  		"EDITABLE_DURING_REG" 	=> array()
  		);
  		
  	$result = $model->getFieldsForProfiletype($inputfields,2,'getViewableProfile', $notSelectedFields);
  	$this->assertEquals($inputfields,$outputfields);
  	
  	//test visible
  	$inputfields = array(array('id'=>1), array('id'=>2), array('id'=>3) ,array('id'=>4));
  	$outputfields = array(array('id'=>1), array('id'=>2), array('id'=>3));
  	$notSelectedFields = array(
  		"ALLOWED" 	=> array(),
  		"REQUIRED" 	=> array(),
  		"VISIBLE" 	=> array(4),
  		"EDITABLE_AFTER_REG" 	=> array(),
  		"EDITABLE_DURING_REG" 	=> array()
  		);
  		
  	$result = $model->getFieldsForProfiletype($inputfields,2,'getViewableProfile', $notSelectedFields);
  	$this->assertEquals($inputfields,$outputfields);
  	
  	//test EDITABLE_AFTER_REG
  	$inputfields = array(array('id'=>1), array('id'=>2), array('id'=>3) ,array('id'=>4));
  	$outputfields = array(array('id'=>2), array('id'=>3), array('id'=>4));
  	$notSelectedFields = array(
  		"ALLOWED" 	=> array(),
  		"REQUIRED" 	=> array(),
  		"VISIBLE" 	=> array(),
  		"EDITABLE_AFTER_REG" 	=> array(1),
  		"EDITABLE_DURING_REG" 	=> array()
  		);
  		
  	$result = $model->getFieldsForProfiletype($inputfields,2,'getEditableProfile', $notSelectedFields);
  	$this->assertEquals($inputfields,$outputfields);
  	
  	//test EDITABLE_DURING_REG
  	$inputfields = array(array('id'=>1), array('id'=>2), array('id'=>3) ,array('id'=>4));
  	$outputfields = array(array('id'=>2), array('id'=>3), array('id'=>4));
  	$notSelectedFields = array(
  		"ALLOWED" 	=> array(),
  		"REQUIRED" 	=> array(),
  		"VISIBLE" 	=> array(),
  		"EDITABLE_AFTER_REG" 	=> array(),
  		"EDITABLE_DURING_REG" 	=> array(1)
  		);
  		
  	$result = $model->getFieldsForProfiletype($inputfields,2,'', $notSelectedFields);
  	$this->assertEquals($inputfields,$outputfields);
  	
  	}
}