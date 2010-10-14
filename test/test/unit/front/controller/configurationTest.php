<?php


class XiptConfigurationControllerTest extends XiUnitTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function testSave()
  {
  	  $postData = array('enableterms'=>0,'registrationTerms'=>'','recaptcha'=>0,
  	  					'recaptchapublic'=>'','recaptchaprivate'=>'','recaptchatheme'=>'red',
  	  					'recaptchalang'=>'en','enablereporting'=>1,'maxReport'=>50,
  	  					'notifyMaxReport'=>'','enableguestreporting'=>0,'predefinedreports'=>'Spamming / Advertisement\nProfanity / Inappropriate content.\nAbusive.',
  	  					'enablepm'=>1,'pmperday'=>30,'wallediting'=>1,'lockprofilewalls'=>1,
  	  					'option'=>'com_xipt','task'=>'config'  	  
  	  					);
  	  					
  	  $controller = new XiptControllerConfiguration();
  	  $this->assertTrue($controller->save(1,$postData));
  	  
  	  $this->_DBO->addTable('#__xipt_profiletypes');
  	  //$this->_DBO->filterColumn('#__xipt_profiletypes','params');
  }
  
  function testReset()
  {
  		$controller = new XiptControllerConfiguration();
  	  	$this->assertTrue($controller->reset(1));
  	  	$this->assertTrue($controller->reset(2));
  	  
	  	$this->_DBO->addTable('#__xipt_profiletypes');
  }
}