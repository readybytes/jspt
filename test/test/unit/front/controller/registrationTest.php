<?php
class XiptRegistrationControllerTest extends XiUnitTestCase 
{
  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testDisplay()
  {
  	$controller = new XiptControllerRegistration();
  	$this->assertTrue($controller->display('Next', 5));
  	$link = XiptRoute::_('index.php?option=com_xipt&view=registration', false);
    if (TEST_XIPT_JOOMLA_16){
  		$this->assertEquals($controller->get('redirect'), $link);
  		$this->assertEquals($controller->get('message'), 'INVALID PROFILE TYPE SELECTED');	
  	}
  	if (TEST_XIPT_JOOMLA_15){
  		$this->assertEquals($controller->_redirect, $link);
  		$this->assertEquals($controller->_message, 'INVALID PROFILE TYPE SELECTED');
  	}
  }
}