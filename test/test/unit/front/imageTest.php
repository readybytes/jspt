<?php

class ImageTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testHtml2rgb()
  {
  	$row	= JTable::getInstance( 'profiletypes' , 'XiptTable' );
	$row->load(2);
	$config = new JParameter('','');
	$config->bind($row->watermarkparams);
	
  	$image = new XiptLibImage($config);
  	
  	//case #1: if color starts with # then remove # from string
  	$color = $image->_html2rgb('#FFFFFF');
  	$result = array(255, 255, 255);
  	$this->assertEquals($color, $result);
  	
  	//case #2 : if color string length is 6
  	$color = $image->_html2rgb('68A6D0');
  	$result = array(104, 166, 208);
  	$this->assertEquals($color, $result);
  	
  	//case #3 : if color string length is 3
  	$color = $image->_html2rgb('45D');
  	$result = array(68, 85, 221);
  	$this->assertEquals($color, $result);
  }
  
  function testGenImage()
  {
  	//case #1: when folder already exists
  	$row	= JTable::getInstance( 'profiletypes' , 'XiptTable' );
	$row->load(3);
	$config = new JParameter('','');
	$config->bind($row->watermarkparams);
	
  	$image = new XiptLibImage($config);
  	
  	$result = $image->genImage(PROFILETYPE_AVATAR_STORAGE_PATH, 'watermark_8');
  	$this->assertEquals('watermark_8.png', $result);
  	
  	//case #2: when folder does not exist

	$row->load(2);
	$config->bind($row->watermarkparams);
	
  	$image = new XiptLibImage($config);
  	
  	$filepath = JPATH_ROOT .DS.'images'.DS.'test';
  	$result   = $image->genImage($filepath, 'watermark_2');
  	
  	$this->assertEquals('watermark_2.png', $result);
  	$this->assertTrue(JFolder::exists($filepath));
  }
}