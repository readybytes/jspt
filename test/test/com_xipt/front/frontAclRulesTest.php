<?php

class FrontAclRulesTest extends XiSelTestCase 
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
  
  function checkJoinGroup($from, $groupid, $verify)
  {
	$this->open("index.php?option=com_community&view=groups&task=viewgroup&groupid=$groupid&Itemid=53");
	$this->waitPageLoad();
	$this->click("//a[@onclick=\"javascript:joms.groups.joinWindow('$groupid');\"]");
	$this->waitForElement("cwin_tm");
    $this->verifyRestrict($verify);
  }
  
  function checkCreateAlbum($from, $verify)
  {
  	static $counter=1;
  	
    $this->open("index.php?option=com_community&view=photos&task=newalbum&userid=$from&Itemid=53");
	$this->waitPageLoad();
	$this->verifyRestrict($verify);
	
    if($verify)
    {	
	    $this->type("//form[@id='newalbum']/table/tbody/tr[1]/td[2]/input", "Album$counter");
		$this->type("//textarea[@id='description']", "Album$counter");
		$this->click("//form[@id='newalbum']/table/tbody/tr[3]/td[2]/input[2]");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("New Album Created."));
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
}
