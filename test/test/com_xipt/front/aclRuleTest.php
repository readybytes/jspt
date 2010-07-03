<?php

class AclRuleTest extends XiSelTestCase 
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
  
  function checkAddProfileVideo($id,$vid,$verify)
  {
  	$this->open("index.php?option=com_community&view=videos&task=video&userid=$id&videoid=$vid&Itemid=53");
	$this->waitPageLoad();
	$this->click("link=Set as profile video");
	sleep(2);
    $this->click("//button[@onclick='joms.videos.linkProfileVideo($vid);']");
	$this->waitForElement("cwin_tm");
	//sleep(1);
    $this->verifyRestrict($verify);
  }
  
  function checkDeleteProfileVideo($id,$vid,$verify)
  {
  	$this->open("index.php?option=com_community&view=profile&task=linkVideo&Itemid=53");
  	$this->waitPageLoad();
  	$this->click("link=Remove Profile Video");
    sleep(2);
    $this->click("//button[@onclick='joms.videos.removeLinkProfileVideo($id, $vid);']");
  	$this->waitForElement("cwin_tm");
  	$this->verifyRestrict($verify);
  }
    
  function checkAccessProfileVideo($id,$verify)
  {
  	 $this->open("index.php?option=com_community&view=profile&userid=$id&Itemid=53");
	 $this->waitPageLoad();
     $this->click("link=My Profile Video");
     $this->verifyRestrict($verify); 
  }
  function testAddProfileVideo()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	$user = JFactory::getUser(82); 
  	
  	$this->frontLogin($user->name,$user->name);
  	//pt1 can't add profile video
  	$this->checkAddProfileVideo(82,2,false);
    $this->frontLogout();
  	$user = JFactory::getUser(83); 
  	
  	$this->frontLogin($user->name,$user->name);
  	//pt1 can't add profile video
  	$this->checkAddProfileVideo(82,3,true);
    $this->frontLogout();
    $user = JFactory::getUser(84); 
  	
  	$this->frontLogin($user->name,$user->name);
  	//pt1 can't add profile video
  	$this->checkAddProfileVideo(84,4,true);
    $this->frontLogout();
  }
  
  function testDeleteProfileVideo()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	$user = JFactory::getUser(82); 
  	
  	$this->frontLogin($user->name,$user->name);
  	//pt1 can't delete profile video
  	$this->checkDeleteProfileVideo(82,2,false);
  	$this->frontLogout();
  	
  	$user = JFactory::getUser(83); 
  	
  	$this->frontLogin($user->name,$user->name);
  	//pt1 can't delete profile video
  	$this->checkDeleteProfileVideo(83,3,true);
  	$this->frontLogout();
  	
  	$user = JFactory::getUser(84); 
  	
  	$this->frontLogin($user->name,$user->name);
  	//pt1 can't delete profile video
  	$this->checkDeleteProfileVideo(84,4,true);
  	$this->frontLogout();
  	$this->_DBO->addTable('#__community_users');
  	
  }
  
  function testAccessProfileVideo()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	$user = JFactory::getUser(82); 
  	
  	$this->frontLogin($user->name,$user->name);
  	//pt1 can't access pt2  profile video
    $this->checkAccessProfileVideo(83,false);
	$this->checkAccessProfileVideo(84,true);
	$this->frontLogout();
	
	$user = JFactory::getUser(83); 
  	
  	$this->frontLogin($user->name,$user->name);
  	//pt1 can't access pt2  profile video
    $this->checkAccessProfileVideo(82,true);
	$this->checkAccessProfileVideo(84,true);
	$this->frontLogout();
	
  }
  
  function testFriendSupportInAccessProfileVideo()
  {
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	
  	$user = JFactory::getUser(82); 
  	
  	 $this->frontLogin($user->name,$user->name);
  	//pt1 can't access pt2  profile video(not applicable to friend(83))
     $this->checkAccessProfileVideo(83,true);
     $this->checkAccessProfileVideo(86,false);
     $this->frontLogout();
     
     $user = JFactory::getUser(83); 
  	
  	 $this->frontLogin($user->name,$user->name);
  	//pt2 can't access pt3  profile video(applicable to friend(84))
     $this->checkAccessProfileVideo(84,false);
     $this->checkAccessProfileVideo(87,false);
     $this->frontLogout();
  }
  
  
 } 