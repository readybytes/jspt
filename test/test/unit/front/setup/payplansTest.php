<?php
class PayplansTest extends XiUnitTestCase 
{

   function getSqlPath()
   {
	 return dirname(__FILE__).'/sql/'.__CLASS__;
   }
	
  function xxtestIsRequired()
  {
  	$obj = new XiptSetupRulePayplans();
  	
  	//#case 1: return true when integrated with payplans but no apps for xipt
  	$this->assertTrue($obj->isRequired());
  	
  	//#case 2: return false when apps are also there
  	$this->insertApps();
  	$this->assertFalse($obj->isRequired());
  	
  }
  
  function xxtestIsApplicable()
  {
  	$obj = new XiptSetupRulePayplans();
  	$payplans = JPATH_ROOT . DS . 'components' . DS . 'com_payplans';
 	$this->assertTrue(JFolder::exists($payplans));
 	
  	//#case 1: when payplans doesn't exist
  	JFolder::move('com_payplans', 'com_payplans11', JPATH_ROOT . DS . 'components');
  	$this->assertFalse(JFolder::exists($payplans));
  	$this->assertFalse($obj->isApplicable());
  	
  	//#case 2: when payplans exists
  	JFolder::move('com_payplans11', 'com_payplans', JPATH_ROOT . DS . 'components');
  	$this->assertTrue(JFolder::exists($payplans));
  	$this->assertTrue($obj->isApplicable());
  }
  
  function xxtestDoRevert()
  {
  	$obj = new XiptSetupRulePayplans();
  	$this->assertTrue($obj->doRevert());
  }
  
//  function insertApps()
//  {
//	$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/insertApps.start.sql');
//  }
}