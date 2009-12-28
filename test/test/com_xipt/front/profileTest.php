<?php

class ProfileTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  
  //cross check page exists and comes
  function testViewableProfiles()
  {
  	//login as admin user
    $this->frontLogin();
	$this->verifyViewProfile(82,1);
	$this->verifyViewProfile(83,2);
	$this->verifyViewProfile(84,3);   
    
  }
  
  function verifyViewProfile($userid,$ptype)
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
	  $this->verifyEditProfileFields(82,1);
	  $this->frontLogout();
	  
	  $user = JFactory::getUser(83);
  	  $this->frontLogin($user->username,$user->username);
	  $this->verifyEditProfileFields(83,2);
	  $this->frontLogout();
	  
	  $user = JFactory::getUser(84);
  	  $this->frontLogin($user->username,$user->username);
  	  $this->verifyEditProfileFields(84,3);
  	  $this->frontLogout();
  }
  
  function verifyEditProfileFields($userid,$ptype)
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
  	  	$filter['allow_user_to_change_ptype_after_reg']=1;
  	  	$filter['allow_templatechange']=1;
  	  	$this->changeJSPTConfig($filter);
  		$this->verifyEditablePTFields(true,true);
    	
    	$filter['allow_user_to_change_ptype_after_reg']=1;
  	  	$filter['allow_templatechange']=0;
  	  	$this->changeJSPTConfig($filter);
     	$this->verifyEditablePTFields(true,false);
    	
     	$filter['allow_user_to_change_ptype_after_reg']=0;
  	  	$filter['allow_templatechange']=0;
  	  	$this->changeJSPTConfig($filter);
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
  	
	$allApps=array(42,43,44,45,46);
  	$allowedApps[1]=array(42,44,45,46);
  	$allowedApps[2]=array(43,44,45,46);
  	$allowedApps[3]=array(45,46);
  	
  	$appsNames[42]='walls';
  	$appsNames[43]='feeds';
  	$appsNames[44]='groups';
  	$appsNames[45]='latestphoto';
  	$appsNames[46]='myarticles';
  	
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
  
  function testProfiletypeJSParams()
  {
  	$sql = " UPDATE `#__xipt_profiletypes` SET `params` = '
enablegroups=0
enablevideos=0
enablephotos=0'
 WHERE `id`=3 ";
  	
  	$db	=& JFactory::getDBO();
  	$db->setQuery($sql);
  	$db->query();
  	
  	$user = JFactory::getUser(84);
  	$this->frontLogin($user->username,$user->username);
  	// go to preofile
  	$this->open("index.php?option=com_community&view=photos&userid=84&Itemid=53");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("Media has been disabled"));
	
	$this->open("index.php?option=com_community&view=groups&userid=84&Itemid=53");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("Groups have been disabled by the site administrator"));
	
	$this->open("index.php?option=com_community&view=videos&userid=84&Itemid=53");
	$this->waitPageLoad();
	$this->assertTrue($this->isTextPresent("Video has been disabled"));

  	$sql = " UPDATE `#__xipt_profiletypes` SET `params` = '
enablegroups=1
enablevideos=1
enablephotos=1'
 WHERE `id`=3 ";
  	$db	=& JFactory::getDBO();
  	$db->setQuery($sql);
  	$db->query();
  	
  	$this->open("index.php?option=com_community&view=photos&userid=84&Itemid=53");
	$this->waitPageLoad();
	$this->assertFalse($this->isTextPresent("Media has been disabled"));
	
	$this->open("index.php?option=com_community&view=groups&userid=84&Itemid=53");
	$this->waitPageLoad();
	$this->assertFalse($this->isTextPresent("Groups have been disabled by the site administrator"));
	
	$this->open("index.php?option=com_community&view=videos&userid=84&Itemid=53");
	$this->waitPageLoad();
	$this->assertFalse($this->isTextPresent("Video has been disabled"));
  	
	
	$this->frontLogout();  
  }
  
  function testChangeProfiletype()
  {
      //we should also test to change profiletypes
      $filter['allow_user_to_change_ptype_after_reg']=1;
      $filter['allow_templatechange']=1;
  	  $this->changeJSPTConfig($filter);

  	  $user = JFactory::getUser(82);
  	  $this->frontLogin($user->username,$user->username);
	  $this->verifyChangeProfiletype(82,2); // 1 -> 2
	  $this->frontLogout();
	  
	  $user = JFactory::getUser(83);
  	  $this->frontLogin($user->username,$user->username);
	  $this->verifyChangeProfiletype(83,3); // 2 -> 3
	  $this->frontLogout();
	  
	  $filter['allow_user_to_change_ptype_after_reg']=1;
      $filter['allow_templatechange']=0;
  	  $this->changeJSPTConfig($filter);
  	  
	  $user = JFactory::getUser(84);
  	  $this->frontLogin($user->username,$user->username);
  	  $this->verifyChangeProfiletype(84,1); // 3 -> 1
  	  $this->frontLogout();
  	  
  	  //test for admin too, no change is usertype
  	  // and also it have custom avatar
  	  $user = JFactory::getUser(62);
  	  $this->frontLogin(JOOMLA_ADMIN_USERNAME,JOOMLA_ADMIN_PASSWORD);
  	  $this->verifyChangeProfiletype(62,3); // 1 -> 3
  	  $this->frontLogout();
  	    	  
	  $this->_DBO->addTable('#__xipt_users');
	  $this->_DBO->filterOrder('#__xipt_users','userid');

	  $this->_DBO->addTable('#__community_fields_values');
	  $this->_DBO->filterOrder('#__community_fields_values','id');
	
	  $this->_DBO->addTable('#__community_groups_members');
	  $this->_DBO->filterOrder('#__users','memberid');
	  $this->_DBO->addTable('#__community_users');
	  $this->_DBO->filterOrder('#__community_users','userid');
	
	  $this->_DBO->addTable('#__users');
	  $this->_DBO->filterColumn('#__users','lastvisitDate');
	  $this->_DBO->filterOrder('#__users','id');
	
	  $this->_DBO->addTable('#__core_acl_groups_aro_map');
	  $this->_DBO->filterOrder('#__core_acl_groups_aro_map','aro_id');
  }
  
  function verifyChangeProfiletype($userid, $newProfiletype)
  {
  		$this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=profile&task=edit");
	  	$this->waitPageLoad();
	  	
	  	$this->assertTrue($this->isTextPresent("Edit profile"));
	  	$this->assertTrue($this->isElementPresent("field17"));
	  	$this->select("field17", "value=$newProfiletype");
	  	$this->click("//input[@value='Save']");
	  	$this->waitPageLoad();
  }
  
  function xtestUploadAvatar()
  {
  	//XITODO : testUploadAvatar
  	// It test uploading an avatar
  	// check if it does accidentaly delete default avatar of profiletye
  	// check if watermark is applied or not 
  
  	//filemtime
  }
}
