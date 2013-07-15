<?php
class PayplansTest extends XiUnitTestCase 
{

   function getSqlPath()
   {
	 return dirname(__FILE__).'/sql/'.__CLASS__;
   }
	
  function testIsRequired()
  {
  	$obj = new XiptSetupRulePayplans();
  	
  	//#case 1: return true when integrated with payplans but no apps for xipt
  	$this->assertTrue($obj->isRequired());
  	
  	//#case 2: return false when apps are also there
  	$this->insertApps();
  	$this->assertFalse($obj->isRequired());
  	
  }
  
  function testIsApplicable()
  {
  	$obj = new XiptSetupRulePayplans();
  	include_once JPATH_ROOT .DS. 'components' .DS. 'com_payplans' .DS. 'includes' .DS. 'includes.php';
  	$this->assertTrue($obj->isApplicable());
  }
  
  function testDoRevert()
  {
  	$obj = new XiptSetupRulePayplans();
  	$this->assertTrue($obj->doRevert());
  }
  
  function insertApps()
  {
	$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/insertApps.start.sql');
  }
}