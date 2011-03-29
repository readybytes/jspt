<?php 

class ApplicationForFrontTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testApplicationForFront()
  {
  	  $filter['jspt_block_dis_app']=0;
	  $this->changeJSPTConfig($filter);
	  
	   //block display applications according to owner
  	  //login normal user with profile type 1
      $user = JFactory::getUser(82);
  	  $this->frontLogin($user->username,$user->username);
  	  //visiting self profile
	  $this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=profile&userid=82');
	  $this->waitPageLoad();
	  if (TEST_XIPT_JOOMLA_15){
	  	$this->verifyApps(array(45=>9,46=>10,47=>11),1, true,true);	  
  	  	$this->verifyApps(array(44=>8,48=>12),1, false,true);
	  }
	  if (TEST_XIPT_JOOMLA_16){
	  	$this->verifyApps(array(10009=>9,10008=>10,10010=>11),1, true,true);	  
  	  	$this->verifyApps(array(10022=>7,10011=>12),1, false,true);
	  }
  	  //visitin ohte profiletype users' profile
  	  $this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=profile&userid=83');
	  $this->waitPageLoad();
	  if (TEST_XIPT_JOOMLA_15){
	  	$this->verifyApps(array(45=>15,48=>18),2,true,false);
  	  	$this->verifyApps(array(46=>0,47=>17),2, false,false);	
	  }
	  if (TEST_XIPT_JOOMLA_16){
	  	$this->verifyApps(array(10022=>14,10009=>15,10011=>18),2,true,false);
  	  	$this->verifyApps(array(10008=>0,10010=>17),2, false,false);
	  }
  	  
	  
	  
  	  $this->frontLogout();
	  
	  $filter['jspt_block_dis_app']=1;
	  $this->changeJSPTConfig($filter);
	  
	  //block display applications according to visitor
  	  //login normal user with profile type 1
      $user = JFactory::getUser(83);
  	  $this->frontLogin($user->username,$user->username);
  	  //visiting self profile
	  $this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=profile&userid=83');
	  $this->waitPageLoad();
	  if (TEST_XIPT_JOOMLA_15){
	  	$this->verifyApps(array(45=>15,48=>18),2,true,true);
  	  	$this->verifyApps(array(46=>0,47=>17),2, false,true);	
	  }
	  if (TEST_XIPT_JOOMLA_16){
	  	$this->verifyApps(array(10022=>14,10009=>15,10011=>18),2,true,true);
  	  	$this->verifyApps(array(10008=>0,10010=>17),2, false,true);
	  }
  	  
  	  //visitin ohte profiletype users' profile
  	  $this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=profile&userid=84');
	  $this->waitPageLoad();
	  if (TEST_XIPT_JOOMLA_15){
	  	$this->verifyApps(array(45=>21,48=>24),3,true,false);
  	  	$this->verifyApps(array(46=>22,47=>23),3, false,false);	
	  }
	  if (TEST_XIPT_JOOMLA_16){
	  	$this->verifyApps(array(10022=>20,10009=>21,10011=>24),3,true,false);
  	  	$this->verifyApps(array(10008=>22,10010=>23),3, false,false);
	  }
  	  
  	  $this->frontLogout();

  	  $filter['jspt_block_dis_app']=2;
	  $this->changeJSPTConfig($filter);
  	  
  	  //block display applications according to both visitor and owner
  	  //login normal user with profile type 1
      $user = JFactory::getUser(83);
  	  $this->frontLogin($user->username,$user->username);
  	  //visiting self profile
	  $this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=profile&userid=83');
	  $this->waitPageLoad();
	  if (TEST_XIPT_JOOMLA_15){
	  	$this->verifyApps(array(45=>15,48=>18),2,true,true);
  	  	$this->verifyApps(array(46=>0,47=>17),2, false,true);	
	  }
	  if (TEST_XIPT_JOOMLA_16){
	  	$this->verifyApps(array(10022=>14,10009=>15,10011=>18),2,true,true);
  	  	$this->verifyApps(array(10008=>0,10010=>17),2, false,true);
	  }
  	  
  	  //visitin ohte profiletype users' profile
  	  $this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=profile&userid=82');
	  $this->waitPageLoad();
	  if (TEST_XIPT_JOOMLA_15){
	  	$this->verifyApps(array(45=>9),1,true,false);
  	  	$this->verifyApps(array(44=>8,46=>10,47=>11,48=>12),1, false, false);	
	  }
  	  if (TEST_XIPT_JOOMLA_16){
  	  	$this->verifyApps(array(10009=>9),1,true,false);
  	  	$this->verifyApps(array(10022=>7,10008=>10,10010=>11,10011=>12),1, false, false);
  	  }
  	  $this->frontLogout();	  
  }
  
  function verifyApps($apps, $ptype, $appPresent=true, $self=true)
  {	
	$appsNames[42]='walls';	 
    $appsNames[43]='feeds'; 
    $appsNames[44]='groups'; 
    $appsNames[45]='latestphoto'; 
    $appsNames[46]='myarticles'; 
    $version = XiSelTestCase::get_js_version();
      	// now check for every links
  	if($appPresent==true)
  	{
    		foreach($apps as $k=>$v)
    		    	$this->assertTrue($this->isElementPresent("//a[@onclick=\"joms.apps.toggle('#jsapp-$v');\"]"));	
	}
     else
     {
         foreach($apps as $k=>$v)
    	 	$this->assertFalse($this->isElementPresent("//a[@onclick=\"joms.apps.toggle('#jsapp-$v');\"]"));	
    	 
     }	
  	// Test core applications
  	// testing001 have been selected for ptype=1
  	// testing002 have been selected for ptype=2
  	// we should test those apps here
  	/*if($ptype==1){
	  	$this->assertFalse($this->isTextPresent("USERLIST2"));
	  	$this->assertTrue($this->isTextPresent("USERLIST1"));
  	}
  	if($ptype==2){
	  	$this->assertFalse($this->isTextPresent("USERLIST1"));
	  	$this->assertTrue($this->isTextPresent("USERLIST2"));
  	}
  	if($ptype==3){
	  	$this->assertFalse($this->isTextPresent("USERLIST1"));
	  	$this->assertFalse($this->isTextPresent("USERLIST2"));
  	}*/
  	
  }
}