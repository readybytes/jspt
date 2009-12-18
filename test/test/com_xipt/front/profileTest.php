<?php

class ProfileTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/index.php?option=com_community");
  }
  
  //cross check page exists and comes
  function testViewableProfiles()
  {
  	//login as admin user
    $this->frontLogin();
	$this->viewProfile(82,1);
	$this->viewProfile(83,2);
	$this->viewProfile(84,3);   
    
  }
  
  function viewProfile($userid,$ptype)
  {
  	  // open user's profile
	  $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=profile&userid=".$userid);
	  $this->waitPageLoad();
	  
	  //check fields
	    $Avail[1] 	 = array(3,4,5,8,9); // 7 is not visible due to no infor
	    $notAvail[1] = array(2,6);
	    
	    $Avail[2] 	 = array(2,4,5,8,9);//6 is not visible
	    $notAvail[2] = array(3,7,6);
	    
	    $Avail[3] 	 = array(5,9);
	    $notAvail[3] = array(2,3,4,6,7,8);
	  
	    foreach ($Avail[$ptype] as $p)
	    {
	    	$this->assertTrue($this->isTextPresent("Hometown".$p));
	    }
	    
	    foreach ($notAvail[$ptype] as $p)
	    	$this->assertFalse($this->isTextPresent("Hometown".$p));
	  
	    //check others template
	    $template[1] = "/components/com_community/templates/default/css/style.css";
	    $template[2] = "/components/com_community/templates/blueface/css/style.css";
	    $template[3] = "/components/com_community/templates/blackout/css/style.css";	    
	    $this->assertTrue($this->isTextPresent($template[$p]));
	    
  }
  
  //cross check page exists and comes
  function testEditableProfiles()
  {
  	  //login as self
  	  $user = JFactory::getUser(82);
  	  $this->frontLogin($user->username,$user->username);
	  $this->editProfile(82,1);
	  $this->frontLogout();
	  
	  $user = JFactory::getUser(83);
  	  $this->frontLogin($user->username,$user->username);
	  $this->editProfile(83,2);
	  $this->frontLogout();
	  
	  $user = JFactory::getUser(84);
  	  $this->frontLogin($user->username,$user->username);
  	  $this->editProfile(84,3);
  	  $this->frontLogout();
  }
  
  function editProfile($userid,$ptype)
  {
      // open user's profile
	  $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=profile&task=edit");
	  $this->waitPageLoad();
	  $this->assertTrue($this->isTextPresent("Edit profile"));
	  //check fields
	  $Avail[1] 	 = array(3,4,5,7,8,9); // 7 MUST be visible
	  $notAvail[1] = array(2,6);
	   
	  $Avail[2] 	 = array(2,4,5,6,8,9);//6 MUST be visible
	  $notAvail[2] = array(3,7);
	    
	  $Avail[3] 	 = array(5,9);
	  $notAvail[3] = array(2,3,4,6,7,8);
	  
	  foreach ($Avail[$ptype] as $p)
	  	$this->assertTrue($this->isElementPresent("field".$p));
	    
	  foreach ($notAvail[$ptype] as $p)
	  	$this->assertFalse($this->isElementPresent("field".$p));
  }
  
  function testEditableProfiletype()
  {
  	// now we change the configuration and see that 
  	// template and profiletype fields are editable or not
    	$user = JFactory::getUser(82);
  	  	$this->frontLogin($user->username,$user->username);
  	  	
  		//profiletype and template change allowed
  		$sql = "UPDATE `#__components` 
				SET `params`= 
				'show_ptype_during_reg=1 
				allow_user_to_change_ptype_after_reg=1 
				defaultProfiletypeID=1 
				jspt_show_radio=1 
				allow_templatechange=1 
				aec_integrate=0 aec_message=b 
				jspt_restrict_reg_check=0 
				jspt_prevent_username= 
				jspt_allowed_email= '
			WHERE `parent`='0' AND `option` ='com_xipt' LIMIT 1 ;
			";
    	$this->_DBO->execSql($sql);
        

    	//profiletype and template change not allowed
    	// profiletype not allowed and template change not allowed
    	$this->verifyEditablePTFields(true,true);
    	$sql = "UPDATE `#__components` 
				SET `params`= 
				'show_ptype_during_reg=1 
				allow_user_to_change_ptype_after_reg=1 
				defaultProfiletypeID=1 
				jspt_show_radio=1 
				allow_templatechange=0
				aec_integrate=0 aec_message=b 
				jspt_restrict_reg_check=0 
				jspt_prevent_username= 
				jspt_allowed_email= '
			WHERE `parent`='0' AND `option` ='com_xipt' LIMIT 1 ;
			";
    	$this->_DBO->execSql($sql);
    	$this->verifyEditablePTFields(true,false);
    	
    	$sql = "UPDATE `#__components` 
				SET `params`= 
				'show_ptype_during_reg=1 
				allow_user_to_change_ptype_after_reg=0 
				defaultProfiletypeID=1 
				jspt_show_radio=1 
				allow_templatechange=0
				aec_integrate=0 aec_message=b 
				jspt_restrict_reg_check=0 
				jspt_prevent_username= 
				jspt_allowed_email= '
			WHERE `parent`='0' AND `option` ='com_xipt' LIMIT 1 ;
			";
    	$this->_DBO->execSql($sql);
    	$this->verifyEditablePTFields(false,false);    
  }
  
  
  
  function verifyEditablePTFields($profiletype,$template)
  {
  	//go to profile edit page	  	
  	  	$this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=profile&task=edit");
	  	$this->waitPageLoad();
	  	$this->assertTrue($this->isTextPresent("Edit profile"));
	  	
	  	$this->assertTrue($this->isElementPresent("field16"));
	  	$this->assertTrue($this->isElementPresent("field17"));
	  	
	  	// both
	  	if(!$template)
	  		$this->assertTrue($this->isElementPresent("//input[@id='field16'][contains(@type,'hidden')]"));
	  	if(!$profiletype)
	  		$this->assertTrue($this->isElementPresent("//input[@id='field17'][contains(@type,'hidden')]"));
  }
  
  function testApplicationProfiles()
  {
  	//login as admin user
      $user = JFactory::getUser(82);
  	  $this->frontLogin($user->username,$user->username);
	  $this->verifyApps(82,1);
	  $this->frontLogout();
	  
	  $user = JFactory::getUser(83);
  	  $this->frontLogin($user->username,$user->username);
	  $this->verifyApps(83,2);
	  $this->frontLogout();
	  
	  $user = JFactory::getUser(84);
  	  $this->frontLogin($user->username,$user->username);
  	  $this->verifyApps(84,3);
  	  $this->frontLogout();  
  }
  
  function verifyApps($userid, $ptype)
  {
  	
  	$this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=apps&task=browse&Itemid=53");
	$this->waitPageLoad();
  	
	$allApps=array(38,39,40,41,42);
  	$allowedApps[1]=array(38,40,41,42);
  	$allowedApps[2]=array(39,40,41,42);
  	$allowedApps[3]=array(41,42);
  	
  	$appsNames[38]='walls';
  	$appsNames[39]='feeds';
  	$appsNames[40]='groups';
  	$appsNames[41]='latestphoto';
  	$appsNames[42]='myarticles';
  	
  	// now check for every links
  	foreach($allApps as $a)
  	{
  		$this->click("//a[@onclick=\"joms.apps.add('".$appsNames[$a]."')\"]");
	  	//wait for ajax window
  		for ($second = 0; ; $second++) {
	        if ($second >= 60) $this->fail("timeout");
	        try {
	            if ($this->isTextPresent("Add Application")) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
    
  		if(in_array($a,$allowedApps[$ptype])){
  			$this->assertTrue($this->isTextPresent("Application added!"));
  		}
  		else{
  			$this->assertFalse($this->isTextPresent("Application added!"));
  		}
  	}
  }
}