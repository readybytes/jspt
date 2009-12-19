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
  	
  	// Test core applications
  	// testing001 have been selected for ptype=1
  	// testing002 have been selected for ptype=2
  	// we should test those apps here
  	if($ptype==1){
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
  	}
  	
  }
  
  function testACLRules0()
  {
  	  //login as admin user
      $user = JFactory::getUser(82);//regtest8774090
  	  $this->frontLogin($user->username,$user->username);
	  $this->verifyACLRules0(82,1);
	  $this->frontLogout();
  } 
  
  function verifyACLRules0($userid, $ptype) 
  {
  	//1.create group
	$this->open("index.php?option=com_community&view=groups&task=create&Itemid=53");
	$this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
    
    //2. join group
	$this->open("index.php?option=com_community&view=groups&task=viewgroup&groupid=4&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"javascript:joms.groups.joinWindow('4');\"]");
	//wait for ajax window
  		for ($second = 0; ; $second++) {
	        if ($second >= 30) $this->fail("timeout");
	        try {
	            if ($this->isTextPresent("You are not allowed to access this resource")) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
    
    //3. create album allowed 1
    $this->open("index.php?option=com_community&view=photos&task=newalbum&userid=".$userid."&Itemid=53");
	$this->waitPageLoad();
	$this->type("//form[@id='newalbum']/table/tbody/tr[1]/td[2]/input", "Album1");
	$this->type("//textarea[@id='description']", "Album1");
	$this->click("//form[@id='newalbum']/table/tbody/tr[3]/td[2]/input[2]");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("New Album Created."));
    
    $this->open("index.php?option=com_community&view=photos&task=newalbum&userid=".$userid."&Itemid=53");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));

	//4. create photos now
	$this->open("index.php?option=com_community&view=photos&task=uploader&albumid=2&userid=".$userid."&Itemid=53");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));

	//5. video
	$this->open("index.php?option=com_community&view=videos&task=myvideos&userid=".$userid."&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"joms.videos.addVideo()\"]");
	for ($second = 0; ; $second++) {
	        if ($second >= 30) $this->fail("timeout");
	        try {
	            if ($this->isTextPresent("You are not allowed to access this resource")) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
    
	//6.send message
	$this->open("index.php?option=com_community&view=profile&userid=81&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"joms.messaging.loadComposeWindow('81')\"]");
	for ($second = 0; ; $second++) {
	        if ($second >= 30) $this->fail("timeout");
	        try {
	            if ($this->isTextPresent("You are not allowed to access this resource")) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
    
    //7.Change Avatar
    $this->open("index.php?option=com_community&view=profile&task=uploadAvatar&Itemid=53");
	$this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
    
    //8.privacy
    $this->open("index.php?option=com_community&view=profile&task=privacy&Itemid=53");
	$this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
    
    //9. 
    $this->open("index.php?option=com_community&view=profile&task=edit&Itemid=53");
	$this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
    
    //10.
    $this->open("index.php?option=com_community&view=profile&task=editDetails&Itemid=53");
	$this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
    
    //11.
    		// sud not be allowed to access ptype2
    $this->open("index.php?option=com_community&view=profile&userid=83&Itemid=53");
	$this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
		//sud able to access ptype3
    $this->open("index.php?option=com_community&view=profile&userid=84&Itemid=53");
	$this->waitPageLoad();
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
  }
  
  function testACLRules1()
  {
  	  //login as admin user
      $user = JFactory::getUser(82);//regtest8774090
  	  $this->frontLogin($user->username,$user->username);
	  $this->verifyACLRules1(82,1);
	  $this->frontLogout();
  } 
  
  function verifyACLRules1($userid, $ptype) 
  {
  	//1.create group
	$this->open("index.php?option=com_community&view=groups&task=create&Itemid=53");
	$this->waitPageLoad();
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
    
    //2. join group
	$this->open("index.php?option=com_community&view=groups&task=viewgroup&groupid=4&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"javascript:joms.groups.joinWindow('4');\"]");
	//wait for ajax window
  		for ($second = 0; ; $second++) {
	        if ($second >= 30) $this->fail("timeout");
	        try {
	            if ($this->isTextPresent("Join Group")) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
    
    //3. create album allowed 1
    $this->open("index.php?option=com_community&view=photos&task=newalbum&userid=".$userid."&Itemid=53");
	$this->waitPageLoad();
	$this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));

	//4. create photos now
	$this->open("index.php?option=com_community&view=photos&task=uploader&albumid=2&userid=".$userid."&Itemid=53");
	$this->waitPageLoad();
	$this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));

	//5. video
	$this->open("index.php?option=com_community&view=videos&task=myvideos&userid=".$userid."&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"joms.videos.addVideo()\"]");
	for ($second = 0; ; $second++) {
	        if ($second >= 30) $this->fail("timeout");
	        try {
	            if ($this->isTextPresent("Add Video")) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
    
	//6.send message
	$this->open("index.php?option=com_community&view=profile&userid=81&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"joms.messaging.loadComposeWindow('81')\"]");
	for ($second = 0; ; $second++) {
	        if ($second >= 30) $this->fail("timeout");
	        try {
	            if ($this->isTextPresent("Compose")) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
    
    //7.Change Avatar
    $this->open("index.php?option=com_community&view=profile&task=uploadAvatar&Itemid=53");
	$this->waitPageLoad();
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
    
    //8.privacy
    $this->open("index.php?option=com_community&view=profile&task=privacy&Itemid=53");
	$this->waitPageLoad();
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
    
    //9. 
    $this->open("index.php?option=com_community&view=profile&task=edit&Itemid=53");
	$this->waitPageLoad();
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
    
    //10.
    $this->open("index.php?option=com_community&view=profile&task=editDetails&Itemid=53");
	$this->waitPageLoad();
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
    
    //11.
    		// sud not be allowed to access ptype2
    $this->open("index.php?option=com_community&view=profile&userid=83&Itemid=53");
	$this->waitPageLoad();
    $this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
  }
}
