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
 	$present = $this->isTextPresent("YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE");
  	$this->assertTrue($verify != $present);
  }
  
  function checkAddProfileVideo($vid,$verify)
  {
     $this->open("index.php?option=com_community&view=profile&task=linkVideo&Itemid=53");
     $this->waitPageLoad();
     $this->click("link=Change profile video");
     sleep(2);
     $this->click("//div[@id='video-$vid']/div/div[1]/a/img");
     $this->click("//button[@onclick='joms.videos.linkProfileVideo($vid);']");
     sleep(2);
     $this->verifyRestrict($verify);
     $this->click("cwin_close_btn");   
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
     $this->click("link=Top 10 Best Web Hosting Reviews - SCAMS EXPOSED");
     $this->verifyRestrict($verify); 
     $this->click("cwin_close_btn");
  }

  function testAddProfileVideo()
  {
     if(TEST_XIPT_JOOMLA_15)
   	 	$url =  dirname(__FILE__).'/sql/AclRuleTest/15/testAddProfileVideo.1.8.sql';
   	 else 
   		 $url =  dirname(__FILE__).'/sql/AclRuleTest/16/testAddProfileVideo.1.8.sql';
     $this->_DBO->loadSql($url);
     $users[1]=array(79,82,85);
     $users[2]=array(80,83,86);
     $users[3]=array(81,84,87);
         
     $user = JFactory::getUser(82);
         
     $this->frontLogin($user->name,$user->name);
     //pt1 can't add profile video
     $this->checkAddProfileVideo(2,false);
     $this->frontLogout();
     $user = JFactory::getUser(83);
         
     $this->frontLogin($user->name,$user->name);
     //pt1 can't add profile video
     $this->checkAddProfileVideo(3,true);
     $this->frontLogout();
     $user = JFactory::getUser(84);
         
     $this->frontLogin($user->name,$user->name);
         //pt1 can't add profile video
     $this->checkAddProfileVideo(4,true);
     $this->frontLogout();
  }
  
  function testDeleteProfileVideo()
  {
   if(TEST_XIPT_JOOMLA_15)
     $url =  dirname(__FILE__).'/sql/AclRuleTest/15/testDeleteProfileVideo.1.8.sql';
   else
     $url =  dirname(__FILE__).'/sql/AclRuleTest/16/testDeleteProfileVideo.1.8.sql';
    $this->_DBO->loadSql($url);
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
  	//$this->_DBO->addTable('#__community_users');
  }
  
  function testAccessProfileVideo()
  {
  	if(TEST_XIPT_JOOMLA_15)
    $url =  dirname(__FILE__).'/sql/AclRuleTest/15/testAccessProfileVideo.1.8.sql';
    else 
    $url =  dirname(__FILE__).'/sql/AclRuleTest/16/testAccessProfileVideo.1.8.sql';
    $this->_DBO->loadSql($url);
    
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
  	if(TEST_XIPT_JOOMLA_15)
  	$url =  dirname(__FILE__).'/sql/AclRuleTest/15/testFriendSupportInAccessProfileVideo.1.8.sql';
  	else 
  	$url =  dirname(__FILE__).'/sql/AclRuleTest/16/testFriendSupportInAccessProfileVideo.1.8.sql';
    $this->_DBO->loadSql($url);
  	$users[1]=array(79,82,85);
  	$users[2]=array(80,83,86);
  	$users[3]=array(81,84,87);
  	
	
  	$user = JFactory::getUser(82); 
  	
  	 $this->frontLogin($user->name,$user->name);
  	//pt1 can't access pt2  profile video(not applicable to friend(83))
  	 $this->checkAccessProfileVideo(86,false);
     $this->checkAccessProfileVideo(83,true);
     $this->frontLogout();
     
     $user = JFactory::getUser(83); 
  	
  	 $this->frontLogin($user->name,$user->name);
  	//pt2 can't access pt3  profile video(applicable to friend(84))
     $this->checkAccessProfileVideo(84,false);
     $this->checkAccessProfileVideo(87,false);
     $this->frontLogout();

  }
  
  function testCantReplyMessage()
  {
  	 $user = JFactory::getUser(82); 
     $this->frontLogin($user->name,$user->name);
     $this->open("index.php?option=com_community&view=inbox&Itemid=53");
     $this->waitPageLoad();
     $this->click("link=Inbox");
  	 $this->waitPageLoad();
   	 $this->click("link=testmessage");
  	 $this->waitPageLoad();
   	 $this->type("replybox", "testreply");
   	 $this->click("replybutton");
   	  sleep(2);
     $this->verifyRestrict(false);
     $this->frontLogout();  
  }
 } 