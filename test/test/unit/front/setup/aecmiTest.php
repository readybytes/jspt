<?php
class AecmiTest extends XiUnitTestCase 
{

  function testIsRequired()
  {
  	$miFilename = JPATH_ROOT.DS.'components'.DS.'com_acctexp'.DS.'micro_integration'.DS.'mi_jomsocialjspt.php';
  	$this->assertTrue(JFile::exists($miFilename));
  	
  	$obj = new XiptSetupRuleAecmi();
  	//#case 1: return true when file doesn't exist
  	JFile::move('mi_jomsocialjspt.php', 'mi_jomsocialjspt1.php', JPATH_ROOT . DS . 'components'.DS.'com_acctexp'.DS.'micro_integration');
  	$this->assertFalse(JFile::exists($miFilename));
  	$this->assertTrue($obj->isRequired());
  	
  	//#case 2: return false when file exists
  	JFile::move('mi_jomsocialjspt1.php', 'mi_jomsocialjspt.php', JPATH_ROOT . DS . 'components'.DS.'com_acctexp'.DS.'micro_integration');
  	$this->assertTrue(JFile::exists($miFilename));
  	$this->assertFalse($obj->isRequired());
  	
  }
  
  function testDoApply()
  {
  	$obj = new XiptSetupRuleAecmi();
  	$miFilename = JPATH_ROOT.DS.'components'.DS.'com_acctexp'.DS.'micro_integration'.DS.'mi_jomsocialjspt.php';
  	
  	//#case 1: when file exists
  	$this->assertTrue(JFile::exists($miFilename));
  	$this->assertEquals($obj->doApply(), 'AEC MI ALREADY EXIST');
  	
  	//#case 2: when file doesn't exist
  	JFile::move('mi_jomsocialjspt.php', 'mi_jomsocialjspt1.php', JPATH_ROOT . DS . 'components'.DS.'com_acctexp'.DS.'micro_integration');
  	$this->assertFalse(JFile::exists($miFilename));
  	$this->assertEquals($obj->doApply(), 'AEC MI COPIED SUCCESSFULLY');
  }
  
  function testIsApplicable()
  {
  	$obj = new XiptSetupRuleAecmi();
  	$aecFront = JPATH_ROOT . DS . 'components' . DS . 'com_acctexp';
 	$this->assertTrue(JFolder::exists($aecFront));
 	
  	//#case 1: when ace doesn't exist, AEC MI installtion is not required
  	JFolder::move('com_acctexp', 'com_acctexp11', JPATH_ROOT . DS . 'components');
  	$this->assertFalse(JFolder::exists($aecFront));
  	$this->assertFalse($obj->isApplicable());
  	
  	//#case 2: when ace exists, AEC MI installtion is required
  	JFolder::move('com_acctexp11', 'com_acctexp', JPATH_ROOT . DS . 'components');
  	$this->assertTrue(JFolder::exists($aecFront));
  	$this->assertTrue($obj->isApplicable());
  }
  
  function testDoRevert()
  {
  	$obj = new XiptSetupRuleAecmi();
  	$this->assertTrue($obj->doRevert());
  }
  
  function xxxtestGetMessage()
  {
  	$obj = new XiptSetupRuleAecmi();
  	//#case 1: when file doesn't exist
  	JFile::move('mi_jomsocialjspt.php', 'mi_jomsocialjspt1.php', JPATH_ROOT . DS . 'components'.DS.'com_acctexp'.DS.'micro_integration');
  	$message = $obj->getMessage();
  	$result  = array('message'=> '<a href="/usr/bin/index.php?option=com_xipt&view=setup&task=doApply&name=aecmi">PLEASE CLICK HERE TO INSTALL JSPT MI INTO AEC</a>', 'done'=> false);
  	$this->assertEquals($message, $result);
  	
  	//#case 2: when file exist
  	JFile::move('mi_jomsocialjspt1.php', 'mi_jomsocialjspt.php', JPATH_ROOT . DS . 'components'.DS.'com_acctexp'.DS.'micro_integration');
  	$message = $obj->getMessage();
  	$result  = array('message'=> 'AEC MI ALREADY THERE', 'done'=> true);
  	$this->assertEquals($message, $result);
  }
}