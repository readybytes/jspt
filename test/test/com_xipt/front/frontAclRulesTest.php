<?php

class FrontAclRulesTest extends XiSelTestCase 
{
  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  
  function verifyRestrict($verify)
  {
  	sleep(1);
 	$present = $this->isTextPresent("You are not allowed to access this resource");
  	$this->assertTrue($verify != $present);
  }
  

  function checkCreateGroup($from, $verify)
  {
		
	$this->open("index.php?option=com_community&view=groups&task=create&Itemid=53");
	$this->waitPageLoad();
    $this->verifyRestrict($verify);   
  }
 function checkCreateEvent($verify,$starttime,$endtime)
  {
	static $counter=1;	
	$this->open("index.php?option=com_community&view=events&task=create&Itemid=53");
	$this->waitPageLoad();
	
	if($verify)
	{
		$this->type("title", "myevent$counter");
		$this->type("description", "myevent");
		$this->type("location", "india");
		$this->select("starttime-hour", "label=$starttime");
		$this->select("starttime-ampm", "label=pm");
		$this->select("endtime-hour", "label=$endtime");
		$this->select("endtime-ampm", "label=pm");
		$this->click("//input[@value='Create Event']");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("New event myevent$counter created"));
		//$this->assertTrue(($this->isTextPresent("New event myevent$counter created"));
	}
	$counter++;

  }
  
  function checkJoinGroup($from, $groupid, $verify)
  {
	$this->open("index.php?option=com_community&view=groups&task=viewgroup&groupid=$groupid&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"javascript:joms.groups.joinWindow('$groupid');\"]");
	$this->waitForElement("cwin_tm");
    $this->verifyRestrict($verify);
  }


  function checkAddAsFriend($from, $userid, $verify)
  {
	$this->open("index.php?option=com_community&view=profile&userid=$userid&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"joms.friends.connect('$userid')\"]");
	$this->waitForElement("cwin_tm");
    $this->verifyRestrict($verify);
  }
  
  function checkCreateAlbum($from, $verify)
  {
  	$version = XiSelTestCase::get_js_version();
    static $counter=1;
  	
    $this->open("index.php?option=com_community&view=photos&task=newalbum&userid=$from&Itemid=53");
	$this->waitPageLoad();
	$this->verifyRestrict($verify);
	
    if($verify)
    {
       	if(Jstring::stristr($version,'1.8'))	
       	{
   			$this->type("name", "Album$counter");
   			$this->type("description", "Album$counter");
		    $this->click("//input[@value='Create Album']");
       	}
       	else
       	{
	   		$this->type("//form[@id='newalbum']/table/tbody/tr[1]/td[2]/input", "Album$counter");
       		$this->type("//textarea[@id='description']", "Album$counter");
	   		$this->click("//form[@id='newalbum']/table/tbody/tr[3]/td[2]/input[2]");
       	}	
        $this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("New album created."));
		$counter++;
    }	
  }
  
  function checkAddPhotos($from, $albumid, $verify)
  {
	$this->open("index.php?option=com_community&view=photos&task=uploader&albumid=$albumid&userid=$from&Itemid=53");
	$this->waitPageLoad();
	$this->verifyRestrict($verify);   
  }
  
  function checkAddVideos($from, $verify)
  {
	$this->open("index.php?option=com_community&view=videos&task=myvideos&userid=$from&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"joms.videos.addVideo()\"]");
	$this->waitForElement("cwin_tm");
    $this->verifyRestrict($verify);
  }
  
  function checkSendMessage($from, $to, $verify)
  {
  	static $counter=1;
  	
  	//go to user profile 
	$this->open("index.php?option=com_community&view=profile&userid=$to&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"joms.messaging.loadComposeWindow('$to')\"]");
	$this->waitForElement("cwin_tm");    
    $this->verifyRestrict($verify);   
    	
    if($verify)
    {
    	//send a sample message
    	$this->assertTrue($this->isElementPresent('subject'));
    	$this->type("subject", "SAMPLE TEST Message$counter");
    	$this->type("body", "SAMPLE TEST Message$counter");
    	$this->click("//button[@onclick=\"javascript:return joms.messaging.send();\"]");
    	sleep(2);
    	$this->assertTrue($this->isTextPresent("Message sent"));
    	$counter++;
    }
  }
  
  function checkChangeAvatar($from, $verify)
  {
    //7.Change Avatar
    $this->open("index.php?option=com_community&view=profile&task=uploadAvatar&Itemid=53");
	$this->waitPageLoad();
    $this->verifyRestrict($verify);   
   }
  
  function checkChangePrivacy($from, $verify)
  {
  	//8.privacy
    $this->open("index.php?option=com_community&view=profile&task=privacy&Itemid=53");
	$this->waitPageLoad();
	$this->verifyRestrict($verify);       
  }
  
  function checkEditProfile($from, $verify)
  {
	$this->open("index.php?option=com_community&view=profile&task=edit&Itemid=53");
	$this->waitPageLoad();
	$this->verifyRestrict($verify);       
  }
  
  function checkEditProfileDetails($from, $verify)
  {

    $this->open("index.php?option=com_community&view=profile&task=editDetails&Itemid=53");
	$this->waitPageLoad();
	$this->verifyRestrict($verify);   
  }
  
  function checkVisitProfile($from, $to, $verify)
  {
	$this->open("index.php?option=com_community&view=profile&userid=$to&Itemid=53");
	$this->waitPageLoad();
	$this->verifyRestrict($verify);     
  }
  function checkAccessVideo($from,$to,$vid,$verify)
  {
  	$this->open("index.php?option=com_community&view=videos&task=video&userid=$to&videoid=$vid&Itemid=53");
  	$this->waitPageLoad();
  	$this->verifyRestrict($verify);   
  }
  function checkAccessGroup($from,$groupid,$verify)
  {
  	 $this->open("index.php?option=com_community&view=groups&task=viewgroup&groupid=$groupid&Itemid=53");
  	 $this->waitPageLoad();
  	 $this->verifyRestrict($verify);   
  }
  function checkStatusBox()
  {
  	$this->open("index.php?option=com_community&view=profile&Itemid=53");
  	$this->waitPageLoad();
  	$this->type("statustext", "change status");
    $this->click("save-status");     
  }

  function registeruser($pt,$restrictuploadavatar)
  {
  	$rand=rand('111','999');
  	$this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=frontpage");
  	$this->waitPageLoad();
  	$this->click("//a[@id='joinButton']");
  	$this->waitPageLoad();
  	$this->click("//input[@id='$pt']");
  	$this->click('ptypesavebtn');
  	$this->waitPageLoad();
  	$this->type("jsname","username$rand");
	$this->type("jsusername","username$rand");
	$this->type("jsemail","user$rand@email.com");
	$this->type("jspassword","username");
	$this->type("jspassword2","username");
	sleep(2);
	$this->click("//input[@type='submit']");
	sleep(2);
	$this->click("//input[@type='submit']");
	$this->waitPageLoad();
	$this->click('btnSubmit');
	$this->waitPageLoad();
	if($restrictuploadavatar==1)
	{
	 $this->type("file-upload", JOOMLA_FTP_LOCATION."/test/test/com_xipt/front/images/avatar_3.gif");
    $this->click("file-upload-submit");
    $this->waitPageLoad();
	}
	$this->assertTrue($this->isTextPresent('User Registered.'));
  }

  function checkAccessEvent($id,$verify)
  {
  	 $this->open("index.php?option=com_community&view=events&task=viewevent&eventid=$id&Itemid=53");
  	 $this->waitPageLoad();
  	 $this->verifyRestrict($verify);
  }

  function testACLRules0()
  {
  	  $filter['floodLimit']=1;
  	  $this->changeJomSocialConfig($filter);
  	  
  	  //login as admin user
      $user = JFactory::getUser(82);//regtest8774090
  	  $this->frontLogin($user->username,$user->username);
  	  $userid=82;
  	  
  	  //test all rules
  	  	$this->checkCreateGroup($userid,False);
  	  	$groupid=4;    
	    $this->checkJoinGroup($userid,$groupid,False);
	    //userid 81 has ptype=3 ,so 82 can add 81 as friend
	    $this->checkAddAsFriend($userid,81,True);
	    //one album allowed 	    
	    $albumID = $this->checkCreateAlbum($userid,True);
	    $this->checkCreateAlbum($userid,False);
	    $this->checkAddPhotos($userid,$albumID,False);
	    $this->checkAddVideos($userid,False);
	    $this->checkSendMessage($userid,81,False);
	    $this->checkChangeAvatar($userid,False);
	    $this->checkChangePrivacy($userid,False);
	    $this->checkEditProfile($userid,False);
	    $this->checkEditProfileDetails($userid,False);
	   	// sud not be allowed to access ptype2
	    $this->checkVisitProfile($userid,83,False);
		//sud able to access ptype3
	    $this->checkVisitProfile($userid,84,True);
    
	  $this->frontLogout();
  } 
  
  
  function testACLRules1()
  {
  	  //login as admin user
      $user = JFactory::getUser(82);//regtest8774090
  	  $this->frontLogin($user->username,$user->username);
  	  $userid=82;
  	  
		$this->checkCreateGroup($userid,True);
		$groupid=4;
	    $this->checkJoinGroup($userid,$groupid,True);
	    //userid 82 can't add any one as friend
	    $this->checkAddAsFriend($userid,81,False);	    
	    $this->checkAddAsFriend($userid,85,False);	    
	    $this->checkAddAsFriend($userid,86,False);
	    
	    $albumID = $this->checkCreateAlbum($userid,True);    
	    $this->checkAddPhotos($userid,$albumID,True);
	    $this->checkAddVideos($userid,True);
	    $this->checkSendMessage($userid,81,True);  
	    $this->checkChangeAvatar($userid,True);
	    $this->checkChangePrivacy($userid,True);
	    $this->checkEditProfile($userid,True);
	    $this->checkEditProfileDetails($userid,True);
	    // sud be allowed to access ptype2
	    $this->checkVisitProfile($userid,83,True);
	    
	  $this->frontLogout();
  }
 
  
function testACLRules2()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
  	  // we will test other profiltype effect here
	  $user = JFactory::getUser(82); // type1
  	  $this->frontLogin($user->username,$user->username);
  	  	//1 write Msg to type 1 : 2
  	  	$this->checkSendMessage(82,85,True);
  	  	$this->checkSendMessage(82,85,True);
  	  	$this->checkSendMessage(82,85,False);
  	  	
  	  	//1 cannot msg type 2 : 0
  	  	$this->checkSendMessage(82,83,False);
  	  	
  	  	//1 can msg to 3 : 1
  	  	$this->checkSendMessage(82,84,True);
  	  	$this->checkSendMessage(82,84,False);
	  $this->frontLogout();
	  
	  
	  //===============================================
	  $user = JFactory::getUser(83); // type2
  	  $this->frontLogin($user->username,$user->username);
	    //type2 cannot write message : ALL
  	  	$this->checkSendMessage(83,79,False);
  	  	$this->checkSendMessage(83,80,False);
  	  	$this->checkSendMessage(83,81,False);
  	  $this->frontLogout();
	  
	  //===============================================
	  $user = JFactory::getUser(84); // type3
  	  $this->frontLogin($user->username,$user->username);
  	  	$this->checkSendMessage(84,79,True);
  	  	$this->checkSendMessage(84,80,True);
  	  	$this->checkSendMessage(84,81,True);
  	  $this->frontLogout();  
  } 
  function testACLRules3()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
  	  // type1
	  $user = JFactory::getUser(82); 
  	  $this->frontLogin($user->username,$user->username);
  	  	//type1 cannot see type2 
  	  	$this->checkVisitProfile(82,80,False);
  	  	$this->checkVisitProfile(82,83,False);
  	  	$this->checkVisitProfile(82,86,False);  	  	
	  $this->frontLogout();
	  
	  //===============================================
	  $user = JFactory::getUser(83); // type2
  	  $this->frontLogin($user->username,$user->username);
  	  	//type2 cannot see type 1/2/3 
  	  	$this->checkVisitProfile(83,79,False);
  	  	$this->checkVisitProfile(83,80,False);
  	  	$this->checkVisitProfile(83,81,False);
  	  	$this->checkVisitProfile(83,83,False); // check self  	  	
	  $this->frontLogout();
	  
	  
	  //===============================================
	  $user = JFactory::getUser(84); // type3
  	  $this->frontLogin($user->username,$user->username);
  	  	//type3 cannot see type 3 
  	  	$this->checkVisitProfile(84,79,True);
  	  	$this->checkVisitProfile(84,80,True);
  	  	$this->checkVisitProfile(84,81,False);  	  	
	  $this->frontLogout(); 
  }

  function testACLRulesUpgradeRedirection()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	$filter['aec_integrate']=1;
	$this->changeJSPTConfig($filter);
	$user = JFactory::getUser(83); 
  	$filter['aec_integrate']=1;
	$this->changeJSPTConfig($filter);

  	$this->open(JOOMLA_LOCATION."/index.php");
    $this->waitPageLoad();
    $this->type("modlgn_username", $user->username);
    $this->type("modlgn_passwd", $user->username);
    $this->click("//form[@id='form-login']/fieldset/input");
    $this->waitPageLoad();
	//type 2 can not do any thing
  	// should go to plan selection page
  	$this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
  	$this->click("submit");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Confirmation"));
    $this->click("//input[@value='Continue']");
    $this->waitForPageToLoad();
    $this->assertTrue($this->isTextPresent("Thank You!"));
    $this->assertTrue($this->isTextPresent("Subscription Complete!"));
    
	$this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=frontpage");
	$this->waitPageLoad();  
	$this->frontLogout(); 
	$this->_DBO->addTable('#__xipt_users');
  }
  
  function testACLRulesDeleteGroup()
  {
  	$version = XiSelTestCase::get_js_version();
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	$user = JFactory::getUser(83); 
  	
  	$this->open(JOOMLA_LOCATION."/index.php");
    $this->waitPageLoad();
    $this->type("modlgn_username", $user->username);
    $this->type("modlgn_passwd", $user->username);
    $this->click("//form[@id='form-login']/fieldset/input");
    $this->waitPageLoad();
    $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=groups&task=viewgroup&groupid=3");
    $this->waitPageLoad();
    $this->click("//a[@onclick=\"javascript:joms.groups.deleteGroup('3');\"]");
	$this->waitForElement("cwin_tm");
	sleep(1);
	$this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
	$this->click("//input[@type='button'][@onclick=\"jax.call('community', 'groups,ajaxDeleteGroup', '3', 1);\"]");
	$this->waitForElement("cwin_tm");
	sleep(1);
	
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
    $this->frontLogout();
    
    $user = JFactory::getUser(84); 
  	
  	$this->open(JOOMLA_LOCATION."/index.php");
    $this->waitPageLoad();
    $this->type("modlgn_username", $user->username);
    $this->type("modlgn_passwd", $user->username);
    $this->click("//form[@id='form-login']/fieldset/input");
    $this->waitPageLoad();
    $this->open(JOOMLA_LOCATION."/index.php?option=com_community&view=groups&task=viewgroup&groupid=4");
    $this->waitPageLoad();
    $this->click("//a[@onclick=\"javascript:joms.groups.deleteGroup('4');\"]");
	$this->waitForElement("cwin_tm");
	sleep(2);
	if(Jstring::stristr($version,'1.8'))
		$this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
	else 
		$this->assertFalse($this->isTextPresent("You are not allowed to delete groups"));
	
	$this->click("//input[@onclick=\"jax.call('community', 'groups,ajaxDeleteGroup', '4', 1);\"]");
	$this->waitForElement("cwin_tm");
	sleep(3);
	
	if(Jstring::stristr($version,'1.8'))
		$this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
	else
		$this->assertFalse($this->isTextPresent("You are not allowed to delete groups"));

	$this->click("//input[@id='groupDeleteDone']");
    
    $this->frontLogout();
    $this->_DBO->addTable('#__community_groups');
    $this->_DBO->filterColumn('#__community_groups','thumb');
    $this->_DBO->filterColumn('#__community_groups','avatar');
    $this->_DBO->addTable('#__community_groups_members');    
  }
  
  
    function testAccessVideo()
   {
   	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
  	
   	 $user = JFactory::getUser(82); // type1
  	 $this->frontLogin($user->username,$user->username);
  	  //pt1 can access video of pt2
  	 $this->checkAccessVideo(82,85,1,True); 
  	 $this->checkAccessVideo(82,86,2,False);
  	 $this->checkAccessVideo(82,87,3,True);
  	 $this->frontLogout();
  	 
  	 
  	 $user = JFactory::getUser(83); // type2
  	 $this->frontLogin($user->username,$user->username);
  	  //pt2 cant  see video of pt3
  	 $this->checkAccessVideo(83,85,1,True);
  	 $this->checkAccessVideo(83,86,2,True);
  	 $this->checkAccessVideo(83,87,3,False);
  	 $this->frontLogout();
  	  
  	  
  	 //pt3 cant see video of pt1
  	 $user = JFactory::getUser(84); // type3
  	 $this->frontLogin($user->username,$user->username);
  	
  	 $this->checkAccessVideo(84,85,1,False);
  	 $this->checkAccessVideo(84,86,2,True);
  	 $this->checkAccessVideo(84,87,3,True);
  	 $this->frontLogout();
  	  
   }
   function testAccessGroup()
   {
   	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
  	 // type1
   	$user = JFactory::getUser(82);
  	$this->frontLogin($user->username,$user->username);
  	//pt1 cant access group from pt2
  	$this->checkAccessGroup(82,6,True);
  	$this->checkAccessGroup(82,5,False);
  	$this->checkAccessGroup(82,7,True);
  	$this->frontLogout();
  	
  	//type2
  	$user = JFactory::getUser(83);
  	$this->frontLogin($user->username,$user->username);
  	//pt2 cant access group from pt3
  	$this->checkAccessGroup(83,6,True);
  	$this->checkAccessGroup(83,5,True);
  	$this->checkAccessGroup(83,7,False);
  	$this->frontLogout();
  	
  	//type3
  		$user = JFactory::getUser(84);
  	$this->frontLogin($user->username,$user->username);
  	//pt3 cant access group from pt1
  	$this->checkAccessGroup(84,6,False);
  	$this->checkAccessGroup(84,5,True);
  	$this->checkAccessGroup(84,7,True);
  	$this->frontLogout();
   }
  	
  function testCantChangeRegistrationAvatar()
  {
  	$filter['aec_integrate']=0;
  	$filter['show_ptype_during_reg']=1;
  	$filter['jspt_show_radio']=1;
	$this->changeJSPTConfig($filter);
    $this->registeruser('profiletypes1',0);
  
	//user can change avatar at registration time
	$this->registeruser('profiletypes2',1);
	}
  
  function testFreindsupportInCantViewProfile()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	$user = JFactory::getUser(82); 
  	
  	$this->frontLogin($user->name,$user->name);
  	$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=profile&userid=86');
  	$this->waitPageLoad();
  	$this->assertTrue($this->isTextPresent("You are not allowed to access this resource"));
  	// view profile of friend
  	$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=profile&userid=83');
  	$this->waitPageLoad();
  	$this->assertFalse($this->isTextPresent("You are not allowed to access this resource"));
  } 
  
  function testCantSendMessage()
  {
  	$url = dirname(__FILE__).'/sql/FrontAclRulesTest/testACLRulesDeleteGroup.start.sql';
  	$this->_DBO->loadSql($url);
  	
  	$db		= & JFactory::getDBO();
  	$strSQL	= "INSERT INTO `#__xipt_aclrules` (`rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
  			  ('P1 Cant write message to P2', 'writemessages', 'core_profiletype=1\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=2\nwritemessage_limit=0\nacl_applicable_to_friend=1\n\n', 1)";
  	$db->setQuery( $strSQL );
	$db->query();
  	$strSQL	= "INSERT INTO `#__xipt_aclrules` (`rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
  			  ('P1 Cant write message to p3', 'writemessages', 'core_profiletype=1\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', 'other_profiletype=3\nwritemessage_limit=0\nacl_applicable_to_friend=0\n\n', 1)";
  	$db->setQuery( $strSQL );
  	$db->query();
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	$user = JFactory::getUser(82); 
  	
  	$this->frontLogin($user->name,$user->name);
  	$this->checkSendMessage(82,86,false);
  	$this->checkSendMessage(82,84,false);
  	$this->checkSendMessage(82,85,true);
  	$this->frontLogout();
  	
  	$strSQL = 'TRUNCATE TABLE `#__community_connection`';
  	$db->setQuery( $strSQL );
  	$db->query();
  	$strSQL	= "INSERT INTO `#__community_connection` (`connection_id`, `connect_from`, `connect_to`, `status`, `group`, `created`, `msg`) VALUES
			  (1, 85, 84, 1, 0, NULL, ''),
			  (2, 84, 82, 1, 0, NULL, '')";
  	$db->setQuery( $strSQL );
  	$db->query();
  	$user = JFactory::getUser(85); 
  	
  	$this->frontLogin($user->name,$user->name);
  	$this->checkSendMessage(85,86,false);
  	$this->checkSendMessage(85,84,true);
  	$this->checkSendMessage(85,82,true);
  	$this->frontLogout();
  	
  	
  }
  
 function testCantChangeStatus()
 {
 	
 	
   	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
  	
   	$user = JFactory::getUser(82); // type1
  	$this->frontLogin($user->username,$user->username);
  	  //pt1 can change status
  	$this->checkStatusBox(); 
  	$this->frontLogout();
  	 
  	$user = JFactory::getUser(83); // type2
  	$this->frontLogin($user->username,$user->username);
  	  //pt1 can change status
  	$this->checkStatusBox(); 
  	$this->frontLogout();
  	 
  	
  	$user = JFactory::getUser(84); // type3
  	$this->frontLogin($user->username,$user->username);
  	  //pt1 can change status
  	$this->checkStatusBox(); 
  	$this->frontLogout();
  	$this->_DBO->addTable('#__community_users');
  	$this->_DBO->filterColumn('#__community_users','posted_on');
  	$this->_DBO->filterColumn('#__community_users','points');
  	$this->_DBO->filterColumn('#__community_users','alias');
  	$this->_DBO->filterColumn('#__community_users','latitude');
  	$this->_DBO->filterColumn('#__community_users','longitude');
  }

  function testCreateEvent()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
  	$user = JFactory::getUser(82); // type1
  	$this->frontLogin($user->username,$user->username);
  	  //pt1 can create atmost 2 events
  	$this->checkCreateEvent(true,9,10);
  	$this->checkCreateEvent(true,10,11);
  	$this->checkCreateEvent(false,11,12);
    $this->frontLogout();
    
    $user = JFactory::getUser(83); // type2
  	$this->frontLogin($user->username,$user->username);
  	  //pt2 can't create events
  	$this->checkCreateEvent(false,7,8);
  	$this->frontLogout();
  	$this->_DBO->addTable('#__community_events');
  	$this->_DBO->filterColumn('#__community_events','created');
 	$this->_DBO->filterColumn('#__community_events','startdate');
  	$this->_DBO->filterColumn('#__community_events','enddate');
  }
  function testAccessEvent()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
  	$user = JFactory::getUser(82); // type1
  	$this->frontLogin($user->username,$user->username);
  	//pt1 can't access event of pt2
  	$this->checkAccessEvent(1,true);
  	$this->checkAccessEvent(3,false);
  	$this->checkAccessEvent(4,true);
  	$this->frontLogout();

  	$user = JFactory::getUser(83); // type1
  	$this->frontLogin($user->username,$user->username);
  	//pt2 can't access event of pt3
  	$this->checkAccessEvent(1,true);
  	$this->checkAccessEvent(3,true);
  	$this->checkAccessEvent(4,false);
  	$this->frontLogout();

  	$user = JFactory::getUser(84); // type1
  	$this->frontLogin($user->username,$user->username);
  	//pt3 can't access event of pt1
  	$this->checkAccessEvent(1,false);
  	$this->checkAccessEvent(3,true);
  	$this->checkAccessEvent(4,true);
  	$this->frontLogout();
  }	

  function testDeleteEvent()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
  	$user = JFactory::getUser(82); // type1
  	$this->frontLogin($user->username,$user->username);
  	$this->open("index.php?option=com_community&view=events&task=viewevent&eventid=11&Itemid=53");
  	$this->waitPageLoad();
  	$this->click("//a[@onclick=\"javascript:joms.events.deleteEvent('11');\"]");
  	$this->waitForElement("cwin_tm");
	sleep(1);
    $this->assertTrue($this->isTextPresent("Are you sure want to delete this event?"));
	$this->click("//input[@onclick=\"jax.call('community', 'events,ajaxDeleteEvent', '11', 1);\"]");
    $this->waitForElement("cwin_tm");
    sleep(2);
    $this->assertTrue($this->isTextPresent("Event deleted"));
    $this->frontLogout();
    
    $user = JFactory::getUser(83); // type2
  	$this->frontLogin($user->username,$user->username);
  	//pt2 cant delete event
  	$this->open("index.php?option=com_community&view=events&task=viewevent&eventid=12&Itemid=53");
  	$this->waitPageLoad();
  	$this->click("//a[@onclick=\"javascript:joms.events.deleteEvent('12');\"]");
  	$this->waitForElement("cwin_tm");
	sleep(1);
    $this->assertTrue($this->isTextPresent("Are you sure want to delete this event?"));
	$this->click("//input[@onclick=\"jax.call('community', 'events,ajaxDeleteEvent', '12', 1);\"]");
    $this->waitForElement("cwin_tm");
    sleep(2);
    $this->assertTrue($this->isTextPresent("You are not allowed to access this resource "));
    $this->frontLogout();
    
    $this->_DBO->addTable('#__community_events');
  	$this->_DBO->filterColumn('#__community_events','created');
 	$this->_DBO->filterColumn('#__community_events','startdate');
  	$this->_DBO->filterColumn('#__community_events','enddate');
  	$this->_DBO->filterColumn('#__community_events','hits');
  }
  
}  
  
