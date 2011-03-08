<?php

class RegisterTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  //cross check page exists and comes
  function testRegisterPage()
  {
  	$filter['aec_integrate']=0;
	$filter['jspt_allowed_email']='';
  	$filter['jspt_prevent_email']='';
  	$filter['jspt_show_radio']=1;
	$this->changeJSPTConfig($filter);
	
  	//Prerequiste = clean session + No AEC + Our system plugin is working
  	//1. session cleaned via SQL
    // go to register location 
    $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=register");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("PROFILETYPE-1"));
    $this->assertTrue($this->isTextPresent("PROFILETYPE-2"));
    $this->assertTrue($this->isTextPresent("PROFILETYPE-3"));
    $this->assertFalse($this->isTextPresent("PROFILETYPE-4"));//unpublished
	$this->assertFalse($this->isTextPresent("PROFILETYPE-5"));
	
    //now click on next without selecting any profiletype
    $this->click("ptypesavebtn");
    $this->waitPageLoad();
    // a system message sud be there
    $this->assertTrue($this->isElementPresent("//dl[@id='system-message']"));
    
    //now select profiletype-2
    $this->click("profiletypes2");
    $this->click("ptypesavebtn");
    $this->waitPageLoad();
    $this->assertTrue($this->isElementPresent("//dl[@id='system-message']"));
    $this->assertTrue($this->isTextPresent("Register new user"));
  }
  
  
  function testJoomlaRegistration()
  {
  		/*enable user account without email verification */
  		$params = JComponentHelper::getParams('com_users');
  		$params->set('useractivation',0);
  		
  		$config = $params->toString();
  		//#__etension for joomla 1.6 , parent is replaced by client_id and option is replaced by element
  		$db	    = JFactory::getDBO();
  		$query  = "UPDATE `#__extensions` SET `params`='".$config."'"
  				." WHERE `client_id`='0' AND `element` ='com_users' LIMIT 1";	
		$db->setQuery($query);
		$db->query();
  		
		/*$configFilter = array();
  		$configFilter['useractivation'] = 0;
  		$this->updateJoomlaConfig($configFilter);*/
  		
  		$filter['aec_integrate']=0;
  		$this->changeJSPTConfig($filter);
  		
  		/*we know that template must be default 
  		 * for ptype 1 and etc.. */
		$this->joomlaRegistrationForPT(1,'default');
		$this->joomlaRegistrationForPT(2,'blueface');	
  }

  
  function joomlaRegistrationForPT($ptype,$template)
  {
  	//Prerequiste = clean session + No AEC + Our system plugin is working
  	//1. session cleaned via SQL
    // go to register location 
   if(TEST_XIPT_JOOMLA_16)
    	$this->open(JOOMLA_LOCATION."index.php?option=com_users&view=registration");
    if(TEST_XIPT_JOOMLA_15)
    	$this->open(JOOMLA_LOCATION."/index.php?option=com_user&view=register");
    $this->waitPageLoad();
    $this->click("profiletypes".$ptype);
    $this->click("ptypesavebtn");
    
    $this->waitPageLoad();
    
    // now fille reg + field information
    
    $username =  $this->fillJoomlaRrgistrationPT($ptype);
    if(TEST_XIPT_JOOMLA_15)
 	    $this->assertTrue($this->isTextPresent("You may now log in."));
    
// 	if(TEST_XIPT_JOOMLA_16)
// 	    $this->assertTrue($this->isTextPresent("Thank you for registering. You may now log in using username and password you registered with."));
 	
    
    //verify users
    $this->assertTrue($this->verifyJoomlaUser($username, $ptype, $template));
  	
  }
  
  
   function fillJoomlaRrgistrationPT($ptype)
  {
  	$this->assertTrue($this->isTextPresent("Registration"));
  	
  	$randomNo  = rand(1234567,9234567);
    $randomStr = "regtest".$randomNo;
    
    // fill some random values in register page
    if(TEST_XIPT_JOOMLA_15){
	    $this->type("name", $randomStr);
	    $this->type("username", $randomStr);
	    $this->type("email", $randomStr.'@gmail.com');
	    $this->type("password", $randomStr);
	    $this->type("password2", $randomStr);
    }
    
    if(TEST_XIPT_JOOMLA_16){
        $this->type("jform_name", $randomStr);
   		$this->type("jform_username", $randomStr);
    	$this->type("jform_password1", $randomStr);
    	$this->type("jform_password2", $randomStr);
    	$this->type("jform_email1", $randomStr.'@gmail.com');
    	$this->type("jform_email2", $randomStr.'@gmail.com');
    }
    
    $this->click("//button[@type='submit']");   
    $this->waitPageLoad();
    return $randomStr;
  }
  
  
  function verifyJoomlaUser($username,$ptype,$template)
  {
  	$db	    = JFactory::getDBO();
  	$query	= " SELECT `id` FROM #__users "
  			." WHERE `username`='". $username ."' LIMIT 1";
  	$db->setQuery($query);
  	$userid = $db->loadResult();
  	
  	$jUser  = JFactory::getUser($userid);
  	$jUser->block=0;
  	$jUser->save();
  	$jUser  = JFactory::getUser($userid);

  	$query	= " SELECT * FROM #__xipt_users"
  			." WHERE `userid`='". $userid ."'"
  			." AND `profiletype`='".$ptype ."'"
  			." AND `template`='".$template ."'"
  			." LIMIT 1";
  	$db->setQuery($query);
  	$userPtypeInfo = $db->loadObject();
  	
  	if(empty($userPtypeInfo))
  		return false;
  		
  	return true;
  }

  //cross check fields exists
  function testRegisterProfileFieldPage()
  {
  		$filter['aec_integrate']   = 0;
  		$filter['jspt_show_radio'] = 1;
  		$this->changeJSPTConfig($filter);
  		
		$this->userRegistrationForPT(3);
		$this->userRegistrationForPT(2);	
  }
  
  function userRegistrationForPT($ptype)
  {
  	//Prerequiste = clean session + No AEC + Our system plugin is working
  	//1. session cleaned via SQL
    // go to register location 
    $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=register");
    $this->waitPageLoad();
    $this->click("profiletypes".$ptype);
    $this->click("ptypesavebtn");
    
    $this->waitPageLoad();
    
    // now fille reg + field information
    
    $username =  $this->fillDataPT($ptype);
    
    //avatar page
    $this->assertTrue($this->isTextPresent("Change profile picture")); 
    $this->assertTrue($this->verifyAvatar($ptype));
    
    //we should try to upload custom avatar also, so that it can be tested.
    if($ptype == 2)
    {
    	$customAvatar = 1;
    	//try once to apply watermark too
    	static $counter=0;
    	if($counter==0)
    	{
			//make watermark enable for one type
    		$filter['show_watermark']=1;
    		$this->changeJSPTConfig($filter);
    	}
    	
    	$newAvatar = 'test/test/com_xipt/front/images/avatar_3.gif';
    	$this->type("file-upload", JPATH_ROOT.DS.$newAvatar);
	  	$this->click("file-upload-submit");
    	$this->waitPageLoad();
    	
      	if($counter == 0)
    	{
    		$filter['show_watermark']=0;
    		$this->changeJSPTConfig($filter);
    		$counter++;
    	}
    }
    else
    {
    	$customAvatar = 0;
    	$this->click("link=[Skip]");
    	$this->waitPageLoad();
    }
    
    $this->assertTrue($this->isTextPresent("User Registered."));
    
    //verify users
    $this->assertTrue($this->verifyUser($username, $ptype, $customAvatar));
  	
  }
  
  function fillDataPT($ptype, $full=true)
  {
  	$this->assertTrue($this->isTextPresent("Register new user"));
  	
  	$randomNo  = rand(1234567,9234567);
    $randomStr = "regtest".$randomNo;
 
    // fill some random values in register page
    $this->type("jsname", $randomStr);
    $this->type("jsusername", $randomStr);
    $this->type("jsemail", $randomStr.'@gmail.com');
    $this->type("jspassword", $randomStr);
    $this->type("jspassword2", $randomStr);
    // wait for some time for ajax checks
    $this->click("btnSubmit");
    sleep(1);
    $this->click("btnSubmit");
    $this->waitPageLoad();
    
    $this->assertTrue($this->isTextPresent("Basic Information"));
    
    $Avail[1] 	 = array(3,4,5,8,9);// 7 is not visible during reg
    $notAvail[1] = array(2,6);
    
    $Avail[2] 	 = array(2,4,5,6,8,9);
    $notAvail[2] = array(3,7);
    
    $Avail[3] 	 = array(5,9);
    $notAvail[3] = array(2,3,4,6,7,8);
    
    //verify and fill fields
    foreach ($Avail[$ptype] as $p)
    {
    	$this->assertTrue($this->isElementPresent("field".$p));
    	$this->type("field".$p, $randomStr);
    }
    
    foreach ($notAvail[$ptype] as $p)
    	$this->assertFalse($this->isElementPresent("field".$p));
    
    //template
    $this->assertTrue($this->isElementPresent("field16"));
    //profiletype is correctly displayed
    $element = "//input[@id='field17' and @value='$ptype']";
    $this->assertTrue($this->isElementPresent($element));
    
    //sometime we dont want to complete the process
    if($full===false)
    {
    	return $randomStr;
    }
    
   	$this->click("btnSubmit");
    $this->waitPageLoad();
    	//return username
    return $randomStr;
  }
  
  function verifyAvatar($ptype)
  {
  	return true;
  	if($ptype == 2)
  	{
  			
  		$this->assertTrue($this->isElementPresent("//div[@id='community-wrap']/img[1][contains(@src,'".JOOMLA_LOCATION."/components/com_community/assets/group.jpg')]"));
  		$this->assertTrue($this->isElementPresent("//div[@id='community-wrap']/img[2][contains(@src,'".JOOMLA_LOCATION."/components/com_community/assets/group_thumb.jpg')]"));
  	}
  	else
  	{
 	    $this->assertTrue($this->isElementPresent("//div[@id='community-wrap']/img[1][contains(@src,'".JOOMLA_LOCATION."/components/com_community/assets/default.jpg')]"));
 	    $this->assertTrue($this->isElementPresent("//div[@id='community-wrap']/img[2][contains(@src,'".JOOMLA_LOCATION."/components/com_community/assets/default_thumb.jpg')]"));
  	}
	  	
  }
  
  function verifyUser($username, $ptype, $customAvatar = 0)
  {
  	$db		= JFactory::getDBO();
  	$query	= " SELECT `id` FROM #__users "
  			." WHERE `username`='". $username ."' LIMIT 1";
  	$db->setQuery($query);
  	$userid = $db->loadResult();
  	
  	$jUser = JFactory::getUser($userid);
  	$jUser->block=0;
  	$jUser->save();
  	$jUser = JFactory::getUser($userid);
  	
  	require_once (JPATH_BASE . '/components/com_community/libraries/core.php' );
  	require_once (JPATH_BASE . '/components/com_xipt/defines.php' );
  	
  	$cUser 			= CFactory::getUser($userid);
  	$privacy		= $cUser->getParams()->get('privacyProfileView');
//  	$profiletype  	= $cUser->getInfo(PROFILETYPE_CUSTOM_FIELD_CODE);
//    $template     	= $cUser->getInfo(TEMPLATE_CUSTOM_FIELD_CODE);
    
  	$profiletype  	= XiptHelperUtils::getInfo($userid,PROFILETYPE_CUSTOM_FIELD_CODE);
    $template     	= XiptHelperUtils::getInfo($userid,TEMPLATE_CUSTOM_FIELD_CODE);
    // find groups of user
    $query	= " SELECT `groupid` FROM #__community_groups_members "
  			." WHERE `memberid`='". $userid ."' LIMIT 1";
  	$db->setQuery($query);
  	$groups = $db->loadResultArray();
  	
  	//if custom avatar was uploaded
  	if($customAvatar == 1)
  	{
  		$this->assertTrue(JFile::exists(JPATH_ROOT.DS.$cUser->_avatar));
  		$this->assertTrue(JFile::exists(JPATH_ROOT.DS.$cUser->_thumb));
  	}
  	
  	//echo $groups;
  	switch ($ptype)
  	{
  		case '1':
  			$this->assertEquals($jUser->usertype,"Registered");
  			if($customAvatar==0)
  			{
  				$this->assertTrue(in_array($cUser->_avatar,array("","components/com_community/assets/default.jpg")));
  				$this->assertTrue(in_array($cUser->_thumb,array("","components/com_community/assets/default_thumb.jpg")));
  			}
  			$this->assertEquals($privacy,PRIVACY_PUBLIC);
  			$this->assertEquals($template,"default");
  			$this->assertEquals($profiletype,1);
  			$this->assertTrue(in_array(1,$groups));
  			break;
  		case '2':
  			$this->assertEquals($jUser->usertype,"Editor");
  			if($customAvatar==0)
  			{
  				$this->assertEquals($cUser->_avatar,"components/com_community/assets/group.jpg");
  				$this->assertEquals($cUser->_thumb,"components/com_community/assets/group_thumb.jpg");
  			}
  			$this->assertEquals($privacy,PRIVACY_FRIENDS);
  			$this->assertEquals($template,"blueface");
  			$this->assertEquals($profiletype,2);
  			// not in any group
  			$this->assertTrue(empty($groups));
  			break;
  			
  		case '3':
	  		$this->assertEquals($jUser->usertype,"Publisher");
	  		if($customAvatar==0)
  			{
  				$this->assertTrue(in_array($cUser->_avatar,array("","components/com_community/assets/default.jpg")));
  				$this->assertTrue(in_array($cUser->_thumb,array("","components/com_community/assets/default_thumb.jpg")));
  			}
  			$this->assertEquals($privacy,PRIVACY_MEMBERS);
  			$this->assertEquals($template,"blackout");
  			$this->assertEquals($profiletype,3);
  			$this->assertTrue(in_array(4,$groups));
  			break;
	  		
  		default:
  			break;	
  	} 
  	
  	 
  	return true;
  }
  
  //cross check page exists and comes
  function testAECRegisterPage()
  {
  	$filter['aec_integrate']=1;
  	$filter['aec_message']='b';
	$this->changeJSPTConfig($filter);

    $data[2] = 1;
    $data[4] = 3;
    
    //create backend test
    // create 4 MI
    // attach them to plans as above
    foreach($data as $plan => $profiletype)
    {
    	// go to register location 
    	$this->open(JOOMLA_LOCATION."/index.php?option=com_acctexp&task=subscribe");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isTextPresent("Payment Plans"));

    	//select plan
    	$this->click("//div[@class='aec_ilist_item aec_ilist_item_$plan']/div/div/form/input[@name='submit']");
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']"));
    	$this->assertTrue($this->isElementPresent("xipt_back_link"));
    	$this->assertTrue($this->isTextPresent("PROFILETYPE-$profiletype"));
    	
    	$username = $this->fillDataPT($profiletype);
    	$this->verifyUser($username, $profiletype);
    }
    
    foreach($data as $plan => $profiletype)
    {
	    // now test some partial registration
	    $this->open(JOOMLA_LOCATION."/index.php?option=com_acctexp&task=subscribe");
	    $this->waitPageLoad();
	    $this->assertTrue($this->isTextPresent("Payment Plans"));
	
    	//select plan
	    $this->click("//div[@class='aec_ilist_item aec_ilist_item_$plan']/div/div/form/input[@name='submit']");
	    $this->waitPageLoad();
	    	
	    $this->assertTrue($this->isElementPresent("//dl[@id='system-message']"));
	    $this->assertTrue($this->isElementPresent("xipt_back_link"));
	    $this->assertTrue($this->isTextPresent("PROFILETYPE-$profiletype"));
	    //here due to partial registration
	    //profiletype might get mixed : lets test it
	    $username = $this->fillDataPT($profiletype,false);
    }
    	
  }
  
  function testRegisterWithoutPTSelection()
  {
  	$filter['aec_integrate']=0;
	$this->changeJSPTConfig($filter);
	
  	$this->open(JOOMLA_LOCATION.'/index.php');
  	$this->waitPageLoad();
  	
  	if(TEST_XIPT_JOOMLA_15){
  		$this->assertTrue($this->isElementPresent("//li[@class='item61']/a"));
  		$this->click("//li[@class='item61']/a");
  	}
  	 if(TEST_XIPT_JOOMLA_16){
  	 	  	$this->assertTrue($this->isElementPresent("//img[@alt='Profile Type 1 Registration']"));
  	 	  	$this->click("//img[@alt='Profile Type 1 Registration']");
  	 }	
  	$this->waitPageLoad();
  		
  	$this->assertTrue($this->isTextPresent("PROFILETYPE-1"));
  	// the selected profile is PROFILETYPE-2 
  	// $this->assertTrue($this->isTextPresent("PROFILETYPE-2"));
    $this->assertFalse($this->isTextPresent("PROFILETYPE-3"));
    $this->assertFalse($this->isTextPresent("PROFILETYPE-4"));//unpublished
    $this->assertTrue($this->isElementPresent("//dl[@id='system-message']"));
    $this->assertTrue($this->isTextPresent("Register new user"));
    
  }
  
  function testRestrictUserRegistration()
  {
  	$random=rand(111,999);
  	$filter['jspt_restrict_reg_check'] = 1;
	$filter['aec_integrate']           = 0;
	
	$filter['jspt_prevent_username']='moderator; admin; support; owner; employee';
	$filter['jspt_allowed_email']='yahoo.com';
  	$filter['jspt_prevent_email']='gmail.com';
	
	$this->changeJSPTConfig($filter);
	
	//restrict usernames to register
	$this->fillDataForRestriction("moderator","moderator@email.com",true);
	$this->isTextPresent("The username selected is not a vaild username.");
	
  	//restrict user to regiser by email doman name
	$this->fillDataForRestriction("user$random","user$random@gmail.com",true);
	$this->isTextPresent("The email is not allowed to register.");
	
	$this->fillDataForRestriction("user$random","user$random@yahoo.com",false);
	$this->assertFalse($this->isTextPresent("The email is not allowed to register."));
	
	$filter['jspt_allowed_email']='';
  	$filter['jspt_prevent_email']='';
	$this->changeJSPTConfig($filter);
  }
  
  function fillDataForRestriction($username, $email, $restrict=false)
  {
  	$version = XiSelTestCase::get_js_version();
  	$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=register');
	$this->waitPageLoad();
	if(!$this->isTextPresent("Your current profiletype is PROFILETYPE-2 , to change profiletype Click Here"))
	{
		$this->click('profiletypes2');
		$this->click('ptypesavebtn');
		$this->waitPageLoad();
	}
	$this->type("jsname",$username);
	$this->type("jsusername",$username);
	$this->type("jsemail",$email);
	$this->type("jspassword",$username);
	$this->type("jspassword2",$username);
	sleep(4);
	    $this->click("btnSubmit");
	sleep(4);
	    $this->click("btnSubmit");
	if($restrict==true){
		$this->waitForElement("cwin_tm");
//		if(Jstring::stristr($version,'1.8') || Jstring::stristr($version,'2.0'))
			$this->assertTrue($this->isTextPresent("info is required. Make sure it contains a valid value!"));
//		else
//			$this->assertTrue($this->isTextPresent("A required entry is missing or it contains an invalid value!"));
		
		$this->click("cwin_close_btn");
	}
	else
	{
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Register new user"));	
	}
  }
  
  function testDirectAECLinkRegistration()
  {
	$url = dirname(__FILE__).'/sql/RegisterTest/testAECRegisterPage.start.sql';
  	$this->_DBO->loadSql($url);
  	
  	$filter['aec_integrate']=1;
	$filter['defaultProfiletypeID']=2;
	$filter['aec_message']='b';
	$this->changeJSPTConfig($filter);
  	  	
	$data[2] = 1;
    $data[4] = 3;
  	   
  	foreach($data as $usage => $profiletype)
    {
    	// go to register location 
    	$this->open(JOOMLA_LOCATION.'index.php?option=com_acctexp&task=subscribe&usage='.$usage);
  		$this->waitPageLoad();
  		    	
    	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']"));
    	$this->assertTrue($this->isElementPresent("xipt_back_link"));
    	$this->assertTrue($this->isTextPresent("PROFILETYPE-$profiletype"));
    	
    	$username = $this->fillDataPT($profiletype);
    	$this->verifyUser($username, $profiletype);
    }  	
    $filter['aec_integrate']=1;
    $this->changeJSPTConfig($filter);
  }
}

