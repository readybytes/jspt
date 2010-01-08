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
  

  //cross check fields exists
  function testRegisterProfileFieldPage()
  {
  		$filter['aec_integrate']=0;
  		$this->changeJSPTConfig($filter);
  		
		$this->userRegistrationForPT(1);
		$this->userRegistrationForPT(2);
		$this->userRegistrationForPT(2);
		$this->userRegistrationForPT(3);		
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
    	
      	if($counter==0)
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
  	$db	=& JFactory::getDBO();
  	$query	= " SELECT `id` FROM #__users "
  			." WHERE `username`='". $username ."' LIMIT 1";
  	$db->setQuery($query);
  	$userid = $db->loadResult();
  	
  	$jUser = JFactory::getUser($userid);
  	$jUser->block=0;
  	$jUser->save();
  	$jUser = JFactory::getUser($userid);
  	
  	require_once (JPATH_BASE . '/components/com_community/libraries/core.php' );
  	require_once (JPATH_BASE . '/components/com_xipt/defines.xipt.php' );
  	
  	$cUser = CFactory::getUser($userid);
  	$privacy= $cUser->getParams()->get('privacyProfileView');
  	$profiletype  = $cUser->getInfo(PROFILETYPE_CUSTOM_FIELD_CODE);
    $template     = $cUser->getInfo(TEMPLATE_CUSTOM_FIELD_CODE);

    // find groups of user
    $query	= " SELECT `groupid` FROM #__community_groups_members "
  			." WHERE `memberid`='". $userid ."' LIMIT 1";
  	$db->setQuery($query);
  	$groups = $db->loadResultArray();
  	
  	//if custom avatar was uploaded
  	if($customAvatar==1)
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
  				$this->assertEquals($cUser->_avatar,"components/com_community/assets/default.jpg");
  				$this->assertEquals($cUser->_thumb,"components/com_community/assets/default_thumb.jpg");
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
  				$this->assertEquals($cUser->_avatar,"components/com_community/assets/default.jpg");
  				$this->assertEquals($cUser->_thumb,"components/com_community/assets/default_thumb.jpg");
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
	$this->changeJSPTConfig($filter);

    $data[2] = 1;
    $data[4] = 3;
//    $data[5] = 4;
    $data[13] = 2;
    
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
}
